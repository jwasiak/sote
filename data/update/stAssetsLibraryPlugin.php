<?php
try {

    if (version_compare($version_old, '1.0.5.2', '<'))
    {
       $dispatcher = stEventDispatcher::getInstance();

       $dispatcher->connect('stInstallerTaks.onClose', array('stAssetsLibraryListener', 'postInstall'));
    }

    if (version_compare($version_old, '1.1.0.9', '<'))
    {
       $config = stConfig::getInstance('stAsset');

       $product_config = stConfig::getInstance('stProduct');

       $thumbnails = sfConfig::get('app_sfAssetsLibrary_thumbnails', array());

       $watermark = $config->get('watermark', array());

       $watermark['text'] = $product_config->get('watermark_text', $watermark['text']);

       $watermark['alpha'] = $product_config->get('watermark_transparency', $watermark['alpha']);

       $config->set('watermark', $watermark);

       foreach (array('product', 'category', 'producer') as $for)
       {
          $tmp = $config->get($for, array());

          foreach ($thumbnails as $name => $values)
          {
             foreach ($values as $key => $value)
             {
                $tmp[$name][$key] = $value;
             }

             if (!isset($tmp[$name]['quality']))
             {
                $tmp[$name]['quality'] = 100;
             }

             $tmp[$name]['watermark'] = $product_config->get('watermark_on', isset($tmp[$name]['watermark']));
          }

          $config->set($for, $tmp);
       }

       $config->save(true);
    }

    if (version_compare($version_old, '1.2.0.1', '<'))
    {
       $config = stConfig::getInstance('stAsset');

       foreach (array('product', 'category', 'producer') as $for)
       {
          $data = $config->get($for, array());

          foreach ($data as $k => $v)
          {
             $v['auto_crop'] = false;

             $data[$k] = $v;
          }
          
          $config->set($for, $data);
       }
       
       $config->save(true);
    }


    if (version_compare($version_old, '2.0.0.4', '<'))
    {
        $config = stConfig::getInstance('stAsset');

        $data = $config->get('product');

        $data['gallery'] = $data['thumb'];

        $config->set('product', $data);

        $config->save(true);
    }

} catch(Exception $e) { }

try {
    if (version_compare($version_old, '7.2.0.0', '<')) {
        $dir = sfConfig::get('sf_web_dir').'/sfAssetsLibraryPlugin';
        if (is_dir($dir)) {
            sfToolkit::clearDirectory($dir);
            rmdir($dir);
        }
    }
} catch (Exception $e) {
    // @todo: log $e->getMessage();
}