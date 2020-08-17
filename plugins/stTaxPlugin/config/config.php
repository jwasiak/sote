<?php
/** 
 * SOTESHOP/stTaxPlugin 
 * 
 * Ten plik należy do aplikacji stTaxPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stTaxPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id$
 * @author      Krzysztof Beblo <krzysztof.beblo@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stTaxBackend', 'backend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stTaxPlugin', '/tax/:action/*', 'stTaxBackend', 'list', 'backend');

if (SF_APP == 'backend')
{
   $dispatcher->connect('stReminderBackend.beforeReminderCount', array('stTaxListener', 'reminder'));
}