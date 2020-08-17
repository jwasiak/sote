<?php

/**
 * Subclass for performing query and update operations on the 'st_task_scheluder_log' table.
 *
 * 
 *
 * @package plugins.stTaskPlugin.lib.model
 */ 
class TaskLogPeer extends BaseTaskLogPeer
{
    /**
     * Zwraca listę typów
     *
     * @return array
     */
    public static function getTypes()
    {
        $i18n = sfContext::getInstance()->getI18N();

        return array(
            stTaskLogger::TYPE_INFO => $i18n->__('Informacja'),
            stTaskLogger::TYPE_WARNING => $i18n->__('Ostrzeżenie'),
            stTaskLogger::TYPE_ERROR => $i18n->__('Błąd'),
        );
    }
}
