<?php

set_include_path(sfConfig::get('sf_root_dir').'/plugins/sfMinifyPlugin/lib/minify/'.PATH_SEPARATOR.get_include_path());

/**
 * Return one <script> tag for all javascripts configured in view.yml or added to the response object.
 *
 * You can use this helper to decide the location of javascripts in pages.
 * By default, if you don't call this helper, symfony will automatically include javascripts before </head>.
 * Calling this helper disables this behavior.
 *
 * @return string <script> tag
 */
function minify_get_javascripts($response, $minify)
{
   $ignore = array('/stCategoryTreePlugin/js/jquery-1.3.2.min.js' => true, '/stCategoryTreePlugin/js/jquery-no-conflict.js' => true);

   $html = '';

   $response->setParameter('javascripts_included', true, 'symfony/view/asset');

   $already_seen = array();

   $minify_files = array();

   $hash = '';

   $last_modified = 0;

   foreach (array('first', '', 'last') as $position)
   {
      foreach ($response->getJavascripts($position) as $files)
      {
         if (!is_array($files))
         {
            $files = array($files);
         }

         foreach ($files as $file)
         {
            if (isset($already_seen[$file]) || isset($ignore[$file]))
            {
               continue;
            }

            $already_seen[$file] = 1;

            $file = javascript_path($file);

            if ($minify)
            {
               $hash .= $file;

               $file = sfConfig::get('sf_web_dir').$file;

               $minify_files[] = $file;

               $fmt = filemtime($file);

               if ($fmt > $last_modified)
               {
                  $last_modified = $fmt;
               }
            }
            else
            {
               $html .= javascript_include_tag($file);
            }
         }
      }
   }

   if (!$minify)
   {
      return $html;
   }

   $filename = _minify_compute_filename(md5($hash), 'js');

   $output_file = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.$filename;

   _minify_files($minify_files, $last_modified, $output_file);

   return content_tag('script', '', array('src' => '/cache/js/'.$filename.'?lm='.$last_modified, 'type' => 'text/javascript'))."\n";
}

/**
 * Print <script> tag for all javascripts configured in view.yml or added to the response object.
 *
 * @see minify_get_javascripts()
 */
function minify_include_javascripts()
{
   echo minify_get_javascripts();
}

/**
 * Return one <link> tag for all stylesheets configured in view.yml or added to the response object.
 *
 * You can use this helper to decide the location of stylesheets in pages.
 * By default, if you don't call this helper, symfony will automatically include stylesheets before </head>.
 * Calling this helper disables this behavior.
 *
 * @return string <link> tags
 */
function minify_get_stylesheets($response, $minify, $output_folder = 'cache/css')
{
   $response->setParameter('stylesheets_included', true, 'symfony/view/asset');

   $already_seen = array();

   $minify_files = array();

   $hash = '';

   $last_modified = 0;

   $html = '';

   foreach (array('first', '', 'last') as $position)
   {
      foreach ($response->getStylesheets($position) as $file => $options)
      {
         if (isset($already_seen[$file]))
         {
            continue;
         }

         $already_seen[$file] = 1;

         $file = stylesheet_path($file);

         if ($minify)
         {

            $hash .= $file;

            $file_path = sfConfig::get('sf_web_dir').$file;

            $fmt = filemtime($file_path);

            if ($fmt > $last_modified)
            {
               $last_modified = $fmt;
            }

            $minify_files[] = $file_path;
         }
         else
         {
            $html .= stylesheet_tag($file, $options);
         }
      }
   }

   if (!$minify)
   {
      return $html;
   }

   $filename = _minify_compute_filename(md5($hash), 'css');

   $output_file = sfConfig::get('sf_web_dir').'/'.$output_folder.'/'.$filename;

   _minify_files($minify_files, $last_modified, $output_file);

   return tag('link', array('href' => '/'.$output_folder.'/'.$filename.'?lm='.$last_modified, 'rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'screen'))."\n";
}

function minify_get_less($response, $output_folder = 'cache/less')
{
   $holder = $response->getParameterHolder();

   $last_modified = 0;

   $hash = '';

   foreach (array('first', '', 'last') as $position)
   {
      foreach ($holder->getAll('helper/asset/auto/less'.($position ? '/'.$position : '')) as $file => $options)
      {
         $file = stylesheet_path($file);

         $hash .= $file;

         $file_path = sfConfig::get('sf_web_dir').'/'.$file;

         $fmt = filemtime($file_path);

         if ($fmt > $last_modified)
         {
            $last_modified = $fmt;
         }

         $minify_files[] = $file_path;
      }
   }

   $filename = _minify_compute_filename(md5($hash), 'less');

   $output_file = sfConfig::get('sf_web_dir').'/'.$output_folder.'/'.$filename;

   _minify_files($minify_files, $last_modified, $output_file);

   return tag('link', array('href' => '/'.$output_folder.'/'.$filename.'?lm='.$last_modified, 'rel' => 'stylesheet/less'))."\n";
}

/**
 * Print <link> tag for all stylesheets configured in view.yml or added to the response object.
 *
 * @see minify_get_stylesheets()
 */
function minify_include_stylesheets()
{
   echo minify_get_stylesheets();
}

function _minify_files($files, $last_modified, $output_file)
{
   $is_file = is_file($output_file);

   if (!$is_file || $is_file && filemtime($output_file) < $last_modified)
   {
      require_once 'Minify.php';

      $data = Minify::serve('Files', array('files' => $files, 'encodeOutput' => false, 'quiet' => true, 'encodeLevel' => 5));

      $output_dir = dirname($output_file);

      if (!file_exists($output_dir))
      {
         mkdir($output_dir, 0755, true);
      }

      file_put_contents($output_file, $data['content']);
   }
}

function _minify_compute_filename($filename, $ext)
{
   return $filename.'.'.$ext;
}