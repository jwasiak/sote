<?php
/** 
 * SOTESHOP/appCategoryHorizontalPlugin
 * 
 * Ten plik należy do aplikacji stCategoryTreePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     appCategoryHorizontalPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 10617 2011-01-28 13:04:18Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

if (SF_APP == 'frontend')
{
    stPluginHelper::addEnableModule('appCategoryHorizontalFrontend', 'frontend');
    $dispatcher->connect('smarty.slot.append', array('appCategoryHorizontalListener', 'append'));
    $dispatcher->connect('stActions.preExecute', array('appCategoryHorizontalListener', 'preExecute'));
}
elseif (SF_APP == 'backend')
{
    stPluginHelper::addEnableModule('appCategoryHorizontalBackend', 'backend');
    stPluginHelper::addRouting('appCategoryHorizontalPlugin', '/categoryHorizontal/*', 'appCategoryHorizontalBackend', 'config', 'backend');
    $dispatcher->connect('autoStProductActions.postSave', array('appCategoryHorizontalListener', 'clearCache'));
    $dispatcher->connect('autoStProductActions.preDelete', array('appCategoryHorizontalListener', 'clearCache'));
    $dispatcher->connect('Category.postSave', array('appCategoryHorizontalListener', 'clearCache'));
    $dispatcher->connect('stCategoryTreeActions.preExecuteRemoveCategory', array('appCategoryHorizontalListener', 'clearCache'));
}
?>