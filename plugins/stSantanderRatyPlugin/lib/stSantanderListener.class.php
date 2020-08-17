<?php

class stSantanderListener
{
    public static function validateAddBasketUser(sfEvent $event, $ok)
    {
        if (stSantander::isActive())
        {
            $action = $event->getSubject();

            if ($action->getRequest()->getMethod() == sfRequest::POST)
            {          
                $delivery = stDeliveryFrontend::getInstance($action->getUser()->getBasket())->getDefaultDelivery();       
    

                if ($delivery && $delivery->getDefaultPayment()->getPaymentType()->getModuleName() == 'stSantander' && $action->getUser()->getBasket()->getTotalAmount(true, true) < 100)
                {       
                    $action->setFlash('warning', $action->getContext()->getI18N()->__('Zakup na raty dostępny jest od 100 zł wartości produktu lub całego
        zamówienia', null, 'stSantanderFrontend'));
                    $ok = false;
                }
            }
        }

        return $ok;
    }
}