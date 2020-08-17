<?php

class PaczkomatyPack extends BasePaczkomatyPack {

    protected $allegroTransaction = null;

    protected $sendingMethod = null;

    protected $dropoffPoint = null;

    protected $endOfWeekCollection = false;

    public function getOrderNumber() {
        if ($this->order_id) {
            $order = OrderPeer::retrieveByPK($this->order_id);
            if(is_object($order))
                return $order->getNumber();
        }
        return null;
    }

    public function getTrackingUrl()
    {
        return "https://inpost.pl/pl/pomoc/znajdz-przesylke?parcel=".rawurlencode($this->getCode());
    }

    public function setCustomerPhone($v)
    {
        $v = str_replace(array('+48', ' ', '-'), '', $v);
        return parent::setCustomerPhone($v);
    }

    public function setCustomerPickupPoint($v)
    {
        $this->setCustomerPaczkomat($v);
    }

    public function getCustomerPickupPoint()
    {
        return $this->getCustomerPaczkomat();
    }

    public function setDropOffPoint($v)
    {
        $this->dropoffPoint = $v;
    }

    public function getDropOffPoint()
    {
        return $this->dropoffPoint;
    }  

    public function setEndOfWeekCollection($v)
    {
        $this->endOfWeekCollection = $v;
    }

    public function getEndOfWeekCollection()
    {
        return $this->endOfWeekCollection;
    }

    public function setTrackingNumber($v)
    {
        $this->setCode($v);
    }

    public function getTrackingNumber()
    {
        return $this->getCode();
    } 

    public function isEditable()
    {
        return null === $this->getStatus() || in_array($this->getStatus(), array('created', 'offers_prepared', 'offer_selected'));
    }

    public function getStatusLabel()
    {
        $api = stInPostApi::getInstance();

        $label = null;

        try
        {
            if ($this->getInpostShipmentId())
            {
                $shipment = $api->getShipment($this->getInpostShipmentId());
            }
            else
            {
                $shipment = $api->getShipmentByTrackingNumber($this->getTrackingNumber());
            }

            $label = $shipment ? $api->getStatusTitleByName($shipment->status) : '-';
        }
        catch(stInPostApiException $e)
        {
            $shipment = null;
        }

        return $label ? $label : '-';
    }
    
    /**
     * Zwraca predefiniowany formiar paczki
     *
     * @return string Zwraca 'small', 'medium' or 'large'
     */
    public function getParcelTemplate()
    {
        $templates = array(
            'A' => 'small',
            'B' => 'medium',
            'C' => 'large',
        );

        return $templates[$this->getPackType()];
    }

    public function setParcelTemplate($template)
    {
        $types = array(
            'small' => 'A',
            'medium' => 'B',
            'large' => 'C',
        );       

        $this->setPackType($types[$template]);
    }

    public function save($con = null)
    {
        $modified = $this->isColumnModified(PaczkomatyPackPeer::CODE);
       
        $ret = parent::save($con);


        if ($modified) 
        {
            $orderDelivery = $this->getOrder()->getOrderDelivery();

            if ($orderDelivery)
            {
                $orderDelivery->setNumber($this->getCode());
                $orderDelivery->save();
            }

            $orderUserDataDelivery = $this->getOrder()->getOrderUserDataDelivery();

            if ($orderUserDataDelivery)
            {
                $machines = stPaczkomatyMachines::getListOfMachines();

                foreach ($machines as $inpost) 
                {
                    if ($inpost['number'] == $this->getCustomerPaczkomat())
                    {
                        break;
                    }
                }

                $orderUserDataDelivery->setCompany('Paczkomat - '.$inpost['number']);
                $orderUserDataDelivery->setFullName(null);
                $orderUserDataDelivery->setAddress($inpost['street'].' '.$inpost['house']);
                $orderUserDataDelivery->setCode($inpost['postCode']);
                $orderUserDataDelivery->setAddressMore(null);
                $orderUserDataDelivery->setTown($inpost['city']);
                $orderUserDataDelivery->save();
            }
        }

        return $ret;
    }

    public function getCashOnDelivery($fetchFromOrder = false)
    {
        $ret = parent::getCashOnDelivery();

        if (null === $ret && $this->getOrder()->isAllegroOrder())
        {
            $type = $this->getOrder()->getOrderPayment()->getAllegroPaymentType();
            $ret = in_array($type, array('cash_on_delivery', 'collect_on_delivery')) ? $this->getOrder()->getUnpaidAmount() : null;
            $this->setCashOnDelivery($ret);
        }

        if (null === $ret && $fetchFromOrder)
        {
            return $this->getOrder()->getUnpaidAmount();
        }

        return $ret;
    }

    public function hasAllegroTransactionId()
    {
        return $this->getOrder()->isAllegroOrder();
    }

    public function hasAllegroInsurance()
    {
        return $this->hasAllegroTransactionId() && ($this->getOrder()->getOptTotalAmount() - $this->getOrder()->getOrderDelivery()->getCost(true) <= 5000);
    }

    public function getAllegroTransactionId()
    {
        if (null === $this->allegroTransaction)
        {
            if ($this->getOrder()->getOptAllegroCheckoutFormId() && !is_numeric($this->getOrder()->getOrderPayment()->getTransactionId()))
            {
                $api = stAllegroApi::getInstance();
                $this->allegroTransaction = $api->getPaymentMapping($this->getOrder()->getOrderPayment()->getTransactionId());
            } 
            else
            {
                $order = $this->getOrder();
            
                $c = new Criteria();
                // $c->add(AllegroAuctionHasOrderPeer::ALLEGRO_AUCTION_ID, $order->getOptAllegroAuctionId());
                $c->add(AllegroAuctionHasOrderPeer::ORDER_ID, $order->getId());
    
                $allegroTransaction = AllegroAuctionHasOrderPeer::doSelectOne($c);  

                $this->allegroTransaction = $allegroTransaction ? $allegroTransaction->getTransId() : null;
            }
        }

        return $this->allegroTransaction;      
    }

    public function getInsurance($fetchFromOrder = false)
    {
        $ret = parent::getInsurance();

        if (!$ret && $fetchFromOrder)
        {
            return stPrice::round($this->getOrder()->getOptTotalAmount() - $this->getOrder()->getOrderDelivery()->getCost(true));
        }

        return $ret;
    }

    public function hasCashOnDelivery()
    {
        if ($this->getHasCashOnDelivery()) {
            return true;
        }

        $payment = $this->getOrder()->getOrderPayment();

        $config = stConfig::getInstance('stPaczkomatyBackend');

        return $payment && in_array($payment->getPaymentTypeId(), $config->get('payment', array()));
    }
}
