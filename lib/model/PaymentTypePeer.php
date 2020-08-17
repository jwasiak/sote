<?php
/**
 * SOTESHOP/stPayment
 *
 * Ten plik należy do aplikacji stPayment opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPayment
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: PaymentTypePeer.php 10425 2011-01-21 13:41:46Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa PaymentTypePeer
 *
 * @package     stPayment
 * @subpackage  libs
 */
class PaymentTypePeer extends BasePaymentTypePeer
{
    protected static $activeModulesPool = null;

    protected static $cachePool = array();

    protected static $doSelectByModuleName = array();

    public static function isActive($moduleName)
    {
        if (null === self::$activeModulesPool) {
            $modules = array();

            foreach (self::doSelectCached() as $payment)
            {
                if (!isset($modules[$payment->getModuleName()]) || !$modules[$payment->getModuleName()])
                {
                    $modules[$payment->getModuleName()] = $payment->getActive();
                }
            }

            self::$activeModulesPool = $modules;
        }

        return isset(self::$activeModulesPool[$moduleName]) && self::$activeModulesPool[$moduleName];
    }

    public static function isActiveById($id)
    {
        $payments = self::doSelectCached();

        return isset($payments[$id]) && $payments[$id]->getActive();
    }

    public static function doSelectCached($culture = null)
    {
        if (null === $culture)
        {
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }

        if (!isset(self::$cachePool[$culture]))
        {
            $fc = stFunctionCache::getInstance('stPayment');
            self::$cachePool[$culture] = $fc->cacheCall(array('PaymentTypePeer', 'doSelectCachedHelper'), array($culture), array('id' => 'all_payment_types_'.$culture));
        }

        return self::$cachePool[$culture];
    }

    public static function doSelectCachedHelper($culture)
    {
        $c = new Criteria();

        $results = array();

        foreach (self::doSelectWithI18n($c, $culture) as $payment)
        {
            $results[$payment->getId()] = $payment;
        }

        uasort($results, array('PaymentTypePeer', 'sortHelper'));

        return $results;
    }

    public static function doSelect(Criteria $c, $con = null) {
        if ($c->containsKey(self::HIDE_MODULE) == false)
            $c->add(self::HIDE_MODULE, 0);
        return parent::doSelect($c, $con);
    }

    public static function doCount(Criteria $c, $distinct = false, $con = null) {
        if ($c->containsKey(self::HIDE_MODULE) == false)
            $c->add(self::HIDE_MODULE, 0);
        return parent::doCount($c, $distinct, $con);
    }

    public static function doSelectByModuleName($name)
    {
        if (!isset(self::$doSelectByModuleName[$name]))
        {
            $payments = self::doSelectCached();

            $results = array();

            foreach ($payments as $payment)
            {
                if ($payment->getModuleName() == $name)
                {
                    $results[$payment->getId()] = $payment;
                }
            }

            self::$doSelectByModuleName[$name] = $results;
        }

        return self::$doSelectByModuleName[$name];
    }

    public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
    {
        if ($culture === null)
        {
            $culture = stLanguage::getHydrateCulture();
        }

        if ($c->containsKey(self::HIDE_MODULE) == false)
            $c->add(self::HIDE_MODULE, 0);

        return parent::doSelectWithI18n($c, $culture, $con);
    }

    public static function doCountWithI18n(Criteria $c, $con = null)
    {
        $c->addJoin(PaymentTypeI18nPeer::ID, PaymentTypePeer::ID);

        $c->add(PaymentTypeI18nPeer::CULTURE, stLanguage::getHydrateCulture());

        if ($c->containsKey(self::HIDE_MODULE) == false)
            $c->add(self::HIDE_MODULE, 0);

        return self::doCount($c, $con);
    }
    
    public static function retrieveByPK($pk, $con = null) {
        
        if ($con === null) {
            $con = Propel::getConnection(self::DATABASE_NAME);
        }

        $criteria = new Criteria(self::DATABASE_NAME);
        $criteria->add(self::ID, $pk);

        $v = parent::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    public static function sortHelper($p1, $p2)
    {
        return strnatcasecmp($p1->getName(), $p2->getName());
    }
}