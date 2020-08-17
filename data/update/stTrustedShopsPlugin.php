<?php 

try {
    if (version_compare($version_old, '7.1.0.0', '<')) {
        $files = array(                
                'plugins/stTrustedShopsPlugin/modules/stTrustedShopsBackend/validate/edit.yml',
            );

        foreach ($files as $file)
            if(file_exists(sfConfig::get('sf_root_dir').'/'.$file))
                unlink(sfConfig::get('sf_root_dir').'/'.$file);
    }

} catch (Exception $e) {
    // @todo: log error message
}
