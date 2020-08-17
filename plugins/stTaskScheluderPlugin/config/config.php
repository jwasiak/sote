<?php

if (SF_APP == 'backend')
{   
    stPluginHelper::addRouting('stTaskScheluderBackend', '/task-scheluder/:action/*', 'stTaskScheluderBackend', 'index');
    stPluginHelper::addEnableModule('stTaskScheluderBackend');
}

if (floatval(phpversion()) >= 7.1)
{
    stTaskConfiguration::addTask(
        'clean_task_scheluder_log', 
        'stCleanTaskLogTask',
        'Czyszczenie logów harmonogramu zadań',
        array(
            'time_interval' => stTaskConfiguration::TIME_INTERVAL_1DAY * 5,
            'is_system' => true,
        )
    );
}