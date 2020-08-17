<?php

class stTaskProgressBar
{
    protected $message = null;

    protected $currentTaskId = null;

    protected $taskOffset = 0;

    protected $taskCount = 0;

    public static function getParameter(string $name, $default = null)
    {
        return sfContext::getInstance()->getUser()->getAttribute($name, $default, 'soteshop/stTaskProgressBar');
    }

    public static function setParameter(string $name, $value)
    {
        sfContext::getInstance()->getUser()->setAttribute($name, $value, 'soteshop/stTaskProgressBar');
    }

    public static function clearParameters()
    {
        sfContext::getInstance()->getUser()->getAttributeHolder()->removeNamespace('soteshop/stTaskProgressBar');
    }

    public function execute($offset = 0)
    {         
        $task = $this->getCurrentTask($offset);

        if (null === $task)
        {
            return $offset + $this->taskCount;
        }

        $this->setMessage($task->getName());

        $taskOffset = $offset - $this->taskOffset;

        $currentTaskOffset = $task->doExecute($taskOffset);

        self::setParameter("last_progress", $task->getLastProgress());

        usleep(250000);

        return $offset + $currentTaskOffset - $taskOffset;
    }

    protected function getCurrentTask($offset): ?stTaskInterface
    {
        $currentTask = self::getParameter('current_task');

        $taskSwitched = false;

        if (null === $currentTask || $offset - $currentTask['offset'] >= $currentTask['count'])
        {
            $currentTask = $this->getNextTask();
            self::setParameter('current_task', $currentTask);
            $taskSwitched = true;
            self::setParameter("last_progress", 0);
        }

        $this->taskOffset = $currentTask['offset'];
        $this->taskCount = $currentTask['count'];

        $task = stTaskFactory::createTaskById($currentTask['id'], self::getParameter('last_progress'));

        if ($taskSwitched && (!$task->isReadyToExecute() || !$task->doCount()))
        {
            return null;
        }

        return $task;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function close()
    {
        sfLoader::loadHelpers(array('Helper', 'stPartial', 'stAdminGenerator'));
        $message = st_get_partial('stTaskScheluderBackend/progress_bar_finished_message');

        $this->setMessage($message);
    }

    protected function getNextTask(): ?array
    {
        $taskPool = self::getParameter('task_pool');

        $task = array_pop($taskPool);

        self::setParameter('task_pool', $taskPool);

        return $task;
    }
}