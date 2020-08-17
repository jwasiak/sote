<?php

class AllegroDelivery extends BaseAllegroDelivery {

    public function setValue($v) {
        parent::setValue(json_encode($v));
    }

    public function getValue() {
        return json_decode(parent::getValue(), true);
    }

     public function save($con = null) {
        if ($this->isColumnModified(AllegroDeliveryPeer::IS_DEFAULT) && $this->getIsDefault()) {
            $s = new Criteria();
            $s->add(AllegroDeliveryPeer::IS_DEFAULT, TRUE);
            $s->add(AllegroDeliveryPeer::ENVIRONMENT, $this->getEnvironment());

            $u = new Criteria();
            $u->add(AllegroDeliveryPeer::IS_DEFAULT, FALSE);
            $u->add(AllegroDeliveryPeer::ENVIRONMENT, $this->getEnvironment());

            BasePeer::doUpdate($s, $u, Propel::getConnection());
        }

        parent::save($con);
    }
}
