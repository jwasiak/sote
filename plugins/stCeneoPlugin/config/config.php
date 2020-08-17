<?php
/**
 * SOTESHOP/stCeneoPlugin
 *
 * Ten plik należy do aplikacji stCeneoPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCeneoPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 15167 2011-09-20 11:20:33Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

stPriceCompare::initPriceCompare('Ceneo');

if (SF_APP == 'frontend') {
    stPluginHelper::addEnableModule('stCeneoFrontend', 'frontend');
    stSocketView::addComponent('stOrderSummary', 'stCeneoFrontend', 'trustedOpinion');
    $dispatcher->connect('stBasketActions.preExecuteIndex', array('stCeneoPluginListener', 'preExecuteBasketIndex'));
    $dispatcher->connect('stBasketActions.validateIndex', array('stCeneoPluginListener', 'preExecuteBasketIndex'));
}