<?php

$src = $data['src'];

$for = $data['for'];

$type = $data['type'];

$options = _tag_options($data['options']);

if ($src instanceof sfAsset)
{
   $src = $src->getRelativePath();
}
elseif (is_object($src) && method_exists($src, 'getOptImage'))
{
   $src = $src->getOptImage();
}

if (!$src)
{
   $src = 'media/shares/no_image.png';
}
 
$path = dirname($src);

$filename = basename($src);

$img_from = sfAssetsLibraryTools::fixPath(sfAssetsLibraryTools::getThumbnailPath($path, $filename));

$config_file = sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'__stAsset.yml';

$img_to = sfAssetsLibraryTools::fixPath(sfAssetsLibraryTools::getThumbnailPath($path, $filename, $type));

$thumb_src = sfAssetsLibraryTools::createAssetUrl($path, $filename, $type, false);
if ($type != 'full')
{
  $options = str_replace("'", '\\'."'", $options);
echo <<<PHP
<?php
if (!isset(\$config_time))
{
   \$config_time = is_file('$config_file') ? filemtime('$config_file') : 0;
}

\$time_from = max(array(filemtime('$img_from'), \$config_time));

if (!is_file('$img_to') || \$time_from > filemtime('$img_to'))
{
    echo '<img src="/stThumbnailPlugin.php?i=$src&t=$type&f=$for&u='.\$time_from.'" $options />';
}
else
{
    echo '<img src="$thumb_src?lm='.\$time_from.'" $options />';
}
?>
PHP;
}
else
{
    if (!isset($config_time))
    {
       $config_time = is_file($config_file) ? filemtime($config_file) : 0;
    }

    $time_from = max(array(filemtime($img_from), $config_time));    
    echo '<img src="'.$thumb_src.'?lm='.$time_from.'" '.$options.' />';
}
?>