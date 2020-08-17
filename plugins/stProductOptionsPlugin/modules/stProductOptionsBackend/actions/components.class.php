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
 * @version     $Id: components.class.php 3526 2010-02-16 10:31:45Z piotr $
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

/** 
 * Komponenty dla modułu stProductOptionsBackend
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stProductOptionsPlugin
 * @subpackage  actions
 */
class stProductOptionsBackendComponents extends autoStProductOptionsBackendComponents
{
    public function executeProductStockEdit()
    {
        $this->old_stock = $this->product->getStock();
        if (is_null($this->old_stock)) $this->old_stock = "''"; //hack for javascript

        $this->options_stock = ProductOptionsValuePeer::getProductOptionsStock($this->product);
        
    }
        
    public function executeShowOption()
    {
        if($product_option_id = $this->getRequestParameter('product_option_id'))
        {
            $model = $this->getRequestParameter('model');
            $this->product_option = call_user_func($model.'Peer::retrieveByPK',$product_option_id);
            $this->product_option->setCulture($this->culture);
            if($model=='ProductOptionsValue')
            {
                $this->product = $this->product_option->getProduct();
                $photos = ProductHasSfAssetPeer::doSelectImages($this->product->getId());
                $this->photos = array_reverse($photos);
            }
        }
    }
    
    public function executeShowRoot()
    {
        if($product_option_id = $this->getRequestParameter('product_option_id'))
        {
            $model = $this->getRequestParameter('model');
            $this->product_option = call_user_func($model.'Peer::retrieveByPK',$product_option_id);
            $this->product_option->setCulture($this->culture);
            
            $config = stConfig::getInstance(sfContext::getInstance(), array('price_type' => stConfig::STRING), 'stProduct');
        	$config->load();
        	$this->price_type = $config->get('price_type');
            
        }
    }

    public function executeOptionPicker()
    {
        if (!isset($this->product) || !get_class($this->product) == 'Product') 
        {
            throw new Exception("You must pass Product instance");
        }

        if ($this->product->getOptHasOptions() <= 1)
        {
            return sfView::NONE;
        }

        $this->options = ProductOptionsValuePeer::doSelectByProduct($this->product, false);

        if (!$this->options)
        {
            return sfView::NONE;
        }

        if (!isset($this->selected)) 
        {
            $this->selected = array();
        }

        if (!isset($this->ajax))
        {
            $this->ajax = false;
        }
    }
    
    public function executeShowField()
    {
        if($field_id = $this->getRequestParameter('field_id'))
        {
            $this->field = ProductOptionsFieldPeer::retrieveByPk($field_id);
            $this->field->setCulture($this->culture);
            $this->model = $this->getRequestParameter('model');

            if ($this->model == 'ProductOptionsValue')
            {
                $options = $this->field->getValues();
            }
            else
            {
                $options = $this->field->getDefaultValues();
            }

            $default_options = array();

            $default_selected= null;

            foreach ($options as $option) 
            {
                $default_options[$option->getId()] = $option->getValue(); 

                if ($option->getId() == $this->field->getOptValueId() && $option->getOptValue() == $this->field->getDefaultValue() || $option->getOptValue() == $this->field->getDefaultValue())
                {
                    $default_selected = $option->getId();
                } 
            }

            unset($options);

            $this->default_options = $default_options;
            $this->default_selected = $default_selected;  
        }
    }
    
    public function executeUseOptionsTemplate()
    {
        $options[0] = sfContext::getInstance()->getI18n()->__('Bez szablonu');
        
        $this->templates_exists = 0;
        foreach(ProductOptionsTemplatePeer::doSelect(new Criteria()) as $product_options_template)
        {
            $options[$product_options_template->getId()] = $product_options_template->getName();
            $this->templates_exists++;
        }
        
        $c = new Criteria();
        $c->add(ProductOptionsValuePeer::PRODUCT_ID,$this->product->getId());
        $c->add(ProductOptionsValuePeer::DEPTH,0);
        
        $this->root = ProductOptionsValuePeer::doSelectOne($c);
        
        $this->options = $options;
    }
}