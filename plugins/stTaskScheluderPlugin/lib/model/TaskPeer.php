<?php

/**
 * Subclass for performing query and update operations on the 'st_task_scheluder_task' table.
 *
 * 
 *
 * @package plugins.stTaskPlugin.lib.model
 */ 
class TaskPeer extends BaseTaskPeer
{
    /**
     * Zwraca listę statusów
     *
     * @return array
     */
    public static function getStatuses()
    {
        $i18n = sfContext::getInstance()->getI18N();
        return array(
            stTask::STATUS_PENDING => $i18n->__('Oczekuje'),
            stTask::STATUS_RUNNING => $i18n->__('W trakcie wykonywania'),
        );
    }

    public static function getTimeIntervals()
    {
        $i18n = sfContext::getInstance()->getI18N();
        return array(
            stTaskConfiguration::TIME_INTERVAL_10MIN => $i18n->__('co 10 minut'),
            stTaskConfiguration::TIME_INTERVAL_15MIN => $i18n->__('co 15 minut'),
            stTaskConfiguration::TIME_INTERVAL_30MIN => $i18n->__('co 30 minut'),
            stTaskConfiguration::TIME_INTERVAL_1HOUR => $i18n->__('co 1 godzinę'),
            stTaskConfiguration::TIME_INTERVAL_2HOURS => $i18n->__('co 2 godziny'), 
            stTaskConfiguration::TIME_INTERVAL_4HOURS  =>  $i18n->__('co 4 godziny'),
            stTaskConfiguration::TIME_INTERVAL_6HOURS => $i18n->__('co 6 godzin'),
            stTaskConfiguration::TIME_INTERVAL_12HOURS => $i18n->__('co 12 godzin'),
            stTaskConfiguration::TIME_INTERVAL_1DAY  => $i18n->__('raz dziennie'),
            stTaskConfiguration::TIME_INTERVAL_1WEEK  => $i18n->__('co tydzień'),
        );        
    }

    public static function retrieveByTaskId(string $taskId)
    {
        $c = new Criteria();
        $c->add(self::TASK_ID, $taskId);
        $task = self::doSelectOne($c);

        return $task;
    }
}
