<?php

/**
 * Subclass for representing a row from the 'st_task_scheluder_task' table.
 *
 * 
 *
 * @package plugins.stTaskPlugin.lib.model
 */ 
class Task extends BaseTask
{
    /**
     * Zadanie 
     *
     * @var stTaskInterface
     */
    private $task = null;

    public function __toString()
    {
        return $this->getName();
    }
    
    public function getStatusLabel()
    {
        $statuses = TaskPeer::getStatuses();

        return $statuses[$this->status];
    }

    public function getName()
    {
        $name = $this->getTaskConfigurationParameter('name');
        $i18n = sfContext::getInstance()->getI18N();
        $className = $this->getClassName();

        return $i18n->__($name, null, $className);
    }
    
    public function getClassName()
    {
        return $this->getTaskConfigurationParameter('class_name');
    }

    public function getNextExecuteDate()
    {
        if (null === $this->last_executed_at)
        {
            return null;
        }

        $executeDate = date('d-m-Y H:i:s', $this->last_executed_at + $this->getTimeInterval());

        if ($this->getTimeInterval() >= stTaskConfiguration::TIME_INTERVAL_1DAY)
        {
            $executeDate = date('d-m-Y', strtotime($executeDate)) . ' ' . $this->getExecuteAt();
        }

        return $executeDate;
    }

    public function getTimeInterval()
    {
        $timeInterval = parent::getTimeInterval();

        if (null === $timeInterval)
        {
            $timeInterval = $this->getTaskConfigurationParameter('time_interval');
        }

        return $timeInterval;
    }

    public function getExecuteAt($format = 'H:i:s')
    {
        $executeAt = parent::getExecuteAt($format);

        if (null === $executeAt)
        {
            $executeAt = $this->getTaskConfigurationParameter('execute_at');
        }

        return $executeAt;
    }

    public function save($con = null)
    {
        if ($this->isNew())
        {
           $this->setTaskPriority($this->getTaskConfigurationParameter('priority'));
           $this->setIsActive($this->getTaskConfigurationParameter('is_active'));
        }

        return parent::save($con);
    }

    public function getIsSystemDefault()
    {
        return $this->getTaskConfigurationParameter('is_system');
    }

    public function getTaskConfigurationParameter($name)
    {
        $config = stTaskConfiguration::getTask($this->getTaskId());

        return isset($config[$name]) ? $config[$name] : null;
    }
}
