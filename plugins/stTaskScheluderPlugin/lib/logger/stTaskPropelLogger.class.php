<?php

class stTaskPropelLogger extends stTaskLogger implements stTaskLoggerInterface
{
    /**
     * Instancja modelu Task
     * 
     * @var Task
     */
    protected $task;

    /**
     * Undocumented variable
     *
     * @var stEventDispatcher
     */
    protected $dispatcher;

    /**
     *
     * @param Task $task Instancja modelu Task
     */
    public function __construct(Task $task, stEventDispatcher $dispatcher)
    {
        $this->task = $task;
        $this->dispatcher = $dispatcher;
    }

    public function log(int $type, string $message, array $messageParams = null): stTaskLoggerInterface
    {
        $log = new TaskLog();
        $log->setType($type);
        $log->setTask($this->task);
        $log->setMessage($messageParams ? '@'.serialize(array($message, $messageParams)) : $message);
        $log->save();

        $this->dispatcher->notify(new sfEvent($this, 'task.logger.log', array(
            'task' => $this->task,
            'type' => $type,
            'message' => $message, 
            'message_params' => $messageParams
        )));

        return $this;
    }

    public function info(string $message, array $messageParams = null): stTaskLoggerInterface
    {
        return $this->log(self::TYPE_INFO, $message, $messageParams);
    }

    public function error(string $message, array $messageParams = null): stTaskLoggerInterface
    {
        return $this->log(self::TYPE_ERROR, $message, $messageParams);
    }

    public function warning(string $message, array $messageParams = null): stTaskLoggerInterface
    {
        return $this->log(self::TYPE_WARNING, $message, $messageParams);
    }

    public function exception(Throwable $e): stTaskLoggerInterface
    {
        $this->error('%message% w linii %line% w pliku %file%:%trace%', array(
            '%message%' => $e->getMessage(),
            '%line%' => $e->getLine(),
            '%file%' => $e->getFile(),
            "%trace%" => "\n".$e->getTraceAsString(),
        ));

        return $this;
    }
}