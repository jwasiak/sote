<?php

abstract class stTask implements stTaskInterface
{
    /**
     * Status "oczekuje"
     */
    const STATUS_PENDING = 0;
    
    /**
     * Status "w trakcie wykonywania"
     */
    const STATUS_RUNNING = 1;

    /**
     * Cron job logger instance
     *
     * @var stTaskLoggerInterface
     */
    private $logger;

    /**
     * Instancja modelu zadania
     *
     * @var Task
     */
    private $task;

    /**
     * Ilość do wykonania
     *
     * @var int
     */
    private $count = null;

    /**
     * Undocumented variable
     *
     * @var stEventDispatcher
     */
    private $dispatcher;

    /**
     * Aktualny postęp wykonywania zadania w %
     *
     * @var int
     */
    private $progress = 0;

    /**
     * Ostatnio zapamiętana wartość postępy wykonywania zadania
     *
     * @var int
     */
    private $lastProgress = 0;

    public function __toString()
    {
        return $this->getName();
    }


    public function __construct(Task $task, stTaskLoggerInterface $logger, stEventDispatcher $dispatcher, int $lastProgress = 0)
    {
        $this->task = $task;
        $this->logger = $logger;
        $this->dispatcher = $dispatcher;
        $this->lastProgress = $lastProgress;

        $this->initialize();
    }

    public function initialize()
    {
    }
    
    /**
     * Cron job logger instance
     *
     * @return stTaskLoggerInterface
     */
    final public function getLogger(): stTaskLoggerInterface
    {
        return $this->logger;
    }

    /**
     * Zwraca nazwę zadania
     *
     * @return string
     */
    final public function getName(): string
    {
        return $this->task->getName();
    }
    
    /**
     * Odświeża status aktywności zadaia
     *
     * @return void
     */
    final public function refreshActiveStatus(): void
    {
        $this->task->setLastActiveAt(time());

        if ($this->task->isModified(TaskPeer::LAST_ACTIVE_AT))
        {
            TaskPeer::doUpdate($this->task);
        }
    }

    /**
     * Zwraca identyfikator zadania
     *
     * @return string
     */
    final public function getId(): string
    {
        return $this->task->getTaskId();
    }

    /**
     * Zwraca odstęp czasowy w sekundach co jaki będzie wykonywane zadanie
     *
     * @return int
     */
    final public function getTimeInterval(): int
    {
        return $this->task->getTimeInterval();
    }

    /**
     * Zwraca godzinę o jakiej zostanie wykonane zadanie
     *
     * @return string
     */
    final public function getExecuteAt(): string
    {
        return $this->task->getExecuteAt();
    }

    /**
     * Zwraca aktualny status zadania
     *
     * @return int
     */
    final public function getStatus(): int
    {
        return $this->task->getStatus();
    }

    /**
     * Zwraca instancje modelu zadania
     *
     * @return Task
     */
    final public function getTask(): Task
    {
        return $this->task;
    }

    /**
     * Sprawdza czy zadanie jest gotowe do wykonania
     *
     * @return bool
     */
    final public function isReadyToExecute(): bool
    {
        return $this->task->getIsActive() && $this->getStatus() == self::STATUS_PENDING && (null === $this->task->getLastExecutedAt() || strtotime($this->task->getNextExecuteDate()) <= time());
    }

    final public function getProgress(): int
    {
        return $this->progress;
    }

    final public function getLastProgress(): int
    {
        return $this->lastProgress;
    }

    /**
     * Zwraca ilość do wykonania
     *
     * @return int
     */
    final public function doCount(): int
    {
        try
        {
            if (null === $this->count)
            {
                $this->count = $this->count();

                if (!$this->count)
                {
                    $this->getLogger()->info("Zadanie nie wymagało wykonania");
                    $this->task->setLastExecutedAt(time());
                    $this->task->setLastFinishedAt(time());
                    $this->task->save();
                }
            }
        }
        catch (Throwable $e)
        {
            if (!mysqli_ping(Propel::getConnection()->getResource()))
            {
                Propel::close();
                Propel::initialize();
            }

            try
            {
                $this->getLogger()->exception($e);
                return 0;
            }
            catch (Throwable $e)
            {
                return 0;
            }
        }

        return $this->count;
    }

