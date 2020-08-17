<?php
/** 
 * SOTESHOP/stPointsPlugin 
 * 
 * Ten plik należy do aplikacji stPointsPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stPointsPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 665 2009-04-16 07:43:27Z michal $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Włączanie modułów
 */

stPluginHelper::addEnableModule('stPointsBackend', 'backend');
stPluginHelper::addEnableModule('stPointsFrontend', 'frontend');

/**
 * Routingi
 */

stPluginHelper::addRouting('stPointsPlugin', '/points/:action/*', 'stPointsBackend', 'list', 'backend');
stPluginHelper::addRouting('stPointsPlugin', '/points/:action/*', 'stPointsFrontend', 'list', 'frontend');

stConfiguration::addModule('stPointsPlugin', 'group_2');

$dispatcher->connect('stOrderActions.postExecuteSave', array('stPointsPluginListener', 'postExecuteOrderSave'));
$dispatcher->connect('stOrderApiActions.postUpdateStatus', array('stPointsPluginListener', 'updateWebApiPointsAssigned'));
$dispatcher->connect('stActions.preExecute', array('stPointsPluginListener', 'preExecute'));
