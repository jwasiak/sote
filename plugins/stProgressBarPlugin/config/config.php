<?php
/**
 * SOTESHOP/stProgressBarPlugin
 *
 * Ten plik należy do aplikacji stProgressBarPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProgressBarPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 9 2009-08-24 09:31:16Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Włączanie modułów
 */
if (SF_APP != 'update' && class_exists('stPluginHelper')) {
	stPluginHelper::addEnableModule('stProgressBar', 'backend');
	stPluginHelper::addEnableModule('stProgressBarDemo', 'backend');
}