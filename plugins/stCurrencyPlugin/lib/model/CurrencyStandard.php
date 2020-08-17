<?php
/** 
 * SOTESHOP/stCurrencyPlugin 
 * 
 * Ten plik należy do aplikacji stCurrencyPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCurrencyPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: CurrencyStandard.php 97 2009-08-26 08:04:10Z marcin $
 * @author      Marcin Olejnczak <marcin.olejniczak@sote.pl>
 */

/** 
 * Klasa CurrencyStandard
 *
 * @package     stCurrencyPlugin
 * @subpackage  libs
 */
class CurrencyStandard extends BaseCurrencyStandard
{
    public function __toString()
    {
        return $this->getShortcut();
    }
}
