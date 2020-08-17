<?php
/**
 * SOTESHOP/stWebApiPlugin
 *
 * Ten plik należy do aplikacji stWebApiPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('stWebApiBackend', 'backend');
    stPluginHelper::addRouting('stWebApiPlugin', '/webapi/:action/*', 'stWebApiBackend', 'list', 'backend');

    // pobieramy instancję obiektu sfEventDispatcher
    $dispatcher = stEventDispatcher::getInstance();

    // dodajemy sluchacza dla zdarzenia stAdminGenerator.generateStDemo
    $dispatcher->connect('stAdminGenerator.generateStProducer', array('stWebApiListener', 'StProducerGenerate'));
    $dispatcher->connect('stAdminGenerator.generateStCategory', array('stWebApiListener', 'StCategoryGenerate'));
    $dispatcher->connect('stAdminGenerator.generateStPaymentType', array('stWebApiListener', 'StPaymentTypeGenerate'));
    $dispatcher->connect('stAdminGenerator.generateStProduct', array('stWebApiListener', 'StProductGenerate'));
    $dispatcher->connect('stAdminGenerator.generateStUser', array('stWebApiListener', 'StUserGenerate'));
    $dispatcher->connect('stAdminGenerator.generateStOrder', array('stWebApiListener', 'StOrderGenerate'));
    $dispatcher->connect('stAdminGenerator.generateStCurrencyBackend', array('stWebApiListener', 'StCurrencyGenerate'));
    $dispatcher->connect('stAdminGenerator.generateStDiscountBackend', array('stWebApiListener', 'StDiscountGenerate'));
    $dispatcher->connect('stAdminGenerator.generateStGiftCardBackend', array('stWebApiListener', 'StGiftCardGenerate'));
}