<?php
use_helper('stUrl');

function st_jquery_tree_init($id, $params = array())
{
   use_javascript('/stCategoryTreePlugin/js/jquery.treeview.js');

   if (!isset($params['collapsed']))
   {
      $params['collapsed'] = true;
   }

   if (!isset($params['animated']))
   {
      $params['animated'] = 'fast';
   }

   if (!isset($params['prerendered']))
   {
      $params['prerendered'] = true;
   }

   if (isset($params['url']))
   {
      $params['url'] = st_url_for($params['url']);
   }

   $json = json_encode($params);

   $js = <<<JS
   <script type="text/javascript">
      jQuery(function($) {
            $('#st_category-tree-$id').treeview($json);
      });
   </script>
JS;

   return $js;
}