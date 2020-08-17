<?php
try {
	if (version_compare($version_old, '1.2.0.6', '<'))
    {
        $theme_name = 'stThemeDefault2';
        $backup = array(
            'apps/frontend/templates/theme/default2/container_head.html' => 'a773c55f4db8104bbb62c49842bebbe7',
            'packages/stThemeDefault2/ignore.yml' => 'aaac6bb76cf9d9fa2aeb4ee59f155d91',
            'packages/stThemeDefault2/package.yml' => '80f7290b613e91108da7ac2f344a5846',
            'web/css/frontend/theme/default2/theme.less' => '4eae5f38beb064907cf13a76749e097d',
            'web/css/frontend/theme/default2/two_column_layout.less' => 'a1a7a7cb6d960e71cff25b082a8fd69e',
        );

        foreach ($backup as $file=>$checksum) {
            if (md5_file(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file) == $checksum) {
                if (preg_match('/\.html$/', $file))
                    copy(   sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$theme_name.DIRECTORY_SEPARATOR.$theme_name.DIRECTORY_SEPARATOR.$file, 
                            sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file);
                elseif (preg_match('/\.less$/', $file))
                   copy(   sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$theme_name.DIRECTORY_SEPARATOR.$theme_name.DIRECTORY_SEPARATOR.$file, 
                           sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file);
                else
                   copy(   sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$theme_name.DIRECTORY_SEPARATOR.$file, 
                            sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file);
            }
        }
       unlink(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.'stThemeDefault2'.DIRECTORY_SEPARATOR.'ignore.yml');
    }
} catch (Exception $e) {}

try {
    if (version_compare($version_old, '1.4.0.0', '<')) {
        $config = stConfig::getInstance('stThemeDefault2');
        $config->set('show', true);
        $config->save(true);
    }
} catch (Exception $e) {}