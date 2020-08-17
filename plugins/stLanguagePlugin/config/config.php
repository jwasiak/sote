<?php
/**
 * SOTESHOP/stLanguagePlugin
 *
 * Ten plik należy do aplikacji stLanguagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLanguagePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 260 2009-09-03 11:08:56Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('stLanguageBackend', 'backend');
    stPluginHelper::addRouting('stLanguagePlugin', '/language/:action/*', 'stLanguageBackend', 'index', 'backend');
}

/**
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stLanguageFrontend', 'frontend');

/**
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stLanguage_changeLanguage', '/lang/:lang', 'stFrontendMain', 'index', 'frontend');

/**
 * Dodanie zachowań propela
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 */
sfPropelBehavior::registerHooks('language', array(
  ':addDoSelectRS:addDoSelectRS'   => array('stPropelLanguageBehavior', 'addDoSelectRS'),
));

/**
 * Usunięcie zmiany języka w potwierdzeniu zamówienia
 */
stEventDispatcher::getInstance()->connect('stOrderActions.postExecuteConfirm', array('stLanguageListener', 'addOrderConfirm'));

/**
 * Usunięcie zmiany języka w podsumowania zamówienia
 */
stEventDispatcher::getInstance()->connect('stOrderActions.postExecuteSummary', array('stLanguageListener', 'addOrderSummary'));