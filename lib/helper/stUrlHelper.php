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
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stUrlHelper.php 9599 2010-11-26 15:08:24Z marcin $
 */
use_helper('Tag', 'Url');

/**
 * Zwraca znacznik HTML linku
 *
 * @param                 string      nazwa               linku
 * @param   string      wewnętrzny         adres url lub nazwa routingu
 * @param   array       dodatkowe           parametry dla linku
 * @return  string      znacznik <a> zgodny z XHTML
 * @see url_for
 */
function st_link_to($name = '', $internal_uri = '', $options = array())
{
   $html_options = _parse_attributes($options);

   $html_options = _convert_options_to_javascript($html_options);

   $absolute = false;

   $for_app = null;

   $for_lang = null;

   $for_host = null;

   $no_script_name = null;

   $is_secure = null;

   if (isset($html_options['absolute_url']))
   {
      $html_options['absolute'] = $html_options['absolute_url'];
      unset($html_options['absolute_url']);
   }

   if (isset($html_options['absolute']))
   {
      $absolute = (boolean) $html_options['absolute'];
      unset($html_options['absolute']);
   }

   if (isset($html_options['for_app']))
   {
      $for_app = $html_options['for_app'];

      unset($html_options['for_app']);
   }

   if (isset($html_options['for_host']))
   {
      $for_host = $html_options['for_host'];

      unset($html_options['for_host']);
   }

   if (isset($html_options['for_lang']))
   {
      $for_lang = $html_options['for_lang'];

      unset($html_options['for_lang']);
   }

   if (isset($html_options['no_script_name']))
   {
      $no_script_name = $html_options['no_script_name'];

      unset($html_options['no_script_name']);
   }

   if (isset($html_options['is_secure']))
   {
      $is_secure = $html_options['is_secure'];

      unset($html_options['is_secure']);
   }

   $html_options['href'] = st_url_for($internal_uri, $absolute, $for_app, $for_host, $for_lang, $no_script_name, $is_secure);

   if ($html_options['href'] === false)
   {
      return '';
   }

   if (isset($html_options['query_string']))
   {
      $html_options['href'] .= '?' . $html_options['query_string'];
      unset($html_options['query_string']);
   }

   if (!$name)
   {
      $name = $html_options['href'];
   }
   elseif (is_object($name))
   {
      if (method_exists($name, '__toString'))
      {
         $name = $name->__toString();
      }
      else
      {
         throw new sfException(sprintf('Object of class "%s" cannot be converted to string (Please create a __toString() method)', get_class($name)));
      }
   }

   return content_tag('a', $name, $html_options);
}

function st_secure_link_to($name = '', $internal_uri = '', $options = array())
{
   static $is_secure = null;

   if (null === $is_secure)
   {
      $is_secure = stSecurity::hasSSL();
   }

   if ($is_secure)
   {
      $options = _parse_attributes($options);

      $options['is_secure'] = true;

      $options['absolute'] = true;
   }
   
   return st_link_to($name, $internal_uri, $options);
}

function st_secure_url_for($internal_uri = '', $for_app = null, $for_host = null, $for_lang = null, $no_script_name = null)
{
   static $is_secure = null;

   if (null === $is_secure)
   {
      $is_secure = stSecurity::hasSSL();
   }

   return st_url_for($internal_uri, $is_secure, $for_app, $for_host, $for_lang, $no_script_name, $is_secure);
}

/**
 * Zwraca url uwzględniając routing
 *
 * @param   string      wewnętrzny         adres url lub nazwa routingu
 * @param              bool        scieżka            pełna?
 * @param   string      nazwa               aplikacji dla której ma zostać wygenerowany adres url
 * @return  string      adres url
 */
function st_url_for($internal_uri = '', $absolute = false, $for_app = null, $for_host = null, $for_lang = null, $no_script_name = null, $is_secure = null)
{
   static $request = null;

   static $domain_for_language = array();

   if ($request == null)
   {
      $request = sfContext::getInstance()->getRequest();
   }

   if ($for_lang == null)
   {
      $for_lang = sfContext::getInstance()->getUser()->getCulture();
   }

   if ($for_lang == 'pl_PL')
   {
      $for_lang = 'pl';
   }

   if ($for_lang == 'en_US')
   {
      $for_lang = 'en';
   }

   if ($for_app == null)
   {
      $for_app = SF_APP;
   }

   if ($no_script_name !== null || SF_ENVIRONMENT == 'dev' || SF_ENVIRONMENT == 'theme')
   {
      $tmp = sfConfig::get('sf_no_script_name');

      sfConfig::set('sf_no_script_name', $no_script_name);

      $no_script_name = $tmp;
   }
   elseif ($for_app == 'frontend')
   {
      $no_script_name = sfConfig::get('sf_no_script_name');

      sfConfig::set('sf_no_script_name', true);
   }
   else
   {
      $no_script_name = sfConfig::get('sf_no_script_name');

      sfConfig::set('sf_no_script_name', false);     
   }

   if ($for_app == 'frontend')
   {
      if (!isset($domain_for_language[$for_lang]))
      {
         $domains = LanguageHasDomainPeer::doSelectByLanguageShortcut($for_lang);

         if (!empty($domains))
         {
            $default_domain = null;

            foreach ($domains as $domain)
            {
               if ($domain->getIsDefault())
               {
                  $default_domain = $domain;
               }
            }

            $domain_for_language[$for_lang] = $default_domain ? $default_domain->getDomain() : $domains[0]->getDomain();
         }
         else
         {
            $domain_for_language[$for_lang] = false;
         }
      }

      if ($for_host == null)
      {
         $for_host = $domain_for_language[$for_lang] ? $domain_for_language[$for_lang] : $request->getHost();
      }

      if (!$domain_for_language[$for_lang] || $domain_for_language[$for_lang] != $for_host)
      {
         if (is_string($internal_uri))
         {
            $url = $internal_uri;

            $query_string = '';

            if ($pos = strpos($url, '?'))
            {
               $query_string = substr($url, $pos + 1);

               $url = substr($url, 0, $pos);
            }

            if ($query_string)
            {
               $query_string = preg_replace('/lang=([^&])/si', $for_lang, $query_string, 1, $replaced);

               if ($replaced)
               {
                  $internal_uri = $url . '?' . $query_string;
               }
               else
               {
                  $internal_uri = $url . '?' . $query_string . '&lang=' . $for_lang;
               }
            }
            else
            {
               $internal_uri .= '?lang=' . $for_lang;
            }
         }
         else
         {
            $internal_uri['lang'] = $for_lang;
         }
      }
   }

   $request->setScriptNameByApp($for_app);

   if ($is_secure)
   {
      $request->setIsSecure($is_secure);

      $for_host = $request->getHost();
   }

   $prevCustomHost = $request->getCustomHost();
   
   try
   {
      $request->setCustomHost($for_host);

      $content = url_for($internal_uri, $absolute);
   }
   catch (Exception $e)
   {
      $content = false;
   }

   if ($no_script_name !== null)
   {
      sfConfig::set('sf_no_script_name', $no_script_name);
   }

   $request->setScriptNameByApp(null);

   $request->setCustomHost($prevCustomHost);

   if ($is_secure)
   {
      $request->setIsSecure(null);
   }

   return $content;
}