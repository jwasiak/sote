<?php
/** 
 * SOTESHOP/stProductGroup 
 * 
 * Ten plik należy do aplikacji stProductGroup opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProductGroup
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 445 2009-09-10 10:04:14Z pawel $
 * @author      Krzysztof Beblo <krzysztof.beblo@sote.pl>
 */

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stProductGroup', '/product_group/:action/*', 'stProductGroup', 'list', 'backend');
stPluginHelper::addRouting('stGiftGroup', '/gift_group/:action/*', 'stGiftGroup', 'list', 'backend');
