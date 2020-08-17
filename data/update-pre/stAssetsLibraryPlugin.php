<?php
try {
    if (version_compare($version_old, '2.1.0.8', '<')) {
        stConfig::getInstance('stAsset')->save(true);
    }
} catch (Exception $e) {}