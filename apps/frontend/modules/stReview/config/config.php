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
 * @version     $Id: config.php 8780 2010-10-14 07:44:51Z bartek $
 * @author      Paweł Byszewski <pawel.byszewski@sote.pl>
 */

stPluginHelper::addRouting('stReview', '/review/:action/*', 'stReview', 'add', 'frontend');
stPluginHelper::addRouting('stReviewAdd', '/review/add/:order_id/:hash_code', 'stReview', 'add', 'frontend');

/**
 * Dodaje sluchacza dla akcji stProduct
 */
    $dispatcher = stEventDispatcher::getInstance();
    $dispatcher->connect('stProductActions.postExecuteShow', array('stReviewListener', 'postExecuteShow'));

/**
 * Dodaje sluchacza dla akcji stUserData
 */
    $dispatcher = stEventDispatcher::getInstance();
    $dispatcher->connect('stUserDataComponents.postExecuteUserPanelMenu', array('stReviewListener', 'postExecuteUserPanelMenu'));
