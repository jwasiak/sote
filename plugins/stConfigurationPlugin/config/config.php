<?php
/**
 * SOTESHOP/stConfigurationPlugin
 *
 * Ten plik należy do aplikacji stConfigurationPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stConfigurationPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 9 2009-08-24 09:31:16Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/**
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stConfigurationBackend', 'backend');

/**
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stConfigurationPlugin', '/configuration', 'stConfigurationBackend', 'list', 'backend');
