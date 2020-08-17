<?php
/**
 * SOTESHOP/stPositioningPlugin
 *
 * Ten plik należy do aplikacji stPositioningPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPositioningPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: PositioningPeer.php 17 2009-08-24 11:02:54Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa PositioningPeer
 *
 * @package     stPositioningPlugin
 * @subpackage  actions
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
class PositioningPeer extends BasePositioningPeer
{
    public static function doSelectDefaultValues()
    {
        $c = new Criteria();
        $c->add(PositioningPeer::SYSTEM_NAME, 'DEFAULT_VALUE');
        
        $stCache = new stFunctionCache('stPositioningPlugin');
        $default_info = $stCache->add('getDefaultValues', "PositioningPeer::doSelectOne", $c);

        stEventDispatcher::getInstance()->notify(new sfEvent($default_info, 'stMetaTagsGenerator.defaultConfig'));   
        return $default_info;
    }
}
