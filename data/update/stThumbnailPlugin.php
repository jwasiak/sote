<?php
if (version_compare($version_old, '1.0.2.2', '<'))
{
    unlink(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'sfThumbnailPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stThumbnail.class.php');
}

if (version_compare($version_old, '7.0.1.7', '<'))
{
    stConfig::getInstance('stAsset')->save(true);
}