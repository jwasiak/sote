<?php

/**
 * Subclass for representing a row from the 'st_poczta_polska_paczka' table.
 *
 * 
 *
 * @package plugins.stPocztaPolskaPlugin.lib.model
 */ 
class PocztaPolskaPaczka extends BasePocztaPolskaPaczka
{
    public function getTrackingUrl()
    {
        return 'https://emonitoring.poczta-polska.pl/?numer='.$this->getNumerNadania();
    }

    public function isSent()
    {
        return null !== $this->envelope_id;
    }
}
