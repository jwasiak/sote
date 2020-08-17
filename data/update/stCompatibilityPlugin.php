<?php

if (version_compare($version_old, '2.2.7.3', '<'))
{
    $config = stConfig::getInstance('stCompatibilityBackend');
    $config->set('terms_in_mail_confirm_order_format', 'text');
    $config->set('right_2_cancel_in_mail_confirm_order_format', 'text');
    $config->save(true);
}