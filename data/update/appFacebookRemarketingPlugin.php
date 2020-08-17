<?php

if (version_compare($version_old, '7.0.0.10', '<'))
{
    $config = stConfig::getInstance('appFacebookRemarketingBackend');

    if ($config->get('enable_fbremarketing') && $config->get('code_fbremarketing', null, true)) 
    {
        stAppStats::activate('Piksel Facebooka');                
    } 
}