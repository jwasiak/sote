<?php

/**
 * Subclass for representing a row from the 'st_poczta_polska_bufor' table.
 *
 * 
 *
 * @package plugins.stPocztaPolskaPlugin.lib.model
 */ 
class PocztaPolskaBufor extends BasePocztaPolskaBufor
{
    protected $countPaczka = null;

    public function getCountPaczka()
    {
        if (null === $this->countPaczka)
        {
            $this->countPaczka = PocztaPolskaBuforPeer::doCountPaczka($this->getBuforId());
        }

        return $this->countPaczka;
    }
}
