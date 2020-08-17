<?php

class stTaskScheluderBackendActions extends autoStTaskScheluderBackendActions
{
    public function executeList()
    {
        if ($this->checkPHPVersion())
        {
            stTaskScheluder::initialize();
        }

        $ret = parent::executeList();

        $this->pager->setPeerCountMethod(array($this, 'doCountTasks'));

        $this->pager->init();

        return $ret;
    }

    public function executeConfig()
    {
        $this->checkPHPVersion();
        
        return parent::executeConfig();
    }

    public function executeEdit()
    {
        parent::executeEdit();

        if ($this->task->getIsSystemDefault())
        {
            $i18n = $this->getContext()->getI18N();
            $this->setFlash('warning', $i18n->__('Zadania systemowe nie mogą być zmieniane'));
            return $this->redirect('@stTaskScheluderBackend');
        }
    }

    protected function addSortCriteria($c)
    {
        parent::addSortCriteria($c);

        $c->addAscendingOrderByColumn(TaskPeer::TASK_PRIORITY);
    }

    protected function addLogFiltersCriteria($c)
    {
        /**
         * @var Criteria $c
         */

        if ($this->getRequestParameter('id'))
        {
            $c->add(TaskLogPeer::TASK_ID, $this->getRequestParameter('id'));
        }

        if (isset($this->filters['type']) && "" !== $this->filters['type'])
        {
            $c->add(TaskLogPeer::TYPE, $this->filters['type']);
        }

        $c->addDescendingOrderByColumn(TaskLogPeer::ID);

        parent::addLogFiltersCriteria($c);
    }

    public function executeExecuteTasks()
    {
        if (floatval(phpversion()) < 7.1)
        {
            return $this->redirect('@stTaskScheluderBackend');
        }
        
        $taskPool = array();
        $totalCount = 0;

        stTaskProgressBar::clearParameters();

        /**
         * @var Task $task
         */
        foreach (TaskPeer::doSelect(new Criteria()) as $task)
        {
            $task->setLastExecutedAt(null);
            $task->save();
        }

        foreach (stTaskScheluder::getTasks() as $task)
        {
            if ($task->isReadyToExecute())
            {
                $count = $task->doCount();

                if ($count > 0)
                {
                    $taskPool[] = array('id' => $task->getId(), 'offset' => $totalCount, 'count' => $count);
                    $totalCount += $count;
                }
            }
        }

        if (!$totalCount)
        {
            $this->setFlash('notice', 'Zadania nie wymagają wykonania');
            return $this->redirect('@stTaskScheluderBackend');
        }

        $taskPool = array_reverse($taskPool);
        // die("<pre>".var_export($taskPool, true)."</pre>");
        stTaskProgressBar::setParameter('task_pool', $taskPool);
        $this->getUser()->setParameter('progress_bar', $totalCount);

        return $this->forward($this->getModuleName(), 'list');
    }

    public function doCountTasks(Criteria $c)
    {
        return floatval(phpversion()) < 7.1 ? 0 : TaskPeer::doCount($c);
    }

    protected function checkPHPVersion()
    {
        if (floatval(phpversion()) < 7.1)
        {
            $i18n = $this->getContext()->getI18N();
            $this->setFlash('warning', $i18n->__('Do poprawnego działania moduł wymaga wersji PHP 7.1.x (aktualnie ustawiona wersja PHP: %version%)', array('%version%' => phpversion())), false);
            return false;
        }

        return true;
    }
}