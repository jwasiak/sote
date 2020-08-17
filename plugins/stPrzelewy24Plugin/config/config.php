<?php
/** 
 * SOTESHOP/stPrzelewy24Plugin 
 * 
 * Ten plik należy do aplikacji stPrzelewy24Plugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stPrzelewy24Plugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 8019 2010-08-31 11:53:46Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Dodanie informacji o istnieniu płatności
 */
stPluginHelper::addConfigValue('stPaymentType', 'stPrzelewy24Plugin', array('name' => 'stPrzelewy24', 'description' => 'Płatność przez serwis przelewy24.pl'));

/** 
 * Włączanie modułu
 */
stPluginHelper::addEnableModule('stPrzelewy24Backend', 'backend');
stPluginHelper::addEnableModule('stPrzelewy24Frontend', 'frontend');

/** 
 * Dodawania routingu
 */
stPluginHelper::addRouting('stPrzelewy24Plugin', '/przelewy24', 'stPrzelewy24Backend', 'index', 'backend');
stPluginHelper::addRouting('stPrzelewy24Plugin', '/przelewy24/:action/*', 'stPrzelewy24Frontend', 'index', 'frontend');

/**
 * Wyłącznie modułu w trybie open 
 */
stLicenseTypeHelper::addCommercialModule('stPrzelewy24Plugin');