<?php

/**
 * SOTESHOP/stSecurityPlugin
 *
 * Ten plik należy do aplikacji stSecurityPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stSecurityPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 1711 2009-06-18 09:03:30Z bartek $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 */

/**
 * stSecurityBackendActions actions.
 *
 * @package     stSecurityPlugin
 * @subpackage  actions
 */
class stSecurityBackendActions extends stActions
{

   /**
    * Wyświetla konfigurację modułu mapa strony
    */
   public function executeIndex()
   {
      $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->config->setFromRequest('security', array('ssl_ignore_hosts', 'ssl_ignore_uri'));
         
         $this->config->save();

         $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
         
         stFastCacheManager::clearCache();

         return $this->redirect('stSecurityBackend/index');
      }
   }

   public function validateIndex()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
         
         $security = $this->getRequestParameter('security');

         if (isset($security['ssl']) && !$this->checkSSLSupport())
         {
            $this->getRequest()->setError('security{ssl}', 'Serwer nie obsługuje protokołu SSL');

            return false;
         }
      }

      return true;
   }

   public function handleErrorIndex()
   {
      $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->config->setFromRequest('security');
      }

      return sfView::SUCCESS;
   }

   /**
    * Włącznie captcha dla testów
    */
   public function executeTurnOnCaptcha()
   {
      $config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
      $config->set('captcha_on', true);
      $config->save();

      $this->redirect('@homepage');
   }

   /**
    * Wyłącznie captcha dla testów
    */
   public function executeTurnOffCaptcha()
   {
      $config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
      $config->set('captcha_on', false);
      $config->save();

      $this->redirect('@homepage');
   }

   protected function checkSSLSupport()
   {
      return true;
    /*
        $ch = curl_init();

        sfLoader::loadHelpers(array('Helper', 'stUrl'));

        $url = st_url_for('stBasket/index', true, 'frontend', null, null, null, true);

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_VERBOSE, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_POST, false);

        $response = curl_exec($ch);

        $supported = $response && !curl_errno($ch) && curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200;

        curl_close($ch);

        return $supported;
        */
   }

}