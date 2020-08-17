<?php

/**
 * Subclass for performing query and update operations on the 'st_box' table.
 *
 * 
 *
 * @package plugins.stBoxPlugin.lib.model
 */ 
class BoxPeer extends BaseBoxPeer
{
     /**
     * Przeciążenie metody pobierającej strony www w odpowiedniej wersji jezykowej
     *
     * @param Criteria $c Kryteria
     * @param mixed $culture Wersja językowa
     * @param CreoleConnection $con Połączenie z bazą danych
     * @return array Produkty
     */
    public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
    {
        if ($culture === null)
        {
            $culture = stLanguage::getHydrateCulture();
        }

        return parent::doSelectWithI18n($c, $culture, $con);
    }


    public static function doCountWithI18n(Criteria $c, $con = null)
    {
        $c = clone $c;
        
        $c->addJoin(BoxI18nPeer::ID, BoxPeer::ID);

        $c->add(BoxI18nPeer::CULTURE, stLanguage::getHydrateCulture());

        return self::doCount($c, $con);
    }
}
