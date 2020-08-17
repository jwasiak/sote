<?php

class stSantander
{
    public function checkPaymentConfiguration()
    {
        return true;
    }

    public static function getCalculateRateUrl($total_amount)
    {
        $config = stConfig::getInstance('stSantanderBackend');

        return 'https://wniosek.eraty.pl/symulator/oblicz/numerSklepu/'.$config->get('shop_number').'/typProduktu/0/wartoscTowarow/'.$total_amount;
    }

    public static function getFormUrl()
    {
        return 'https://wniosek.eraty.pl/formularz/';
    }

    public static function isActive()
    {
        if (!PaymentTypePeer::isActive('stSantander')) return false; 

        $eraty = new stSantander();
        if (!$eraty->checkPaymentConfiguration()) return false;
        return true;
    }
}