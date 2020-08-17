<?php
/** 
 * SOTESHOP/stAvailabilityPlugin 
 * 
 * Ten plik należy do aplikacji stAvailabilityPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAvailabilityPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stAvailabilityPluginListener.class.php 1940 2009-06-30 14:15:45Z krzysiek $
 */

/** 
 * Podpięcie pod generator stProduct modułu stAvailabilityPlugin
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 *
 * @package     stAvailabilityPlugin
 * @subpackage  libs
 */
class stAvailabilityPluginListener
{
    /** 
     * Podpięcie zdarzenia dla generatora produktu
     *
     * @param                sfEvent     $event              zdarzenie
     */
    public static function generate(sfEvent $event)
    {
        // możemy wywoływać podaną metodę wielokrotnie co powoduje dołączenie kolejnych plików
        $event->getSubject()->attachAdminGeneratorFile('stAvailabilityPlugin', 'stProduct.yml');

    }

    /** 
     * Podpięcie zdarzenia do zapisywania produktu
     *
     * @author Marcin Olejniczak <marcin.olejniczak@sote.pl>
     * @param       sfEvent     $event
     */
    public static function postSave(sfEvent $event)
    {

        $product = $event->getSubject()->product;

        if($event->getSubject()->getRequestParameter('product[is_depository]')==0)
        {
            $base_product = ProductPeer::retrieveByPK($product->getId());
            $base_product->setAvailabilityId($event->getSubject()->getRequestParameter('product[availability_id]'));
            $base_product->save();
            if ($event->getSubject()->getRequestParameter('product[availability_id]')==false)
            {
                $base_product = ProductPeer::retrieveByPK($product->getId());
                $base_product->setAvailabilityId(null);
                $base_product->save();
            }

        }
        elseif ($event->getSubject()->getRequestParameter('product[is_depository]')==1)
        {
            if ($product->getId())
            {
                $base_product = ProductPeer::retrieveByPK($product->getId());
                $base_product->setAvailabilityId(null);
                $base_product->save();
            }
        }


        if ($event->getSubject()->getRequestParameter('product[stock]')=== ''){
            $base_product = ProductPeer::retrieveByPK($product->getId());
            $base_product->setStock(null);
            $base_product->save();
        }

    }

    /** 
     * Ograniczenie wyświetlania produktów ze względu na dostępność
     *
     * @param       sfEvent     $event
     */
    public static function addProductCriteria(sfEvent $event)
    {
        $config = stConfig::getInstance('stAvailabilityBackend');

        if ($config->get('hide_products_avail_on'))
        {
            AvailabilityPeer::addProductCriteria($event['criteria']);
        }
    }
}