    /**
     * Zmienia status zadania jako "w trakcie wykonywania"
     *
     * @return void
     */
    final private function doStart()
    {
        stFastCacheManager::disableClearCache();
        stFunctionCache::disableClearCache(array('stTax'));
        stPartialCache::disableClearCache();

        $this->task->setLastExecutedAt(time());
        $this->task->setStatus(self::STATUS_RUNNING);
        $this->task->save();
        $this->getLogger()->info("Rozpoczęcie wykonywania");
        $this->dispatcher->notify(new sfEvent($this->task, 'task.started'));
        $this->started();
    }

    /**
     * Ustawia zadanie jako zakończone
     *
     * @return void
     */
    final private function doFinish()
    {
        stFastCacheManager::enableClearCache();
        stFunctionCache::enableClearCache();
        stPartialCache::enableClearCache();

        $this->task->setLastFinishedAt(time());
        $this->task->setStatus(stTask::STATUS_PENDING);
        $this->task->save();
        $this->getLogger()->info("Zakończenie wykonywania");
        $this->dispatcher->notify(new sfEvent($this->task, 'task.finished'));
        $this->lastProgress = 0;
        $this->finished();
    }

    /**
     * Czyści pamięć podręczną aplikacji
     *
     * @return void
     */
    public function clearCache()
    {
        stFunctionCache::clearAll();
        stPartialCache::clearAll('frontend');
        stFastCacheManager::clearCache();
    }

    public function started()
    {
    }

    public function finished()
    {
    }

    /**
     * Wykonuje zadanie 
     *
     * @param integer $offset Aktualnie przesunięcie od jakiego ma być wykonuwane zadanie
     * @return integer Zwraca kolejne przesunięcie od jakiego ma być wykonywane zadanie
     */
    final public function doExecute(int $offset): int
    {
        try
        {
            if (!$offset)
            {
                $this->doStart();
            }

            $offset = $this->execute($offset);

            if (null === $this->task->getLastActiveAt() || time() - strtotime($this->task->getLastActiveAt()) >= stTaskConfiguration::TIME_INTERVAL_5MIN)
            {
                $this->refreshActiveStatus();
            }

            /**
             * Poprawka wycieku pamięci
             */
            ProductOptionsValue::clearStaticPool();
            stNewProductOptions::clearStaticPool();
            sfAsset::clearStaticPool();

            if ($offset > $this->doCount())
            {
                $offset = $this->doCount();
            }
    
            $this->progress = intval(($offset / $this->doCount()) * 100);
    
            if ($this->progress >= 25 && $this->lastProgress + 25 <= $this->progress)
            {
                $this->lastProgress = $this->progress;
                $this->getLogger()->info("Wykonano %progress%%", array("%progress%" => $this->progress));
                $this->dispatcher->notify(new sfEvent($this, 'task.progress'));
            }
    
            if ($offset >= $this->doCount())
            {
                $this->doFinish();
    
                return $this->doCount();
            }
        }
        catch (Throwable $e)
        {
            if (!mysqli_ping(Propel::getConnection()->getResource()))
            {
                Propel::close();
                Propel::initialize();

                try
                {
                    $this->count = null;
                    $this->doCount();
                    $this->getLogger()->warning("Pomyślne przywrócenie utraconego połączenia MySQL");
                    return $offset;
                }
                catch (Throwable $e)
                {
                    Propel::close();
                    Propel::initialize();
                    $this->getLogger()->error("Wystąpił błąd podczas próby wznawiania utraconego połączenia MySQL");
                }
            }

            $this->getLogger()->exception($e);

            $this->doFinish();
            
            return $this->doCount();
        }

        return $offset;
    }
}