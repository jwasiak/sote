<?php

class sfStatsToolkit
{
  /**
   * Adds supplementary conditions to a criteria based on a list of filter configuration and values
   *
   * @param Criteria $criteria Criteria object to augment
   * @param Array    $filtersConfig List of the callables
   * @param Array    $filtersValues List of the values
   * @param String   $peerClass Optional class. If the `criteriaModifier` is a string,
   *                 then the callable taken into account is $class::$criteriaModifier
   *
   * Nothing is returned, but the Criteria object passed as parameter is modified by the callables.
   * These callables must expect a value and a Criteria object as parameter
   *
   * Example:
   *   $c = new Criteria();
   *   sfstatsToolKit::filterCriteria($c, array(
   *     'filter_1' => array('criteriaModifier' => 'callMe'),
   *     'filter_2' => array('criteriaModifier' => array('foo', 'bar')),
   *     'filter_3' => array('criteriaModifier' => 'whatever')
   *   ), array(
   *     'filter_1' =>  123,
   *     'filter_2' =>  'boo'
   *   ), 'PostPeer');
   * This will result in calling:
   *   PostPeer::callMe(123, $c);
   *   foo::bar('boo', $c);
   *
   * Note that empty values in the $filtersValues array do not trigger the call to the callable
   */
  public static function filterCriteria(Criteria $criteria, $filtersConfig, $filtersValues, $class = '')
  {
    foreach ($filtersValues as $key => $value)
    {
      $ok = false;
      if($value && isset($filtersConfig[$key]))
      {
        if(isset($filtersConfig[$key]['criteriaModifier']))
        {
          $criteriaModifier = $filtersConfig[$key]['criteriaModifier'];
          if(is_string($criteriaModifier))
          {
            if(!$class)
            {
              throw new Exception(sprintf('Filter %s does not define a full callable, so you must pass a `peerClass` parameter to `filterCriteria()`', $key));
            }
            $callable = array($class, $criteriaModifier);
          } 
          else
          {
            $callable = $criteriaModifier;
          }
          if(is_callable($callable))
          {
            call_user_func($callable, $value, $criteria);
            $ok = true;
          }
        }
        if(!$ok)
        {
          throw new Exception(sprintf('Filter %s needs a proper callable in the `criteriaModifier` parameter', $key));
        }
      }
    }
  }
  
  /**
   * Returns an array of timestamp/value pairs, based on a Propel Peer class and a column name.
   *
   * @param Integer  $begin     Timestamp of the minimal date
   * @param Integer  $end       Timestamp of the maximal date
   * @param Integer  $interval  Interval between each value (in seconds)
   * @param String   $class     Propel Peer class of the Model to search
   * @param String   $column    Propel column name (lowercase underscore syntax)
   * @param Criteria $c         Optional criteria to filter the search
   */
  public static function getAllValuesSmart($begin, $end, $interval, $class, $column, $c = null)
  {
    $columnConstant = constant($class.'::'.strtoupper($column));
    if(!$c)
    {
      $c = new Criteria();
    }
    $c->add($columnConstant, $begin, Criteria::GREATER_EQUAL)
      ->addAnd($columnConstant, $end, Criteria::LESS_THAN)
      ->clearSelectColumns()
      ->addSelectColumn($columnConstant) // Propel needs at least one 'select column', or it adds them all
      ->addAsColumn('dte', 'FLOOR(UNIX_TIMESTAMP('.$columnConstant.')/'.$interval.')')
      ->addAsColumn('cnt', 'COUNT('.constant($class.'::ID').')')
      ->addGroupByColumn('dte')
      ->addAscendingOrderByColumn($columnConstant);
    $rs = call_user_func(array($class, 'doSelectRS'), $c);
    $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);
    $stats = array();
    while($rs->next())
    {
      $stats[$rs->getInt('dte') * $interval] = $rs->getInt('cnt');
    }
    $statsWithZeros = array();
    for ($i=$begin; $i <= $end; $i += $interval)
    {
      $index = floor($i/$interval) * $interval;
      $statsWithZeros[$index] = isset($stats[$index]) ? $stats[$index] : 0;
    }
    return $statsWithZeros;
  }
  
  public static function getAllValuesCallable($begin, $end, $increment, $callable)
  {
    return call_user_func($callable, $begin, $end, $increment);
  }
  
}