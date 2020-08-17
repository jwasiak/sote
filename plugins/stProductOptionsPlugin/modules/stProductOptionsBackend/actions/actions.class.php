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
 * @version     $Id: actions.class.php 16889 2012-01-27 11:23:35Z piotr $
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

/**
 * Akcje modułu stProductOptionsBackend
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stProductOptionsPlugin
 * @subpackage  actions
 */
class stProductOptionsBackendActions extends autoStProductOptionsBackendActions
{
    /**
     * Funkcja kopiująca atrybuty i wartości z szablonu do produktu.
     */
    public function executeUseTemplate()
    {
        $template_id = $this->getRequestParameter('template');
        $option_id = $this->getRequestParameter('optionId');
         
        $root = ProductOptionsValuePeer::retrieveByPk($option_id);

        if(!$root)
        {
            return sfView::NONE;
        }

        $c = new Criteria();
        $c->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $template_id);
        $c->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, null, Criteria::ISNULL);
         
        if($root_template = ProductOptionsDefaultValuePeer::doSelectOne($c))
        {
            $count = $this->copyDescendands($root_template, $root);
            if ($count > 1)
            {
                $product = $root->getProduct();
                $product->setOptHasOptions($product->getOptHasOptions() + $count - 1);
                $product->setStock(ProductOptionsValuePeer::updateStock($product, false));
                ProductPeer::doUpdate($product);
            }

            stFastCacheManager::clearCache();
        }
    
        
        return sfView::HEADER_ONLY;
    }
     
    /**
     *
     * @param     $source
     * @param     $dest
     */
    private function copyDescendands($source, $dest)
    {
        $product = $dest->getProduct();

        $default_culture = stLanguage::getOptLanguage();

        $c = new Criteria();

        $c->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $source->getProductOptionsTemplateId());     
        $c->addAscendingOrderByColumn(ProductOptionsDefaultValuePeer::LFT);

        $count = ProductOptionsDefaultValuePeer::doCount($c); 

        if ($count > 1) 
        {
            $fields = array();

            $filters = array();

            $depth = $dest->getDepth();

            $tree_offset = $dest->getLft() - $source->getLft();

            $parents = array($dest->getDepth() => $dest->getId());

            $tree_size = $source->getRgt() - $source->getLft() - 1;

            $sqls = sfPropelActAsNestedSetBehavior::shiftRLValues('ProductOptionsValuePeer', $dest->getLft() + 1, $tree_size, $dest->getProductId());

            foreach ($sqls as $sql)
            {
                Propel::getConnection()->executeQuery($sql);
            }

            $current_field_id = null;

            for ($offset = 0; $offset < $count; $offset += stProductOptionsPluginListener::DUPLICATE_LIMIT)
            {
                $c->setOffset($offset);

                $c->setLimit(stProductOptionsPluginListener::DUPLICATE_LIMIT);

                $options = ProductOptionsDefaultValuePeer::doSelect($c);

                foreach ($options as $option)
                {
                    if ($option->getDepth() == 0) 
                    {
                        continue;
                    }

                    $depth_index = $depth + $option->getDepth();

                    $field_id = $option->getProductOptionsFieldId();

                    $duplicated_option = new ProductOptionsValue();

                    $option->copyInto($duplicated_option);

                    $duplicated_option->setStock(0);

                    $duplicated_option->setDepth($depth_index);

                    $duplicated_option->setLft($duplicated_option->getLft() + $tree_offset);

                    $duplicated_option->setRgt($duplicated_option->getRgt() + $tree_offset);

                    if ($duplicated_option->getDepth() > 0)
                    {
                        $duplicated_option->setProductOptionsValueId($parents[$duplicated_option->getDepth() - 1]);
                    }

                    $duplicated_option->setProductId($dest->getProductId());

                    $duplicated_option->setProductOptionsTemplateId(0);

                    if ($field_id)
                    {
                        if (!isset($fields[$field_id])) 
                        {
                            $field = $option->getProductOptionsField();

                            $duplicated_field = new ProductOptionsField();

                            $field->copyInto($duplicated_field);

                            $duplicated_field->setProductOptionsTemplateId(0);

                            $duplicated_field->setId(ProductOptionsFieldPeer::doInsert($duplicated_field));

                            foreach ($field->getProductOptionsFieldI18ns() as $i18n)
                            {
                                if ($i18n->getCulture() && $i18n->getCulture() != $default_culture)
                                {
                                    $duplicated_i18n = new ProductOptionsFieldI18n();

                                    $i18n->copyInto($duplicated_i18n);

                                    $duplicated_i18n->setCulture($i18n->getCulture());

                                    $duplicated_i18n->setId($duplicated_field->getId());

                                    ProductOptionsFieldI18nPeer::doInsert($duplicated_i18n);
                                }
                            }

                            $field->clearI18ns();

                            $fields[$field_id] = $duplicated_field->getId();

                            $filters[$field_id] = $duplicated_field->getProductOptionsFilterId();
                        }

                        $duplicated_option->setProductOptionsFieldId($fields[$field_id]);
                        $duplicated_option->setOptFilterId($filters[$field_id]);
                    }

                    $duplicated_option->setId(ProductOptionsValuePeer::doInsert($duplicated_option));

                    if ($option->getUseImageAsColor())
                    {
                        if (!is_dir($duplicated_option->getColorImageDir(true)))
                        {
                            mkdir($duplicated_option->getColorImageDir(true), 0755, true);
                        }

                        copy($option->getColorImagePath(true), $duplicated_option->getColorImagePath(true));
                    }

                    foreach ($option->getProductOptionsDefaultValueI18ns() as $i18n)
                    {
                        if ($i18n->getCulture() && $i18n->getCulture() != $default_culture)
                        {
                            $duplicated_i18n = new ProductOptionsValueI18n();

                            $i18n->copyInto($duplicated_i18n);

                            $duplicated_i18n->setCulture($i18n->getCulture());

                            $duplicated_i18n->setId($duplicated_option->getId());

                            ProductOptionsValueI18nPeer::doInsert($duplicated_i18n);
                        }
                    }   

                    $option->clearI18ns();              

                    if ($duplicated_option->hasChildren())
                    {
                        $parents[$duplicated_option->getDepth()] = $duplicated_option->getId();
                    }                   
                }

                unset($options);
            }
        }

        return $count;
    }
     
    /**
     * Funkcja zwracająca component _showOption po przekazaniu do niego parametrów.
     */
    public function executeShowOption()
    {
        $this->product_id = $this->getRequestParameter('product_id');
        $this->model = $this->getRequestParameter('model');
        $this->culture = $this->getRequestParameter('language','pl_PL');

        $config = stConfig::getInstance(sfContext::getInstance(), array('price_type' => stConfig::STRING), 'stProduct');
        $config->load();
        $this->price_type = $config->get('price_type');
    }

    /**
     * Funkcja wyświetlająca formularz dla root'a
     *
     * @return sfView
     **/
    public  function executeShowRoot()
    {
        $this->product_id = $this->getRequestParameter('product_id');
        $this->model = $this->getRequestParameter('model');
        $this->culture = $this->getRequestParameter('language','pl_PL');

        $config = stConfig::getInstance(sfContext::getInstance(), array('price_type' => stConfig::STRING), 'stProduct');
        $config->load();
        $this->price_type = $config->get('price_type');

    }

    /**
     * Funkcja zwracająca component _showField po przekazaniu do niego parametrów.
     */
    public function executeShowField()
    {
        $this->field_id = $this->getRequestParameter('field_id');
        $this->culture = $this->getRequestParameter('language','pl_PL');
    }

    /**
     * Akcja która usuwa wszystkie atrybuty i wartości dla danego produktu.
     */
    public function executeDelete()
    {
        self::delete($this->getRequestParameter('product_id'));
        $this->redirect('stProductOptionsTemplateBackend/addTemplateToProductList');
    }

    /**
     * Funkcja usuwająca wszystkie wartości.
     */
    public static function delete($product_id)
    {
        $c = new Criteria();
        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product_id);
        $product_options = ProductOptionsValuePeer::doSelect($c);
        foreach($product_options as $product_option)
        {
            $product_option->delete();
        }
    }

    public function deleteRecurrence($model, $option_id) {
        $option = call_user_func($model.'Peer::retrieveByPk', $option_id);

        $c2 = new Criteria();
        $c2->add(constant($model.'Peer::PRODUCT_ID'),$option->getProductId());
        $c2->add(constant($model.'Peer::LFT'),$option->getLft(),Criteria::GREATER_THAN);
        $c2->add(constant($model.'Peer::RGT'),$option->getRgt(),Criteria::LESS_THAN);
        $c2->addAscendingOrderByColumn(constant($model.'Peer::RGT'));
        $options = call_user_func($model.'Peer::doSelect', $c2);

        $fields_to_delete = array();
        foreach($options as $item) {
            $fields_to_delete[$item->getProductOptionsFieldId()] = $item->getProductOptionsFieldId();
            //$item->delete();
        }

        $c3 = new Criteria();
        $c3->add(ProductOptionsFieldPeer::ID, $fields_to_delete, Criteria::IN);
        ProductOptionsFieldPeer::doDelete($c3);

        call_user_func($model.'Peer::doDelete', $c2);
        $option->delete();
    }

    public function executeFixOptions() {

    }

    public function executeFixStock()
    {
        
    }

    public function executeAjaxOptionChangeUpdate()
    {
        $namespace = $this->getRequestParameter('namespace');

        $selected = $this->getRequestParameter($namespace);

        $changed = $this->getRequestParameter('changed');

        $product_id = $this->getRequestParameter('product_id');

        $ids = array();

        foreach ($selected as $field_id => $option_id)
        {
            $ids[$field_id] = $option_id;

            if ($field_id == $changed)
            {
                break;
            }
        }

        $index = 0;

        $selected_values = array();

        foreach ($selected as $id)
        {
            $option = ProductOptionsValuePeer::retrieveByPK($id);
            
            if ($option)
            {
                $selected_values[$index][trim($option->getOptValue())] = true;
            }

            $index++;
        }

        $product = ProductPeer::retrieveByPk($product_id);

        $ids = stNewProductOptions::updateProduct($product, $ids, $selected_values, false);

        $content = $this->getRenderComponent('stProductOptionsBackend', 'optionPicker', array('product' => $product, 'namespace' => $namespace, 'selected' => $ids, 'ajax' => true));

        $price = $product->getPriceBrutto();

        if ($product->getPriceModifiers())
        {
           $price = stPrice::computePriceModifiers($product, $price, 'brutto');
        }

        return $this->renderJSON(array(
            'price' => $price,
            'stock' => $product->getStock(),
            'man_code' => $product->getManCode(),
            'options' => $ids,
            'content' => $content,
        ));
    }
}
