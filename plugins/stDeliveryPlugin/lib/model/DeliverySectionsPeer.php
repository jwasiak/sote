<?php

/**
 * Subclass for performing query and update operations on the 'st_delivery_sections' table.
 *
 *
 *
 * @package plugins.stDeliveryPlugin.lib.model
 */
class DeliverySectionsPeer extends BaseDeliverySectionsPeer
{
    public static function getAdditionalSectionCosts()
    {
        $i18n = sfContext::getInstance()->getI18N();

        return array(
        'ST_BY_ORDER_WEIGHT' => $i18n->__('Od wagi (kg)'),
        'ST_BY_ORDER_QUANTITY' => $i18n->__('Od ilości sztuk'),
        'ST_BY_ORDER_AMOUNT' => $i18n->__('Od kwoty zamówienia (brutto)')
        );
    }
}
