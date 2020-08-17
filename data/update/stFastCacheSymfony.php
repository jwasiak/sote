<?php

if (version_compare($version_old, '7.2.0.2', '<'))
{
    foreach (array(sfConfig::get('sf_root_dir').'/fastcache', sfConfig::get('sf_root_dir').'/apps/frontend/modules/stFastCacheFrontend', sfConfig::get('sf_root_dir').'/apps/backend/modules/stFastCache/templates') as $dir)
    {
        if (is_dir($dir))
        {
            sfToolkit::clearDirectory($dir);  
            rmdir($dir);
        }
    }
}
