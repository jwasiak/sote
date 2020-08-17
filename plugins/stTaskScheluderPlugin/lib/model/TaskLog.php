<?php

/**
 * Subclass for representing a row from the 'st_task_scheluder_log' table.
 *
 * 
 *
 * @package plugins.stTaskPlugin.lib.model
 */ 
class TaskLog extends BaseTaskLog
{
    public function getTypeLabel()
    {
        $types = TaskLogPeer::getTypes();

        return $types[$this->type];
    }

    public function getMessage()
    {
        $message = parent::getMessage();
        $messageParams = array();

        $i18n = sfContext::getInstance()->getI18N();
        $className = $this->getTask()->getClassName();

        if ($message[0] == '@')
        {
            list($message, $messageParams) = unserialize(ltrim($message, '@'));
        }

        $translatedMessage = $i18n->__($message, $messageParams, 'stTaskScheluderBackend');

        if ($i18n->hasTranslation($message, $className))
        {
            $translatedMessage = $i18n->__($message, $messageParams, $className);
        }

        return $translatedMessage;
    }
}
