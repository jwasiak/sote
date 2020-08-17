<?php
if (version_compare($version_old, '2.0.0.3', '<')) {
    try {
        foreach (array('/config/stPriceCompare.schema.yml', '/apps/backend/modules/stPriceCompare/templates/remindSuccess.php') as $file) {
            $file = SF_ROOT_DIR.str_replace('/', DIRECTORY_SEPARATOR, $file);
            if (file_exists($file)) unlink($file);
        }
    } catch (Exception $e) {}
}