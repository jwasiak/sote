<?php

class stPaczkomatyListener {

    public static function postUpdatePaczkomatyFromRequest(sfEvent $event) {
        if (isset($event['requestParameters']['disable_delivery']) && $event['requestParameters']['disable_delivery'] == 1) 
            $v = true;
        else 
            $v = false;

        $object = $event['modelInstance'];
        $object->setDisableDelivery($v);
        $object->save();
    }

    public static function smartySlotAppend(sfEvent $event, $components)
    {
        if (($event['slot'] == 'base-footer' || $event['slot'] == 'base_footer') && stPaczkomaty::isActive()) {
            $components[] = $event->getSubject()->createComponent('stPaczkomatyFrontend', 'helper');
        }

        return $components;      
    }  

    public static function postGetPaczkomatyOrCreate(sfEvent $event) {
        $action = $event->getSubject();

        if (!$action->getRequestParameter('id')) {

            $c = new Criteria();
            $c->add(PaczkomatyHasProductPeer::PRODUCT_ID, $action->forward_parameters['product_id']);
            $object = PaczkomatyHasProductPeer::doSelectOne($c);
            if (!$object) {
                $object = new PaczkomatyHasProduct();
                $object->setProductId($action->forward_parameters['product_id']);
            }
            $action->paczkomaty_has_product = $object;
        }
    }

    public static function postExecuteAjaxDeliveryCountryUpdate(sfEvent $event)
    {
        $event->getSubject()->responseEvalJs("jQuery(document).trigger('paczkomaty.ajaxUpdate')");
    }

    public static function postExecuteIndex(sfEvent $event) {
        $action = $event->getSubject();

        if (!$action->getRequest()->hasErrors() && $action->getRequestParameter('user_data_billing[paczkomaty_machine_number]'))
        {
            $action->getRequest()->setParameter('user_data_delivery', array());
        }
    }

    public static function postOrderConfirm(sfEvent $event) {
        if (!stPaczkomaty::isActive()) return false;

        $action = $event->getSubject();

        $delivery = stDeliveryFrontend::getInstance($action->getUser()->getBasket())->getDefaultDelivery()->getDelivery();

        self::redirect($action, $delivery);

        $inpost = json_decode($action->getRequestParameter('user_data_billing[paczkomaty_machine_number]'), true);
        
        if ($inpost && isset($inpost['name'])) {
            $country = CountriesPeer::retrieveByIsoA2('PL');
            $data = array('company' => 'Paczkomat - '.$inpost['name'],
                        'full_name' => '',
                        'address' => $inpost['address']['street'].' '.$inpost['address']['building_number'].($inpost['address']['flat_number'] ? '/'.$inpost['address']['flat_number'] : ''),
                        'code' => $inpost['address']['post_code'],
                        'town' => $inpost['address']['city'],
                        'phone' => '',
                        'address_more' => '',
                        'customer_type' => '2',
                        'country' => $country ? $country->getId() : null,
                        );
            $action->user_data_delivery = array_merge($action->user_data_delivery, $data);

        }
    }

    public static function preExecuteOrderSave(sfEvent $event) {
        if (!stPaczkomaty::isActive()) return false;
        $action = $event->getSubject();

        $user_billing = $action->getRequest()->getParameter('user_data_billing');
        $user_delivery = $action->getRequest()->getParameter('user_data_delivery');

        $delivery_id = $action->getRequestParameter('delivery_id');
        $delivery = DeliveryPeer::retrieveByPK($delivery_id);

        self::redirect($action, $delivery);

        if (!empty($user_billing['paczkomaty_machine_number'])) {
            $user_delivery['company'] = $user_billing['company'];
            $user_delivery['full_name'] = $user_billing['full_name'];
            $user_delivery['address'] = $user_billing['address'];
            $user_delivery['code'] = $user_billing['code'];
            $user_delivery['town'] = $user_billing['town'];
            $user_delivery['phone'] = $user_billing['phone'];
            $user_delivery['customer_type'] = $user_billing['customer_type'];
            $user_delivery['country'] = $user_billing['country'];
            $action->getRequest()->setParameter('user_data_delivery', $user_delivery);
        }
    }

    public static function postExecuteOrderSave(sfEvent $event) {
        if (!stPaczkomaty::isActive()) return false;

        $action = $event->getSubject();

        $inpost = json_decode($action->getRequestParameter('user_data_billing[paczkomaty_machine_number]'), true);

        if ($inpost && isset($inpost['name'])) {
            $action->order->getOrderDelivery()->setPaczkomatyNumber($inpost['name']);
            $country = CountriesPeer::retrieveByIsoA2('PL');
            $d = $action->order->getOrderUserDataDelivery();
            $d->setCompany('Paczkomat - '.$inpost['name']);
            $d->setFullName(null);
            $d->setAddress($inpost['address']['street'].' '.$inpost['address']['building_number'].($inpost['address']['flat_number'] ? '/'.$inpost['address']['flat_number'] : ''));
            $d->setCode($inpost['address']['post_code']);
            $d->setAddressMore(null);
            $d->setTown($inpost['address']['city']);
            $d->setCountriesId($country ? $country->getId() : null);
            $d->save();
        }
    }

    public static function redirect(stActions $action, Delivery $delivery = null)
    {
        $user_billing = $action->getRequest()->getParameter('user_data_billing');

        if (null === $delivery || !$delivery->isType('inpostp') && $user_billing['paczkomaty_machine_number'] || $delivery->isType('inpostp') && (!isset($user_billing['paczkomaty_machine_number']) || !$user_billing['paczkomaty_machine_number']))
        {
            $action->generateSessionCheck();
            return $action->redirect('@stBasket?action=index&session_expired=true');
        }
    }
}
