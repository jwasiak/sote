<?php
/** 
 * SOTESHOP/stProductOptionsPlugin 
 * 
 * Ten plik należy do aplikacji stProductOptionsPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProductOptionsPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 210 2009-09-01 13:21:28Z michal $
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */
 
/** 
 * Komponenty dla modułu stProductOptionsStockFrontendActions
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stProductOptionsPlugin
 * @subpackage  actions
 */
class stProductOptionsStockFrontendActions extends sfActions
{
    public function executeModifyBasketView()
    {        
        $this->product = ProductPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->product->setStock($this->getRequestParameter('stock'));
        
        $this->basket_config = stConfig::getInstance($this->getContext(), null, 'stBasket');
        
        $this->basket_config->load();
        
        $this->product_config = stConfig::getInstance($this->getContext(), null, 'stProduct');
        
        $this->product_config->load();
        
        $this->smarty = new stSmarty('stBasket');
  
        if (!isset($this->simple))
        {
          $this->simple = false;
        }
        
        $this->info = 1;
                
        $this->hide_attriburtes = 1;
          
        $this->enabled = 1;
                  
        $this->show_basket = 2;
          
        $config = stConfig::getInstance(sfContext::getInstance(), array('depository_basket' => stConfig::BOOL), 'stProduct');
        $config->load();
        if($config->get('depository_basket')==1)
        {        
            $this->enabled = ($this->getRequestParameter('stock') == 0) ? 0 : 1;
        }
    }
}