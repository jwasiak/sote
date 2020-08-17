<?php
/** 
 * SOTESHOP/stProduct 
 * 
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProduct
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stProductEdit', '/product/:action/id/:id', 'stProduct', 'edit', 'backend');
stPluginHelper::addRouting('stProduct', '/product/:action/*', 'stProduct', 'list', 'backend');
stPluginHelper::addRouting('stProductDefault', '/product/:action', 'stProduct', 'list', 'backend');

stSocketView::addComponent('stProduct.galleryCustom.Content','stProduct','gallery');

stPluginHelper::addRouting('stProductCategoryFilter', '/product/index/category_filter/:category_filter', 'stProduct', 'index', 'backend');