<?php
try {
	if (version_compare($version_old, '7.2.0.0', '<=')) {
		$file = sfConfig::get('sf_web_dir').'/sfMinifyPlugin.php';
		if (file_exists($file))
			@unlink($file);
	}
} catch (Exception $e) {
	// @todo: log $e->getMessage();
}
