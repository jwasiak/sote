<?php

class stTaskScheluder
{
    /**
     * Tworzy listę zadania do wykonania na podstawie konfiguracji
     *
     * @return void
     */
    public static function initialize()
    {
        $tasks = stTaskConfiguration::getTasks();

        $integrity_hash = md5(serialize($tasks));

        $config = stConfig::getInstance('stTaskScheluderBackend');

        if ($config->get('integrity_hash') != $integrity_hash)
        {
            $tasks = self::getTasks();

            stEventDispatcher::getInstance()->notify(new sfEvent(null, 'stTaskScheluder.initialize', array('tasks' => $tasks)));

            $c = new Criteria();
            $c->add(TaskPeer::TASK_ID, array_keys($tasks), Criteria::NOT_IN);
            TaskPeer::doDelete($c);    

            $config->set('integrity_hash', $integrity_hash);
            $config->save();
        }   
    }
    
    /**
     * Zwraca listę zadań do wykonania
     *
     * @return stTaskInterface[]
     */
    public static function getTasks(): array
    {
        $tasksConfiguration = stTaskConfiguration::getTasks();

        $tasks = array();

        foreach ($tasksConfiguration as $taskId => $taskConfiguration)
        {
            $tasks[$taskId] = stTaskFactory::createTaskById($taskId);
        }

        return $tasks;
    }

    /**
     * Zwraca zadanie do wykonania o podanym ID
     *
     * @param string $taskId Id zadania
     * @return stTaskInterface
     */
    public static function getTask(string $taskId): stTaskInterface
    {
        $tasks = self::getTasks();

        if (!isset($tasks[$taskId]))
        {
            throw new stTaskScheluderException(sprintf('The task with id "%s" does not exist', $taskId));
        }

        return $tasks[$taskId];
    }

    /**
     * Wymusza ponowną initializacje zadań
     *
     * @return void
     */
    public static function forceTaskInitialization()
    {
        $config = stConfig::getInstance('stTaskScheluderBackend');
        $config->set('integrity_hash', null);
        $config->save();
    }
}