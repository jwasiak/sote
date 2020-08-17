<?php
class stFixProductOptions {

    public function fix($step) {
        $c = new Criteria();
        $c->setOffset($step);
        $c->addAscendingOrderByColumn(ProductPeer::ID);
        $product = ProductPeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product->getId());

        $values = ProductOptionsValuePeer::doSelect($c);

        foreach ($values as $value) {
            $this->deleteOld($value);
        }

        $values = ProductOptionsValuePeer::doSelect($c);
        foreach ($values as $value) {
            $this->repair($value);
        }

        $values = ProductOptionsValuePeer::doSelect($c);

        foreach ($values as $value) {
            $value->save();
            $this->fixDepth($value);
            $this->fixTemplateId($value);
        }

        foreach ($values as $value) {
            $value = $value->reload();
            $this->fixField($value);
        }

        foreach ($values as $value) {
            $value = $value->reload();
            $this->fixStock($value);
            $value->save();
        }

        return ($step+1);
    }

    public function fixDepth($object) {
        if ($object->getDepth()==null) {
            $c = new Criteria();
            $c->add(ProductOptionsValuePeer::LFT,$object->getLft(), Criteria::LESS_THAN);
            $c->add(ProductOptionsValuePeer::RGT,$object->getRgt(), Criteria::GREATER_THAN);
            $c->add(ProductOptionsValuePeer::PRODUCT_ID,$object->getProductId());
            $object->setDepth(ProductOptionsValuePeer::doCount($c));
        }
    }

    public function fixStock($object) {
        if (!$object->isLeaf()) {
            $con = Propel::getConnection();
            $stmt = $con->createStatement();
            $sql = "SELECT SUM(".ProductOptionsValuePeer::STOCK.") as option_stock FROM ".ProductOptionsValuePeer::TABLE_NAME."
                WHERE ".ProductOptionsValuePeer::LFT.">".$object->getLft()." AND ".ProductOptionsValuePeer::RGT."<".$object->getRgt()."
                AND ".ProductOptionsValuePeer::PRODUCT_ID."=".$object->getProductId();
            $rs = $stmt->executeQuery($sql);
            if ($rs->next()) {
                $object->setStock((int)$rs->getInt('option_stock'));
            }
        }
    }

    public function fixField($object) {
        if (!$object->isRoot()) {
            $field_id = $object->getProductOptionsFieldId();
            $field = $object->getProductOptionsField();
            if (is_object($field)) {
                if (is_object($object->getParent())) {
                    if ($field->getOptValueId() != $object->getParent()->getId()) {
                        print $field->getOptValueId()."->".$object->getParent()->getId()."<br />";
                        $newField = new ProductOptionsField();
                        $newField->setCulture('pl_PL');
                        $newField->setName($field->getName());
                        $newField->setProductOptionsTemplateId(0);
                        $newField->setOptDefaultValue($field->getOptDefaultValue());
                        $newField->setOptValueId($object->getParent()->getId());
                        $newField->save();

                        $c = new Criteria();
                        $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $field_id);
                        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $object->getProductId());

                        foreach (ProductOptionsValuePeer::doSelect($c) as $value) {
                            $value->setProductOptionsFieldId($newField->getId());
                            $value->save();
                        }
                    }
                }
            } else {

            }
        }
    }

    public function fixDeletedTemplate($object) {
        if ($object->getDepth()==1 && !is_object($object->getParent())) {
            $c = new Criteria();
            $c->add(ProductOptionsValuePeer::PRODUCT_ID, $object->getProductId());
            $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, null, Criteria::ISNULL);

            $parent = ProductOptionsValuePeer::doSelectOne($c);

            $object->insertAsLastChildOf($parent);
        }
    }

    public function fixTemplateId($object) {
        if (!$object->isRoot()) {
            $object->setProductOptionsTemplateId(0);
        }
    }

    public function fixStockForField($object) {
        if (!$object->isRoot()) {

        }
    }

    public function deleteOld($object) {
        if ($object->getProductOptionsValueId()!=null && !is_object($object->getParent())) {
            $object->delete();
        }
    }

    public function repair($parent) {

        $c = new Criteria();
        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $parent->getProductId());
        $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $parent->getId());
        $c->addAscendingOrderByColumn(ProductOptionsValuePeer::ID);

        $options = ProductOptionsValuePeer::doSelect($c);
        foreach ($options as $option) {
            $parent = $parent->reload();
            $option->insertAsLastChildOf($parent);
            $option->save();
        }
    }

    public static function count() {
        return ProductPeer::doCount(new Criteria());
    }
}