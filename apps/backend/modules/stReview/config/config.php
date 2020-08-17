<?php
/** 
 * SOTESHOP/stReview 
 * 
 * Ten plik należy do aplikacji stReview opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stReview
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 1153 2009-10-07 08:24:35Z pawel $
 * @author      Paweł Byszewski <pawel.byszewski@sote.pl>
 */

/** 
 * Dodawanie routingu
 */
stPluginHelper::addRouting('stReview', '/review/:action/*', 'stReview', 'index', 'backend');
stPluginHelper::addRouting('stReviewOrder', '/review_order/:action/*', 'stReviewOrder', 'index', 'backend');

/** 
 * Dodawanie zakładki do menu
 */
stSocketView::addPartial('stProductMenuEdit', 'stReview/productMenuEdit');

/** 
 * Pobiera instancję obiektu sfEventDispatcher
 */
$dispatcher = stEventDispatcher::getInstance();


/** 
 * Dodaje sluchacza dla zdarzenia generator.generate
 */
$dispatcher->connect('stAdminGenerator.generateStProduct', array('stReviewListener', 'generate')); 
$dispatcher->connect('autoStProductActions.preSaveReview', array('stReviewListener', 'preSaveProductReview'));
$dispatcher->connect('autostProductActions.postExecuteReviewList', array('stReviewListener', 'postExecuteReviewList'));
$dispatcher->connect('Order.preSave', array('stReviewListener', 'postExecuteOrderSave'));


