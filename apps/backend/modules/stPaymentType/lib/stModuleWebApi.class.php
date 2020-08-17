<?php

class StPaymentTypeWebApi extends autoStPaymentTypeWebApi
{
    /**
     * @inheritdoc
     */
    public function getGetPaymentTypeListCriteria($object)
    {
        $c = parent::getCountPaymentTypeCriteria($object);

        if (isset($object->is_active)) {
            $c->add(PaymentTypePeer::ACTIVE, $object->is_active);            
        }        

        return $c;
    }

    /**
     * @inheritdoc
     */
    public function getCountPaymentTypeCriteria($object)
    {
        return $this->getGetPaymentTypeListCriteria($object);
    }
}