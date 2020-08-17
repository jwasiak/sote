<?php
/**
 * Changelog Description  class 
 *
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * Changelog Description
 */
class stChangelogDescription extends stChangelogBase
{       
       /**
        * Instance
        */
       protected static $instance = null;

      /**
       * Singleton
       *
       * @param stBackendDesktop $base_class
       * @return stBackendDesktop
       */
       public static function getInstance($base_class = null)
       {
           if (null === self::$instance)
           {
               if (null === $base_class)
               {
                   $base_class = __CLASS__;
               }

               self::$instance = new $base_class();
           }

           return self::$instance;
       }
         
       /**
        * Condition
        * 
        * @param string $app   Application
        * @param mixed $params Parameters 
        * @return array('return'=>bool,'result'=>mixed)
        */
       public function condition($app,$params)
       {
          return array('return'=>true, 'result'=>array(true));
       }
             
         /**
          * Additional description for 1 update for 1 app
          * @param mixe $params result from stChangelogDescription::execute['result']
          * @return string HTML
          */
         public function runkeyname($app,$params,$keyname_params)
         {             

         }
         
         /**
          * Additional description for all updates for 1 app
          * @param mixed $params result from stChangelogDescription::execute['result']
          * @return array Unique files for app
          */
         public function runapp($app,$params)
         {
             return NULL;
         }                 
}