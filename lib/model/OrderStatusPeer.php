<?php

/** 
 * SOTESHOP/stOrder 
 * 
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stOrder
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: OrderStatusPeer.php 12380 2011-04-20 11:39:14Z piotr $
 */

/** 
 * SOTESHOP/stOrder
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOrder
 * @subpackage  libs
 */
class OrderStatusPeer extends BaseOrderStatusPeer
{
    const ST_CANCELED = 'anulowane';
    const ST_PENDING = 'oczekuje';
    const ST_COMPLETE = 'zrealizowane';

    protected static $idsByTypePool = array();

    protected static $cachePool = array();
    /** 
     * Zwraca listę stałych typów statusów
     *
     * @return  array       Lista typów statusów  
     */
    public static function getTypes()
    {
        return array('ST_CANCELED' => self::ST_CANCELED, 'ST_PENDING' => self::ST_PENDING, 'ST_COMPLETE' => self::ST_COMPLETE);
    }
    
    /** 
     * Zwraca nazwę dla danego typu statusu
     *
     * @return   string
     */
    public static function getNameFromType($type)
    {
        $types = self::getTypes();
        
        return isset($types[$type]) ? $types[$type] : '';
    }
    
    /** 
     * Zwraca domyślny stan typu ST_PENDING
     *
     * @return   OrderStatus
     */
    public static function retrieveDefaultPendingStatus()
    {
        $c = new Criteria();
        
        $c->add(self::IS_DEFAULT, true);
        
        $c->add(self::TYPE, 'ST_PENDING');
        
        $status = self::doSelectOne($c);
        
        $status->setCulture(stLanguage::getOptLanguage());

        return $status;
    }
    
    /** 
     * Zwraca domyślny stan systemowy o podanym typie
     *
     * @param   const       $type               Typ stanu
     * @return   OrderStatus
     */
    public static function retrieveSystemStatusByType($type)
    {
        $c = new Criteria();
        
        $c->add(self::IS_SYSTEM_DEFAULT, true);
        
        $c->add(self::TYPE, $type);
        
        return self::doSelectOne($c);
    }

    public static function retrieveStatusIdsByType($type)
    {
        $c = new Criteria();
                
        $c->addSelectColumn(self::ID);

        $c->add(self::TYPE, $type);     

        $rs = self::doSelectRs($c);

        $ids = array();

        while($rs->next())
        {
         $ids[] = $rs->getInt(1);
        }

        return $ids;
    } 

    public static function clearCache()
    {
      $fc = new stFunctionCache('stOrderStatus');

      $fc->removeAll();
    } 

    public static function doSelectCachedArray($culture = null)
    {
       $results = OrderStatusPeer::doSelectCached($culture);

       $options = array();

        foreach ($results as $status)
        {
            $options[$status->getId()] = $status->getNameWithMailNotification();
        } 
       
       return $options;       
    }

    public static function doSelectCached($culture = null)
    {
        if (null === $culture)
        {
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }

        if (!isset(self::$cachePool[$culture]))
        {
            $fc = stFunctionCache::getInstance('stOrderStatus');

            self::$cachePool[$culture] = $fc->cacheCall(array('OrderStatusPeer', 'doSelectCachedHelper'), array($culture));
        }

        return self::$cachePool[$culture];      
    }

    public static function doSelectCachedHelper($culture)
    {
        $results = array();

        $c = new Criteria();

        foreach (self::doSelectWithI18n($c, $culture) as $result) 
        {
            $results[$result->getId()] = $result;               
        }

        uasort($results, array('OrderStatusPeer', 'sortHelper'));

        return $results;
    }

    public static function sortHelper($s1, $s2)
    {
        return strnatcasecmp($s1->getName(), $s2->getName());
    }

    public static function doSelectIdsByType($type)
    {
        if (!isset(self::$idsByTypePool[$type]))
        {
            $ids = array();

            foreach (self::doSelectCached() as $id => $status) 
            {
                if ($status->getType() == $type)
                {
                    $ids[] = $id;
                }    
            }

            self::$idsByTypePool[$type] = $ids;
        }

        return self::$idsByTypePool[$type];
    }
}
