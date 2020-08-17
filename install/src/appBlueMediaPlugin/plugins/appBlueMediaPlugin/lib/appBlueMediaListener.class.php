<?php

class appBlueMediaListener
{
    public static function smartySlotAppend(sfEvent $event, $components)
    {
        if (($event['slot'] == 'base-footer' || $event['slot'] == 'base_footer') && stConfig::getInstance('appBlueMedia')->get('enabled')) {
            $components[] = $event->getSubject()->createComponent('appBlueMediaFrontend', 'helper');
        }

        return $components;      
    } 

    public static function postExecuteSaveOrder(sfEvent $event)
    {
        $action = $event->getSubject();

        if ($action->getRequest()->getParameter('user_data_billing[bluemedia_gateway]'))
        {
            $payment = $action->order->getOrderPayment();
            $payment->setConfigurationParameter('gateway_id', $action->getRequest()->getParameter('user_data_billing[bluemedia_gateway]'));
            $payment->save();
        }
    }

    public static function smartyRenderOrderConfirm(sfEvent $event)
    {
        /**
         * @var stSmarty $smarty
         */
        $smarty = $event->getSubject();

        $context = $smarty->getContext();

        $payment_description = $smarty->get_template_vars('payment_description');

        if ($context->getRequest()->getParameter('user_data_billing[bluemedia_gateway]'))
        {
            $gateway = appBlueMedia::getInstance()->getGatewayInfo($context->getRequest()->getParameter('user_data_billing[bluemedia_gateway]'));

            if ($gateway)
            {
                $payment_description = '<div><img src="' . $gateway['icon'] . '" alt="' . $gateway['name']. '" style="max-width: 50px; vertical-align: middle"> ' . $gateway['name'] . '</div>';
            }

            $smarty->assign('payment_description', $payment_description);
        }
    }
}