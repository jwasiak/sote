<?php
try {
	if (version_compare($version_old, '1.2.0.13', '<'))
    {
        unlink(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.'stThemeDefault2'.DIRECTORY_SEPARATOR.'ignore.yml');
    }
} catch (Exception $e) {}
