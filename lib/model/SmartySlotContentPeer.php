<?php

/**
 * Subclass for performing query and update operations on the 'st_smarty_slot_content' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SmartySlotContentPeer extends BaseSmartySlotContentPeer
{
    protected static $hash = array();

    public static function doSelectChecksumByTheme(Theme $theme)
    {
        if (!isset($hash[$theme->getId()]))
        {
            $c = new Criteria();

            $c->addSelectColumn(self::HASH);

            $c->addSelectColumn(self::CONTENT);

            $c->addJoin(self::SLOT_ID, SmartySlotPeer::ID);

            $c->add(SmartySlotPeer::THEME_ID, $theme->getId());

            $rs = self::doSelectRs($c);    

            $results = array();

            while($rs->next())
            {
                $row = $rs->getRow();

                $results[$row[0]] = unserialize($row[1]); 
            }

            self::$hash[$theme->getId()] = $results;
        }

        return self::$hash[$theme->getId()];
    }

    public static function doSelectArrayBy($slot_name, Theme $theme, $defaults = array())
    {
        $slot = SmartySlotPeer::retrieveByNameAndTheme($slot_name, $theme);

        if (!$slot)
        {
            return $defaults;
        }

        $c = new Criteria();

        $c->addSelectColumn(self::ID);

        $c->addSelectColumn(self::CONTENT);

        $c->add(self::SLOT_ID, $slot->getId());

        $results = array();

        $rs = self::doSelectRs($c);

        while($rs->next())
        {
            $row = $rs->getRow();

            $results[$row[0]] = $row[1] ? unserialize($row[1]) : array(); 
        }

        if (!$results)
        {
            return array();
        }

        ksort($results);
        
        return $results;
    }
}
