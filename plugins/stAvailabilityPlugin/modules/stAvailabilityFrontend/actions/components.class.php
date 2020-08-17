<?php
/**
 * SOTESHOP/stAvailabilityPlugin
 *
 * Ten plik należy do aplikacji stAvailabilityPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stAvailabilityPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 617 2009-04-09 13:02:31Z michal $
 */

/**
 * stAvailabilityFrontend components.
 *
 * @package stAvailabilityPlugin
 * @subpackage stAvailabilityFrontend
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

class stAvailabilityFrontendComponents extends sfComponents
{
    /**
     * Pokaż dostępność produktu
     */
    public function executeAvailability()
    {
        $this->smarty = new stSmarty('stAvailabilityFrontend');

        $this->availability = $this->product->getFrontendAvailability();

//        echo $this->product->getFrontendAvailability()->getStockFrom();
//
//        echo "<pre>";
//        print_r($this->product);
//        echo "</pre>";

        if (null === $this->availability)
        {
            return sfView::NONE;
        }

        if (!isset($this->check_xml)) {
            $this->check_xml = false;
        }
    }

    public function executeShowLink()
   {
      $this->smarty = new stSmarty('smDepositoryAlertFrontend');
      if (!isset($this->product))
      {
         $this->product = ProductPeer::retrieveByPK($this->getRequestParameter('product_id', $this->getRequestParameter('id')));
      }

      if (count($this->option))
      {
         $this->option_name = $this->option[0]->getValue();
      }



      $availability = $this->product->getFrontendAvailability();

      $config = stConfig::getInstance(null, 'stQuestionBackend');

      $availability_id = $availability ? $availability->getId() : null;

      $product_config = stConfig::getInstance(null, 'stProduct');

      if ($config->get('show_ask_for_depository'))
      {
         $this->smarty->assign('show_ask_depository', $config->get('show_with_options') == true && $this->product->getHasOptions() != 0 || $availability_id == $config->get('depository_value'));
      }

   }
}
