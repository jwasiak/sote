<?php

/**
 * SOTESHOP/stQuestionPlugin
 *
 * Ten plik należy do aplikacji stQuestionPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stQuestionPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 13440 2011-06-03 13:33:30Z bartek $
 */

/**
 * Komponenty dla modułu stQuestionFrontend
 *
 * @author Paweł Byszewski <pawel.byszewski@sote.pl>
 *
 * @package     stQuestionPlugin
 * @subpackage  actions
 */
class stQuestionFrontendComponents extends sfComponents
{

   public function executeAsk()
   {
      $ret = $this->executeShowQuestion();

      $this->smarty->assign('show_ask_depository', $this->smarty->get_template_vars('show_ask_depository') ? true : null);

      $this->smarty->assign('ask_price_login', $this->smarty->get_template_vars('ask_price_login') ? true : null);

      $this->smarty->assign('ask_depository_login', $this->smarty->get_template_vars('ask_depository_login') ? true : null);

      $this->smarty->assign('show_ask_price', $this->smarty->get_template_vars('show_ask_price') ? true : null);
   }

   public function executeShowQuestion()
   {
      if (!isset($this->is_ajax))
      {
         $this->is_ajax = false;
      }

      $this->smarty = new stSmarty('stQuestionFrontend');

      if (!isset($this->product))
      {
         $this->product = ProductPeer::retrieveByPK($this->getRequestParameter('product_id', $this->getRequestParameter('id')));
      }

      $availability = $this->product->getFrontendAvailability();

      $availability_id = $availability ? $availability->getId() : null;

      $config = stConfig::getInstance(null, 'stQuestionBackend');

      $product_config = stConfig::getInstance(null, 'stProduct');

      $this->smarty->assign('ask_price_login', !$config->get('ask_price_user_login') || $config->get('ask_price_user_login') && $this->getUser()->isAuthenticated());

      $this->smarty->assign('ask_depository_login', !$config->get('ask_depository_user_login') || $config->get('ask_depository_user_login') && $this->getUser()->isAuthenticated());

      $this->smarty->assign('show_ask_price', $config->get('show_ask_for_price') && (!$this->product->isPriceVisible() || !$product_config->get('show_price')));

      if ($config->get('show_ask_for_depository'))
      {
         $this->smarty->assign('show_ask_depository', $config->get('show_with_options') == true && $this->product->getHasOptions() > 1 || $availability_id == $config->get('depository_value'));
      }
   }

}
