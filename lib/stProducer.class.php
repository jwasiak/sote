<?php
abstract class stProducer
{
    protected static $producer = null;

    public static function getSelectedProducerId()
    {
        $context = sfContext::getInstance();

        return $context->getUser()->getParameter('id', $context->getRequest()->getParameter('producer_id'), 'soteshop/stProducer');
    }

    public static function setSelectedProducerId($id)
    {
        sfContext::getInstance()->getUser()->setParameter('id', $id, 'soteshop/stProducer');
        self::$producer = null;
    }

    public static function clearSelectedProducerId()
    {
        sfContext::getInstance()->getUser()->setParameter('id', null, 'soteshop/stProducer');
        self::$producer = null;
    }

    public static function getSelectedProducer()
    {
        if (null === self::$producer)
        {
            self::$producer = self::getSelectedProducerId() ? ProducerPeer::retrieveByPK(self::getSelectedProducerId()) : null;
        }

        return self::$producer;
    }
}