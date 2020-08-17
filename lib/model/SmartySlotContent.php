<?php

/**
 * Subclass for representing a row from the 'st_smarty_slot_content' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SmartySlotContent extends BaseSmartySlotContent
{
    public static function generateContentChecksum($content = array())
    {
        $hash = array($content['name'], isset($content['parameters']) ? $content['parameters'] : array());

        return hash('sha512', serialize($hash));
    } 

    public function save($con = null)
    {
        if ($this->isNew())
        {
            $hash = self::generateContentChecksum($this->content);

            $this->setHash($hash);
        }

        return parent::save($con);
    }
}
