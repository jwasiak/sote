<?php

/**
 * SOTESHOP/stPropelSeoUrlBehaviorPlugin
 *
 * Ten plik należy do aplikacji stPropelSeoUrlBehaviorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPropelSeoUrlBehaviorPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPropelSeoUrlBehavior.class.php 13231 2011-05-31 09:07:01Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Zachowanie propela dodajace obsluge przyjaznych linkow na poziomie modelu bazy danych
 *
 * @package     stPropelSeoUrlBehaviorPlugin
 * @subpackage  libs
 */
class stPropelSeoUrlBehavior
{

   protected static $methods = array();
   protected static $columns = array();
   protected static $autoGenerateUrl = false;
   protected $isNew = false;

   /**
    *
    * Zwraca wartość zgodna z url i seo
    *
    * @param BaseObject $object
    * @return string
    */
   public function getFriendlyUrl(BaseObject $object)
   {
      $object_class = get_class($object);

      $method = self::getMethodName($object_class, 'target_column', 'get');

      return $object->$method();
   }

   /**
    *
    * Ustala konfiguracje dla stPropelSeoUrlBehavior
    *
    * @param $params Parametry konfiguracyjne
    */
   public static function configuration($params = array())
   {
      if (isset($params['auto_generate_url']))
      {
         self::$autoGenerateUrl = $params['auto_generate_url'];
      }
   }

   public function preSave(BaseObject $object, $con = null)
   {
      $this->isNew = $object->isNew();

      if (!self::$autoGenerateUrl && !$this->isNew && $object->current_i18n) 
      {        
         $object_class = get_class($object);

         $col = $this->getColumnName($object_class, 'target_column');

         $filter = self::getMethodName($object_class, 'target_column_filter');

         $t_getter = self::getMethodName($object_class, 'target_column', 'get');
         $t_setter = self::getMethodName($object_class, 'target_column', 'set');

         $s_getter = self::getMethodName($object_class, 'source_column', 'get');

         $backup = $object->getCulture();

         foreach ($object->current_i18n as $culture => $i18n) 
         {
            if ($i18n->isNew() && !$i18n->isColumnModified($col))
            {
               $value = $i18n->$s_getter();
            }
            elseif (!$i18n->isColumnModified($col)) 
            {
               continue;
            }
            else
            {
               $value = $i18n->$t_getter();
            }

            $object->setCulture($culture);

            $seo = self::makeSeoFriendly($value);

            $filtered = $object->$filter($seo);
            
            $object->$t_setter($filtered ? $filtered : $seo);
         }

         $object->setCulture($backup);
      }
   }

   /**
    *
    * Zamienia wartość kolumny na odpowiednik zgodny ze specyfikacja url i seo
    *
    * @param BaseObject $object Obiekt do ktorego przypisane jest zachowanie
    * @param CreoleConnection $con Połączenie z bazą danych
    */
   public function postSave(BaseObject $object, $con = null)
   {   
      if ($object->current_i18n)
      {     
         if (self::$autoGenerateUrl || $this->isNew)
         {
            $object_class = get_class($object);
               
            $col = $this->getColumnName($object_class, 'target_column');

            $filter = self::getMethodName($object_class, 'target_column_filter');

            $t_getter = self::getMethodName($object_class, 'source_column', 'get');
            $t_setter = self::getMethodName($object_class, 'target_column', 'set');

            $backup = $object->getCulture();

            foreach ($object->current_i18n as $culture => $i18n) 
            {
               $object->setCulture($culture);

               $seo = self::makeSeoFriendly($object->$t_getter());

               $filtered = $object->$filter($seo);  

               if ($filtered)
               {
                  $seo = $filtered;
               }             

               if (strlen($seo) <= 2)
               {
                  $seo = $seo.'-'.$object->getPrimaryKey();
               }
            
               $object->$t_setter($filtered ? $filtered : $seo);
            
               if (stLanguage::getOptLanguage() == $culture && $object->isModified())
               {
                  call_user_func(array($object_class.'Peer', 'doUpdate'), $object);
               }       

               if ($i18n->isColumnModified($col))
               {
                  call_user_func(array($object_class.'I18nPeer', 'doUpdate'), $i18n);
                  $i18n->resetModified();
               }  
            }

            $object->setCulture($backup);
            $object->resetModified();
         }
      }
   }

   /**
    *
    * Zwraca nazwę metody
    *
    * @param string $object_class Klasa modelu dla którego będzie generowana metoda
    * @param string $method_type Typ metody
    * @param string $type Określa czy dana metoda ma być zwrócona w formacie "getter" lub "setter" (wartości: "get" lub "set")
    * @return string nazwa metody
    */
   protected static function getMethodName($object_class, $method_type, $type = null)
   {
      $conf_directive = 'propel_behavior_stPropelSeoUrlBehavior_'.$object_class.'_'.$method_type;

      if (!isset(self::$methods[$conf_directive . '_' . $type]))
      {
         $col = sfConfig::get($conf_directive);

         if (!$col)
         {
            throw new stPropelSeoUrlBehaviorException(sprintf('Musisz podać wartość dla parametru "%s" dla modelu "%s"', $method_type, $object_class));
         }

         try
         {
            self::$methods[$conf_directive . '_' . $type] = $type . call_user_func($object_class . 'Peer::translateFieldName', $col, BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
         } catch (PropelException $e)
         {
            self::$methods[$conf_directive . '_' . $type] = $type . $col;
         }
      }

      return self::$methods[$conf_directive . '_' . $type];
   }

   protected static function getColumnName($object_class, $method_type)
   {
      $conf_directive = 'propel_behavior_stPropelSeoUrlBehavior_'.$object_class.'_'.$method_type;

      if (!isset(self::$columns[$conf_directive]))
      {
         $col = sfConfig::get($conf_directive);

         if (!$col)
         {
            throw new stPropelSeoUrlBehaviorException(sprintf('Musisz podać wartość dla parametru "%s" dla modelu "%s"', $method_type, $object_class));
         }

         self::$columns[$conf_directive] = call_user_func($object_class . 'I18nPeer::translateFieldName', $col, BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
      }

      return self::$columns[$conf_directive];
   }



   /**
    *
    * Zamienia podany tekst na tekst zgodny z seo
    *
    * @param string $str Tekst do zamiany
    * @return string Tekst zgodny z seo
    */
   public static function makeSeoFriendly($str)
   {
      mb_internal_encoding('UTF-8');

      mb_regex_encoding("UTF-8");

      $str = stTextAnalyzer::unaccent($str);

      $str = preg_replace('/[^A-Za-z0-9]+/', '-', $str);

      $str = trim($str, '-');

      return strtolower($str);
   }

}

class stPropelSeoUrlBehaviorException extends sfException
{
   
}