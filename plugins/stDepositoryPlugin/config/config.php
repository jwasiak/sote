<?php
/** 
 * SOTESHOP/stDepositoryPlugin 
 * 
 * Ten plik należy do aplikacji stDepositoryPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stDepositoryPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 617 2009-04-09 13:02:31Z michal $
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 */

/** 
 * Konfiguracja modułu stDepositoryPlugin
 *
 * @package stDepositoryPlugin
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 */

stPluginHelper::addEnableModule('stDepositoryFrontend', 'frontend');

$dispatcher->connect('Order.preSave', array('stDepositoryPluginListener', 'preSaveOrder'));

if (SF_APP == 'frontend')
{
    $dispatcher->connect('stOrderActions.validateSave', array('stDepositoryPluginListener', 'validateOrderSave'));
}

if (SF_APP == 'backend')
{
    $dispatcher->connect('stAdminGenerator.generateStProduct', array('stDepositoryPluginListener', 'generate')); 
    $dispatcher->connect('autoStProductActions.addDepositoryFiltersCriteria', array('stDepositoryPluginListener', 'addDepositoryFiltersCriteria'));
    $dispatcher->connect('Product.setListStock', array('stDepositoryPluginListener', 'productSetListStock'));
}

?>
