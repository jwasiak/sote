<?php

class stTaskFactory
{
    public static function createTaskById(string $taskId, int $lastProgress = 0): stTaskInterface
    {
        $task = TaskPeer::retrieveByTaskId($taskId);
        
        if (null === $task)
        {
            $task = new Task();
            $task->setTaskId($taskId);
            $task->save(); 
        }
        elseif ($task->getTaskPriority() != $task->getTaskConfigurationParameter('priority'))
        {
            $task->setTaskPriority($task->getTaskConfigurationParameter('priority'));
            $task->save();
        }

        return self::createTask($task, $lastProgress);
    }

    public static function createTask(Task $task, int $lastProgress = 0)
    {
        $className = $task->getClassName();
        $dispatcher = stEventDispatcher::getInstance();
        
        $logger = new stTaskPropelLogger($task, $dispatcher);

        return new $className($task, $logger, $dispatcher, $lastProgress);
    }
}