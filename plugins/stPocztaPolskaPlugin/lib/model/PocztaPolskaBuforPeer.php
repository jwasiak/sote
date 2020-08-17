<?php

/**
 * Subclass for performing query and update operations on the 'st_poczta_polska_bufor' table.
 *
 * 
 *
 * @package plugins.stPocztaPolskaPlugin.lib.model
 */ 
class PocztaPolskaBuforPeer extends BasePocztaPolskaBuforPeer
{
    public static function retrieveByBuforId($id)
    {
        $c = new Criteria();
        $c->add(self::BUFOR_ID, $id);
        return self::doSelectOne($c);
    }

    public static function doCountPaczka($id)
    {
        $c = new Criteria();
        $c->add(PocztaPolskaPaczkaPeer::BUFOR_ID, $id);
        return  PocztaPolskaPaczkaPeer::doCount($c);
    }
}
