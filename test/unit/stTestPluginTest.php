<?php
/** 
 * SOTESHOP/stTestPlugin 
 * 
 * Ten plik należy do aplikacji stTestPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stTestPlugin
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stTestPluginTest.php 3005 2008-12-09 15:47:00Z michal $
 * @author      Michał Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Wymagane pliku do testow
 */
require(dirname(__FILE__).'/../bootstrap/unit.php');

$t = new lime_test(2, new lime_output_color());

$file = dirname(__FILE__).'/../../lib/stTestBrowser.class.php';

$t->diag('stTestPlugin test');
$t->is(file_exists($file), true, 'Checking file exists.');
$t->is(ereg("class stTestBrowser", file_get_contents($file)), true, 'Checking class exists.');