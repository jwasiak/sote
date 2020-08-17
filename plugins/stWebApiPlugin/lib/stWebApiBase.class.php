<?php

/** 
 * Definijce zwracanych błędów
 */
if (!defined("WEBAPI_INCORRECT_ID"))
{
    define( "WEBAPI_INCORRECT_ID",  "Błędny numer ID." );
    define( "WEBAPI_ADD_ERROR", "Błąd podczas dodawania danych. Informacja: %s" );
    define( "WEBAPI_UPDATE_ERROR", "Błąd podczas aktualizacji danych. Informacja: %s" );
    define( "WEBAPI_DELETE_ERROR", "Błąd podczas usuwania danych. Informacja: %s" );
    define( "WEBAPI_COUNT_ERROR", "Błąd podczas liczenia danych. Informacja: %s" );
    define( "WEBAPI_VALIDATE_ERROR", "Błąd podczas sprawdzania danych, niewłasciwa wartość pola \"%s\"." );
    define( "WEBAPI_VALIDATE_UNIQUE_ERROR", "Błąd podczas sprawdzania danych, podana wartość dla pola \"%s\" już istnieje." );
    define( "WEBAPI_REQUIRE_ERROR", "Nie podano wymaganego pola: \"%s\"." );
    define( "WEBAPI_CONFIG_ERROR", "Błąd w pliku konfiguracyjnym modułu.");
}

abstract class stWebApiBase
{
    public function __($value, $args = array(), $catalogue = 'messages')
    {
        return sfContext::getInstance()->getI18n()->__($value, $args, 'stWebApiBackend');
    }

    public function __setCulture($culture)
    {
        if ($culture == 'en') 
        {
            $culture = 'en_US';
        } 
        elseif ($culture == 'pl') 
        {
            $culture = 'pl_PL';
        }

        $this->_culture = $culture;
    }

    public function __getCulture()
    {
        return $this->_culture ? $this->_culture : stLanguage::getOptLanguage();
    }
}
