<?php
try {
	if (version_compare($version_old, '1.2.1.6', '<')) {
		$file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'stCeneoPlugin'.
		                                     DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'stCeneoBackend'.
		                                     DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'_config_form.php';
		if(file_exists($file)) unlink($file);
	}
} catch (Exception $e) {}