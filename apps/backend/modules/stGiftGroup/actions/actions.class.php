<?php
/**
 * SOTESHOP/stGiftGroup
 *
 * Ten plik należy do aplikacji stGiftGroup opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stGiftGroup
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id:
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>, Paweł Byszewski <pawel.byszewski@sote.pl>
 */

/**
 * Akcje grupy produktów.
 *
 * @package stGiftGroup
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 */

class stGiftGroupActions extends autoStGiftGroupActions
{
    public function executeProductAddGroup()
    {
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        $ids = $this->getRequestParameter('product[selected]', array($this->getRequestParameter('id')));
        $related_id = $this->getRequestParameter('forward_parameters[product_group_id]');

        $pids = $this->getAffectedProducts($ids, $related_id);

        $new = array();

        foreach ($ids as $id)
        {
            if (in_array($id, $pids)) 
            {
                continue;
            }

            $product_group_has_product = new ProductGroupHasProduct();
            $product_group_has_product->setProductGroupId($related_id);
            $product_group_has_product->setProductId($id);
            $product_group_has_product->save(); 
            $new[] = $id;
        }

        if ($new)
        {
            $this->updateProducts($new, true);
        }

        $this->redirect($this->getRequest()->getReferer());
    }


    public function executeProductRemoveGroup()
    {
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        $ids = $this->getRequestParameter('product[selected]', array($this->getRequestParameter('id')));
        $related_id = $this->getRequestParameter('forward_parameters[product_group_id]');

        $ids = $this->getAffectedProducts($ids, $related_id);

        if ($ids)
        {
            $con = Propel::getConnection();
            $c = new Criteria();
            $c->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $related_id);
            $c->add(ProductGroupHasProductPeer::PRODUCT_ID, $ids, Criteria::IN);   
            BasePeer::doDelete($c, $con);
            $this->updateProducts($ids, false);
        }

        $this->redirect($this->getRequest()->getReferer());
    }

    public function addProductFiltersCriteria($c)
    {
        parent::addProductFiltersCriteria($c);

        if (isset($this->filters['list_image']) && $this->filters['list_image'] !== '')
        {
            $c->add(ProductPeer::OPT_IMAGE, null, $this->filters['list_image'] ? Criteria::ISNOTNULL : Criteria::ISNULL);
        }

        if (isset($this->filters['list_assigned']) && $this->filters['list_assigned'] !== '')
        {
            $c->addJoin(ProductPeer::ID, sprintf("%s AND %s = %d", ProductGroupHasProductPeer::PRODUCT_ID, ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $this->forward_parameters['product_group_id']), Criteria::LEFT_JOIN);
            
            if ($this->filters['list_assigned'])
            {
                $c->add(ProductGroupHasProductPeer::ID, null, Criteria::ISNOTNULL);
            }
            else
            {
                $c->add(ProductGroupHasProductPeer::ID, null, Criteria::ISNULL);
            }
        }

        $c->add(ProductPeer::OPT_HAS_OPTIONS, 1, Criteria::LESS_EQUAL);
    } 

    protected function addFiltersCriteria($c)
    {
        $c->add(ProductGroupPeer::FROM_BASKET_VALUE, null, Criteria::ISNOTNULL);

        parent::addFiltersCriteria($c);
    }  

    protected function updateProducts($ids, $is_gift)
    {
        $con = Propel::getConnection();

        if ($is_gift)
        {
            $sql = 'UPDATE %1$s SET %2$s = %2$s + 1 WHERE %3$s IN ('.implode(',', $ids).')';
        } 
        else
        {
            $sql = 'UPDATE %1$s SET %2$s = %2$s - 1 WHERE %3$s IN ('.implode(',', $ids).')';
        }

        $st = $con->prepareStatement(sprintf($sql,
            ProductPeer::TABLE_NAME,
            ProductPeer::IS_GIFT,
            ProductPeer::ID
        ));


        $st->executeUpdate();
    } 

    protected function getAffectedProducts($ids, $related_id)
    {
        $c = new Criteria();
        $c->addSelectColumn(ProductGroupHasProductPeer::PRODUCT_ID);
        $c->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $related_id);
        $c->add(ProductGroupHasProductPeer::PRODUCT_ID, array_values($ids), Criteria::IN);
        // throw new Exception('tes32!');
        $rs = ProductGroupHasProductPeer::doSelectRs($c);   

        $pids = array();

        while($rs->next())
        {
            $row = $rs->getRow();
            $pids[] = $row[0];
        } 

        return $pids;       
    }   
}
