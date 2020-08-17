<?php

if (version_compare($version_old, '7.0.0.2', '<'))
{
    $path = sfConfig::get("sf_root_dir")."/plugins/stImportExportPlugin/modules/stImportExportBackend/templates";
    
    $files = array(
        "_edit_form.php",
        "editSuccess.php",
    );
    
    foreach ($files as $file) 
    {
        if (is_file($path."/".$file))
        {
            unlink($path."/".$file);
        }
    }
    
}