<?php
try {
	if (version_compare($version_old, '2.0.0.3', '<')) {
        $file = SF_ROOT_DIR.'/packages/stLockPlugin/ignore.yml'; 
        if (file_exists($file)) unlink($file);
	}
} catch (Exception $e) {}