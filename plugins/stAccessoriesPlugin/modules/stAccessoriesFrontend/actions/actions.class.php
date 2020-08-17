<?php
/** 
 * SOTESHOP/stAccessoriesPlugin 
 * 
 * Ten plik należy do aplikacji stAccessoriesPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAccessoriesPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 3369 2010-02-09 08:41:06Z pawel $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Akcje modułu akcesoria
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>  
 *
 * @package     stAccessoriesPlugin
 * @subpackage  actions
 */
class stAccessoriesFrontendActions extends stActions
{
   /** 
    * Pokazuje akcesoria dla danego produktu
    */
   public function executeAccessoriesList()
  {
    if(!$this->getRequest()->isXmlHttpRequest() && $this->getController()->getRenderMode() != sfView::RENDER_VAR){  

        $this->getResponse()->setStatusCode(404);

        $this->getResponse()->setHttpHeader('Status', '404 Not Found');

        return $this->forward('stErrorFrontend', 'error404');
     }

     $this->smarty = new stSmarty($this->getModuleName());
     $this->config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');
     $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
     $this->config_points->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
     $this->setLayout(false);
     $product_id = $this->getRequestParameter('id');
     $c = new Criteria();
     $c->addJoin(ProductHasAccessoriesPeer::ACCESSORIES_ID, ProductPeer::ID);
     $c->add(ProductHasAccessoriesPeer::PRODUCT_ID, $product_id);
     $c->addAscendingOrderByColumn(ProductHasAccessoriesPeer::ID);
     ProductPeer::addFilterCriteria($this->getContext(), $c, false);
     $this->products = ProductPeer::doSelectForPager($c);
  }
}
