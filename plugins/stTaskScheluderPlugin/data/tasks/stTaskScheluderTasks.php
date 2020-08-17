<?php

pake_desc('(SOTE) Task scheluder');
pake_task('task-scheluder', 'project_exists');

function run_task_scheluder($task, array $args = array(), array $options = array())
{
    define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
    define('SF_APP', isset($options['app']) ? $options['app'] : 'backend');
    define('SF_ENVIRONMENT', isset($options['environment']) ? $options['environment'] : 'prod');
    define('SF_DEBUG', true);

    $_SERVER['SCRIPT_NAME'] = '/backend.php';

    // get configuration
    require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

    if (floatval(phpversion()) < 7.1)
    {
        $i18n = sfContext::getInstance()->getI18N();
        pake_echo_error($i18n->__('Do poprawnego działania moduł wymaga wersji PHP 7.1.x (aktualnie ustawiona wersja PHP: %version%)', array('%version%' => phpversion()), 'stTaskScheluderBackend'));
        exit;
    }
    
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $dispatcher = stEventDispatcher::getInstance();

    $dispatcher->connect('task.logger.log', 'st_task_logger');

    $config = stConfig::getInstance('stTaskScheluderBackend');
    $config->set('last_execute_timestamp', time());
    $config->save();

    if (!stLock::check('backend'))
    {
        throw new Exception("Aplikacja zablokowana - Wykonywanie harmonogramu zadań zostaje przerwane");
    }

    stTaskScheluder::initialize();

    foreach(stTaskScheluder::getTasks() as $task)
    {
        if (!stLock::check('backend'))
        {
            throw new Exception("Aplikacja zablokowana - Wykonywanie harmonogramu zadań zostaje przerwane");
        }

        $offset = 0;

        if (!$task->isReadyToExecute() && !isset($options['force']))
        {
            continue;
        }

        $count = $task->doCount();

        while($count > $offset)
        {
            $offset = $task->doExecute($offset);
        }
    }    
}

if (!function_exists('pake_echo_error'))
{
    function pake_echo_error($message)
    {
        if (pakeApp::get_instance()->get_verbose())
        {
            echo pakeColor::colorize($message, 'ERR')."\n";
        }      
    }
}

function st_task_logger(sfEvent $event)
{
    /**
     * @var stTaskInterface
     */
    $task = $event['task'];

    $i18n = sfContext::getInstance()->getI18N();

    if ($event['type'] == stTaskLogger::TYPE_ERROR)
    {
        pake_echo_error($i18n->__($event['message'], $event['message_params'], get_class($task)));
    }
    else
    {
        pake_echo_action($task->getName(), $i18n->__($event['message'], $event['message_params'], get_class($task)));
    }
}