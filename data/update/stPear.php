<?php
try {
	if (version_compare($version_old, '1.1.0.0', '<'))
	{
		$pear_dir = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'pear'.DIRECTORY_SEPARATOR.'php'.DIRECTORY_SEPARATOR.'PEAR';

		if (is_file($pear_dir.DIRECTORY_SEPARATOR.'Dependency.php')) unlink($pear_dir.DIRECTORY_SEPARATOR.'Dependency.php');
		
		if (is_file($pear_dir.DIRECTORY_SEPARATOR.'Remote.php')) unlink($pear_dir.DIRECTORY_SEPARATOR.'Remote.php');
	}
} catch (Exception $e) {}