<?php

/**
 * sfNifty Class File
 *
 * This file is part of the sfNifty package.
 * (c) 2006-2007 Alban Creton <acreton@gmail.com>
 * (c) 2006-2007 Jonathan H. Wage
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * File containing class for the sfNifty plugin.
 * 
 * @category    Plugins
 * @package     sfNifty
 * @author      Alban Creton <acreton@gmail.com>
 * @copyright   2006-2007 Jonathan H. Wage
 * @license     See LICENSE that came packaged with this software
 * @version     1.2.0
 */


/**
 * sfNifty Class
 * 
 * Class the sfNifty plugin 
 * 
 * @category    Plugins
 * @package     sfNifty
 * @author      Alban Creton <acreton@gmail.com>
 * @license     See LICENSE that came packaged with this software
 * @version     1.2.0
 */
class sfNifty
{
  /**
   * Elements
   * 
   * @var     array
   * @access  private
   */
  private static $elements = array();
  
  /**
   * Add an element in rounded list.
   *
   * @param   string  $id   $id of the html element
   * @return  bool    $bool
   */ 
  public static function addId($id)
  {
    if(isset(self::$elements[$id]))
    {
      return false;
    }
    else
    {
      self::$elements[$id] = true;
      return true;
    }
  } 
}
