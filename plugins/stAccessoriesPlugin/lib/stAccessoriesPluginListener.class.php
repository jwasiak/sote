<?php
/**
 * SOTESHOP/stAccessoriesPlugin
 *
 * Ten plik należy do aplikacji stAccessoriesPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stAccessoriesPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stAccessoriesPluginListener.class.php 8476 2010-09-28 09:57:05Z krzysiek $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/**
 * Podpięcie pod generator stProduct modułu ststAccessoriesPlugin
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>
 *
 * @package     stAccessoriesPlugin
 * @subpackage  libs
 */
class stAccessoriesPluginListener
{
    /**
     * Podpięcie zdarzenia dla generatora produktu
     *
     * @param       sfEvent     $event
     */
    public static function generate(sfEvent $event)
    {
        // możemy wywoływać podaną metodę wielokrotnie co powoduje dołączenie kolejnych plików
        $event->getSubject()->attachAdminGeneratorFile('stAccessoriesPlugin', 'stProduct.yml');
    }


    public static function postExecuteProductInAccessoriesList(sfEvent $event)
    {
        $action = $event->getSubject();

        $c = $action->pager->getCriteria();

        $c->add(ProductHasAccessoriesPeer::PRODUCT_ID, $action->forward_parameters['product_id']);
        $c->addJoin(ProductHasAccessoriesPeer::ACCESSORIES_ID, ProductPeer:: ID);
        $c->setDistinct();
        if (isset($action->filters['product_related_by_accessories_id']) && $action->filters['product_related_by_accessories_id'] !== '')
        {
            $c->addJoin(ProductPeer::ID, ProductI18nPeer::ID, Criteria::LEFT_JOIN);

            $c->add(ProductI18nPeer::CULTURE, $action->getUser()->getCulture());
        }
        $action->pager->init();
    }

    public static function postExecuteManageAccessoriesList(sfEvent $event)
    {

        $action = $event->getSubject();

        $c = new Criteria();
        $c->add(ProductHasAccessoriesPeer::PRODUCT_ID, $action->forward_parameters['product_id']);
        $accessories=(ProductHasAccessoriesPeer::doSelect($c));

        $ids = array();
        $ids[] = $action->forward_parameters['product_id'];
        foreach ($accessories as $accesory)
        {
            $ids[] =  $accesory->getAccessoriesId();
        }

        $action->pager->getCriteria()->add(ProductPeer::ID, $ids, Criteria::NOT_IN);
        $action->pager->init();
    }


    public static function postExecuteShowAccessoriesList(sfEvent $event)
    {
        $action = $event->getSubject();

        if ($action->getController()->getTheme()->getVersion() < 7)
        {
            $config = stConfig::getInstance('stProduct');

            if ($config->get('show_accessories'))
            {
                $c = new Criteria();
                $c->addJoin(ProductHasAccessoriesPeer::ACCESSORIES_ID, ProductPeer::ID);
                $c->add(ProductPeer::ACTIVE, true);

                if ($action->product->countProductHasAccessoriessRelatedByProductId($c) > 0)
                {
                    $action->productDescription->addTab('Akcesoria', 'stAccessoriesFrontend', 'accessoriesList',array('id' => $action->product->getId()));
                }
            }
        }
    }
    /**
     *  Duplikowanie akcesorii produktu
     */
    public static function postExecuteDuplicate(sfEvent $event)
    {
        $c = new Criteria();
        $c->add(ProductHasAccessoriesPeer::PRODUCT_ID, $event['id']);
        $product_has_accessories = ProductHasAccessoriesPeer::doSelect($c);
        foreach ($product_has_accessories as $product_has_accessory)
        {
            $duplicate_product_has_accessory = $product_has_accessory->copy();
            $duplicate_product_has_accessory->setProductId($event['duplicate_id']);
            $duplicate_product_has_accessory->save();
        }

    }

}
?>