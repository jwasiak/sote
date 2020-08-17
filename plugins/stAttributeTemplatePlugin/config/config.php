<?php
/** 
 * SOTESHOP/stAttributeTemplatePlugin 
 * 
 * Ten plik należy do aplikacji stAttributeTemplatePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAttributeTemplatePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id$
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stAttributeFieldBackend', 'backend');
stPluginHelper::addEnableModule('stAttributeTemplateBackend', 'backend');
stPluginHelper::addEnableModule('stAttributeTemplateFrontend', 'frontend');
stPluginHelper::addEnableModule('stAttributeProductFieldBackend', 'backend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stAttributeTemplatePlugin', '/attribute_template/:action/*', 'stAttributeTemplateBackend', 'list', 'backend');
stPluginHelper::addRouting('stAttributeFieldBackend', '/attribute_field/:action/*', 'stAttributeFieldBackend', 'list', 'backend');


/** 
 * Pobiera instancję obiektu sfEventDispatcher
 */
//$dispatcher = stEventDispatcher::getInstance();

/** 
 * Dodaje sluchacza
 */
//$dispatcher->connect('stAdminGenerator.generateStProduct', array('stAttributeTemplatePluginListener', 'generate'));
//$dispatcher->connect('autoStProductActions.postSave', array('stAttributeTemplatePluginListener', 'postSave'));