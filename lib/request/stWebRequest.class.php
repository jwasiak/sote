<?php

/**
 * SOTESHOP/stBase
 *
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBase
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stWebRequest.class.php 9385 2010-11-23 11:58:50Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Przeciążenie sfWebRequest - dodanie możliwości nadpisania scriptName (niweluje ograniczenie generowania linków do różnych aplikacji)
 *
 * @package     stBase
 * @subpackage  libs
 */
class stWebRequest extends sfWebRequest
{
   protected
      $scriptName = null,
      $customHost = null,
      $isSecure = false;

   public function initialize($context, $parameters = array(), $attributes = array())
   {
      stEventDispatcher::getInstance()->notify(new sfEvent($this, 'request.beforeInitialize'));

      parent::initialize($context, $parameters, $attributes);
   }

   /**
    * Ustawia nazwę skryptu na podstawie nazwy aplikacji
    *
    * @param   string      $app_name           Nazwa aplikacji
    */
   public function setScriptNameByApp($app_name = null)
   {
      if (is_null($app_name))
      {
         return $this->scriptName = null;
      }

      if ($app_name == 'frontend' && SF_ENVIRONMENT == 'prod')
      {
         $app_name = 'index';
      }

      $this->scriptName = '/'.$app_name.(SF_ENVIRONMENT != 'prod' ? '_'.SF_ENVIRONMENT : '').'.php';
   }
   
   public function setIsSecure($v)
   {
      $this->isSecure = $v;
   }

   public function isSecure()
   {
      if ($this->isSecure)
      {
         return true;
      }
      
      return parent::isSecure();
   }

   /**
    *
    * Ustawia własną nazwę hosta
    *
    * @param string $host Nazwa hosta (jezeli ustawiona na null nazwa hosta brana jest z informacji w PHP)
    */
   public function setCustomHost($host = null)
   {
      $this->customHost = $host;
   }

   /**
    * Pobiera własną nazwę hosta
    *
    * @return string
    */
   public function getCustomHost()
   {
      return $this->customHost;
   }

   /**
    * Ustawia nazwę hosta dla danej wersji językowej
    *
    * @param string $culture Wersja językowa
    * @return void
    */
   public function setHostByCulture($culture)
   {
      $prevCulture = $this->context->getUser()->getCulture();

      if ($culture == 'pl')
      {
         $culture = 'pl_PL';
      }
      elseif ($culture == 'en')
      {
         $culture = 'en_US';
      }

      $this->context->getUser()->setCulture($culture);

      $language = stLanguage::getInstance($this->context);

         if ($language->hasDomain())
         {
         /**
          * @var stWebRequest $request
          */
         $request = $this->context->getRequest();
         $request->setIsSecure(stSecurity::getSSL() == 'shop');
         
            $request->setCustomHost($language->getDomain());
      }
      
      $this->context->getUser()->setCulture($prevCulture);       
   }

   /**
    *
    * @see sfWebRequest
    */
   public function getScriptName()
   {
      return $this->scriptName ? $this->scriptName : parent::getScriptName();
   }

   /**
    * Pobieranie adresu klienta
    *
    * @author Michal Prochowski <michal.prochowski@sote.pl>
    * @return  string      Numer ip klienta.
    */
   public function getRemoteAddress()
   {
      $pathArray = $this->getPathInfoArray();
      return $pathArray['REMOTE_ADDR'];
   }

   /**
    * Pobieranie HTTP_USER_AGENT
    * 
    * @author Michal Prochowski <michal.prochowski@sote.pl>
    * @return string
    */
   public function getHttpUserAgent()
   {
      $pathArray = $this->getPathInfoArray();
      return $pathArray['HTTP_USER_AGENT'];
   }

   public function getHost()
   {
      $host = $this->customHost ? $this->customHost : parent::getHost();

      if (function_exists('idn_to_utf8')) 
      {
        $utf8host = idn_to_utf8($host);

        if ($utf8host) 
        {
          $host = $utf8host;
        } 
      }

      return $host;
   }

   public function addHost($content)
   {
      $www = stSecurity::getSSL() == 'shop' ? 'https://'.$this->getHost().'/' : 'http://'.$this->getHost().'/';

      return str_replace(array('href="/', 'src="/', 'url(/', 'url(\'/'), array('href="'.$www, 'src="'.$www, 'url('.$www, 'url(\''.$www), $content);  
   }

   public function getServerAddress()
   {
      $pathArray = $this->getPathInfoArray();
      return $pathArray['SERVER_ADDR'];
   }

}