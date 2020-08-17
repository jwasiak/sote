<?php
/** 
 * SOTESHOP/stNewsletterPlugin 
 * 
 * Ten plik należy do aplikacji stNewsletterPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stNewsletterPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 665 2009-04-16 07:43:27Z michal $
 * @author      Karol Blejwas <karol.blejwas@sote.pl>
 */

/**
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stInvoiceFrontend', 'frontend');
stPluginHelper::addEnableModule('stInvoiceBackend', 'backend');
stPluginHelper::addEnableModule('stInvoicePdf', 'frontend');
stPluginHelper::addEnableModule('stInvoicePdf', 'backend');

/**
 * Routingi
 */
stPluginHelper::addRouting('stInvoicePlugin', '/invoice/:action/*', 'stInvoiceFrontend', 'index', 'frontend');
stPluginHelper::addRouting('stInvoicePlugin', '/invoice/:action/*', 'stInvoiceBackend', 'list', 'backend');
stPluginHelper::addRouting('stInvoicePluginDefault', '/invoice', 'stInvoiceBackend', 'confirmList', 'backend'); 
stPluginHelper::addRouting('stInvoicePluginPdf', '/invoicePdf/*', 'stInvoicePdf', 'show', 'frontend');
stPluginHelper::addRouting('stInvoicePluginPdf', '/invoicePdf/*', 'stInvoicePdf', 'show', 'backend');


/** 
 * Dodawanie socketów
 */
stSocketView::addComponent('stInvoiceBackend.configCustom.Content','stInvoiceBackend','configContent');
stSocketView::addComponent('stInvoiceBackend.viewCustom.Content','stInvoiceBackend','viewContent');
stSocketView::addComponent('stInvoiceBackend.viewEditCustom.Content','stInvoiceBackend','viewEditContent');
stSocketView::addComponent('under_basket_socket','stInvoiceFrontend','requestInvoice');

stEventDispatcher::getInstance()->connect('stOrderActions.postExecuteSave', array('stInvoiceListener', 'postExecuteOrderSave', 'last'));