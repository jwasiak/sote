<?php

class stPocztaPolskaListener
{
    protected static $point = null;

    public static function postOrderConfirm(sfEvent $event) 
    { 
        $action = $event->getSubject();

        $delivery = stDeliveryFrontend::getInstance($action->getUser()->getBasket())->getDefaultDelivery();

        $point = self::getPoint();

        if ($point && $delivery->isType('ppo'))
        {
            $data = array(
                'company' => $point['name'],
                'full_name' => '',
                'address' => $point['street'],
                'code' => $point['zipCode'],
                'town' => $point['city'],
                'phone' => '',
                'address_more' => '',
                'customer_type' => '2',
            );

            $action->user_data_delivery = array_merge($event->getSubject()->user_data_delivery, $data);
        }
    }  

    public static function smartySlotAppend(sfEvent $event, $components)
    {
        if ($event['slot'] == 'base-footer' && stConfig::getInstance('stPocztaPolskaBackend')->get('enabled')) {
            $components[] = $event->getSubject()->createComponent('stPocztaPolskaFrontend', 'helper');
        }

        return $components;      
    }  

    public static function preExecuteOrderSave(sfEvent $event) 
    {
        $action = $event->getSubject();
        $billingData = $action ->getRequest()->getParameter('user_data_billing');
        $deliveryData = $action ->getRequest()->getParameter('user_data_delivery');

        $delivery_id = $action->getRequestParameter('delivery_id');

        $point = self::getPoint();

        if ($point) {
            $delivery = DeliveryPeer::retrieveByPK($delivery_id);

            if ($delivery && $delivery->isType('ppo'))
            {
                $deliveryData['company'] = $billingData['company'];
                $deliveryData['full_name'] = $billingData['full_name'];
                $deliveryData['address'] = $billingData['address'];
                $deliveryData['code'] = $billingData['code'];
                $deliveryData['town'] = $billingData['town'];
                $deliveryData['phone'] = $billingData['phone'];
                $deliveryData['customer_type'] = $billingData['customer_type'];
                $action->getRequest()->setParameter('user_data_delivery', $deliveryData);
            }
        }
    }

    public static function postExecuteOrderSave(sfEvent $event) 
    {
        $action = $event->getSubject();

        $point = self::getPoint();

        if ($point && $action->order->getOrderDelivery()->getDelivery()->isType('ppo')) {
            $pp = new PocztaPolskaPunktOdbioru();
            $pp->setPoint($point);
            $pp->setOrder($action->order);
            $pp->save();

            $d = $action->order->getOrderUserDataDelivery();
            $d->setCompany($point['name']);
            $d->setFullName(null);
            $d->setAddress($point['street']);
            $d->setCode($point['zipCode']);
            $d->setAddressMore(null);
            $d->setTown($point['city']);
            $d->save();
        }
    }

    public static function postExecuteAjaxDeliveryCountryUpdate(sfEvent $event)
    {
        $action = $event->getSubject();

        $action->responseEvalJs('jQuery(document).trigger("poczta-polska-widget-init")');
    }

    public static function filterOrderSave(sfEvent $event)
    {
        $order = $event['order'];

        $point = self::getPoint();

        if ($point && $order->getOrderDelivery()->getDelivery()->isType('ppo'))
        {
            $order->getOrderDelivery()->setPickupPoint($point['pni']);
        }

        return $order;
    }

    protected static function getPoint()
    {
        if (null === self::$point)
        {
            $user_data_billing = sfContext::getInstance()->getRequest()->getParameter('user_data_billing');

            self::$point = json_decode($user_data_billing['poczta_polska'], true);
        }

        return self::$point;
    }
}