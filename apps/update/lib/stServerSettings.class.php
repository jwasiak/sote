<?php
/** 
 * SOTESHOP/stUpdate 
 * 
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE. 
 * Do not modify this file, system will overwrite it during upgrade.
 * 
 * @package     stUpdate
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: stServerSettings.class.php 3160 2010-01-26 13:30:27Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
 
/** 
 * System settings verification.
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stServerSettings 
{
         
      /** 
       * Check if php include path contain path to PEAR,
       *
       * @param        string      $file
       * @return   bool
       */
      public function isPEAR($file='PEAR.php')
      {
          $include_path=ini_get('include_path');
          $paths=split(':',$include_path);
          foreach ($apths as $path)
          {
              $pearFile=$path.DIRECTORY_SEPARATOR.$file;
              if (file_exists($pearFile)) return true;
              else return false;
          }
          
      }
    
}