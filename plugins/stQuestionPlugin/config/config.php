<?php
/** 
 * SOTESHOP/stQuestionPlugin 
 * 
 * Ten plik należy do aplikacji stQuestionPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stQuestionPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 2113 2009-11-16 15:18:49Z pawel $
 * @author      Paweł Byszewski <pawel.byszewski@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stQuestionFrontend', 'frontend');
stPluginHelper::addEnableModule('stQuestionBackend', 'backend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stQuestionPlugin', '/question/:action/*', 'stQuestionBackend', 'index', 'backend');
stPluginHelper::addRouting('stQuestionFrontend', '/question/:action/*', 'stQuestionFrontend', 'index', 'frontend');
stPluginHelper::addRouting('stGoToQuestion', '/question/edit/id/:question', 'stQuestionFrontend', 'edit', 'frontend');
