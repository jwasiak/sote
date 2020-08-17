<?php

// for older version than 1.0.8 build product indexes
if (version_compare($version_old, '1.2.0.40', '<'))
{
        $config= stConfig::getInstance(sfContext::getInstance(), 'stSearchBackend');
        $config->set('enable_new',0);
        $config->save();
}
