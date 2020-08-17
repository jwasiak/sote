<?php
/**
 * SOTESHOP/stPriceCompare
 *
 * Ten plik należy do aplikacji stPriceCompare opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPriceCompare
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPriceCompareComponents
 *
 * @package     stPriceCompare
 * @subpackage  actions
 */
class stPriceCompareComponents extends sfComponents
{
    /**
     * Dodawanie produktu do porównywarek w stProduct
     */
    public function executePriceComparesInProduct()
    {
        $priceCompares = stPriceCompare::getPriceCompares();

        $this->plugin = array();
        $this->pluginName = array();

        if ($this->hasRequestParameter('product_id'))
        {
            $this->product_id = $this->getRequestParameter('product_id');

            $this->product = ProductPeer::retrieveByPK($this->product_id);

            if ($this->getRequest()->getMethod() == sfRequest::POST)
            {
                foreach ($priceCompares as $pluginName => $pluginOptions)
                {
                    if (class_exists($pluginOptions['peerName'])) {

                        $c = new Criteria();
                        $c->add(constant($pluginOptions['peerName']."::PRODUCT_ID"), $this->product_id);
                        $this->obj = call_user_func($pluginOptions['peerName']."::doSelectOne",$c);

                        if ($this->getRequestParameter('priceCompare['.$pluginOptions['name'].']'))
                        {
                            if (!is_object($this->obj))
                            {
                                $class = str_replace('Peer', '', $pluginOptions['peerName']);
                                $this->obj = new $class;
                                $this->obj->setProductId($this->product_id);
                            }

                            $this->obj->setActive($this->getRequestParameter('priceCompare['.$pluginOptions['name'].']'));
                            $this->obj->save();
                        } else {
                            if (is_object($this->obj)) {
                                $this->obj->delete();
                            }
                        }
                        $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
                    }
                }
            }

            foreach ($priceCompares as $pluginName => $pluginOptions)
            {
                /**
                 *  warunek aby dodac konfiguracje wszykich pluginow poza nie posiadających tabeli w bazie.
                 *
                 * @package     stPriceCompare
                 * @subpackage  actions
                 */
                if (class_exists($pluginOptions['peerName'])) {
                    $c = new Criteria();
                    $c->add(constant($pluginOptions['peerName']."::PRODUCT_ID"), $this->product_id);
                    $this->plugin[$pluginOptions['name']] = call_user_func($pluginOptions['peerName']."::doSelectOne",$c);
                    $this->pluginName[$pluginOptions['name']] = $pluginName;

                    //                    $module = str_replace('Plugin','Backend',$pluginName);
                    //
                    //                    $x = sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_app_module_dir_name').'/'.$module.'/'.sfConfig::get('sf_app_module_config_dir_name').'/generator.yml', true);
                    //                    if (!empty($x))
                    //                    {
                    //                        require($x);
                    //                    }
                    //
                    //                    if ($this->getController()->componentExists($module, 'showInProduct'))
                    //                    {
                    //                        $this->plugin[$pluginOptions['name']] = array('moduleName' => $module, 'peer' => $this->plugin[$pluginOptions['name']]);
                    //                    }
                }
            }
        }
    }
}