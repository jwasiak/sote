<?php
use_helper('stDate');
if (!$config->get('last_execute_timestamp') || time() - $config->get('last_execute_timestamp') > 60 * 5 + 10)
{
    echo __('Zadanie cron nie zostało poprawnie skonfigurowane. Zadanie cron musi być uruchamiane co 5 minut');
}
else
{
    $date = st_format_date($config->get('last_execute_timestamp'));
    echo __('Ostatnie uruchomienie zadania cron: %date%', array('%date%' => strtolower($date)));
}