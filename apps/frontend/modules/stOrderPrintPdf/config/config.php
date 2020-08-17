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
stPluginHelper::addEnableModule('stOrderPrintPdf', 'frontend');

/**
 * Routingi
 */
stPluginHelper::addRouting('stOrderPrintPdfPlugin', '/orderPdf/:action/*', 'stOrderPrintPdf', 'show', 'frontend');
