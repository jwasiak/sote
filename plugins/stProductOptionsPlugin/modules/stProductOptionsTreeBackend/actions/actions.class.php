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
 * @version     $Id: actions.class.php 15992 2011-11-07 14:35:09Z piotr $
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'stProduct'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stProductNumberValidator.class.php');

/**
 * Klasa zawierające akcje obsługujące działania na drzewie wartości produktu.
 * W parametrach requesta należy zawsze podawać model bazy danych na którym ma być\
 * dokonywana operacja (ProductOptionsDefaultValue lub ProductOptionsValue).
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stProductOptionsPlugin
 * @subpackage  actions
 */
class stProductOptionsTreeBackendActions extends sfActions
{
    public function executeSaveProductOption()
    {
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stProduct', false);
        $this->setLayout(false);
        $id = $this->getRequestParameter('id');
        $product_option_values = $this->getRequestParameter('product_option');
        $field_values = $this->getRequest()->getParameterHolder()->get('field');

        if($id)
        {
            $errors = array('values'=>array(), 'errors'=>array());

            if(!empty($product_option_values))
            {           
                $errors['errors'] = $this->verifyOptionData($product_option_values, $id);
                if(count($errors['errors']) == 0)
                {

                	$errors['values'][] = array('id'=>'product_option_price', 'value'=>$product_option_values['price'] ? $product_option_values['price'] : '');
                    $product_option = call_user_func($product_option_values['model'].'Peer::retrieveByPk',$id);
                    $product_option->setCulture($product_option_values['culture']);

                    if ($product_option_values['model'] == 'ProductOptionsValue') $product_option->setUseProduct(isset($product_option_values['use_product']) && $product_option_values['use_product'] ? $product_option_values['use_product'] : null);
                    if ($product_option_values['model'] == 'ProductOptionsValue' && isset($product_option_values['old_price'])) $product_option->setOldPrice($product_option_values['old_price']);
                    if(isset($product_option_values['value'])) $product_option->setValue($product_option_values['value']);

                    if ($product_option_values['model'] == 'ProductOptionsValue' && isset($product_option_values['man_code']))
                    {
                        $product_option->setManCode($product_option_values['man_code']);
                    }
                    
                    if(isset($product_option_values['price']) && !empty($product_option_values['price']))
                    {
                        $product_option->setPrice($product_option_values['price']); 
                    }
                    else
                    {
                        $product_option->setPrice(null);
                    }

                    if(isset($product_option_values['weight']) && !empty($product_option_values['weight']))
                    {
                        $product_option->setWeight($product_option_values['weight']);
                    } 
                    else
                    {
                        $product_option->setWeight(null);
                    }

                    if(isset($product_option_values['pum']) && !empty($product_option_values['pum']))
                    {
                        $product_option->setPum($product_option_values['pum']);
                    } 
                    else
                    {
                        $product_option->setPum(null);
                    }                    
                    
                    $this->updateColorImage($product_option);

                    if(isset($product_option_values['price_type'])) $product_option->setPriceType($product_option_values['price_type']);
                    if(isset($product_option_values['sf_asset_id'])) $product_option->setsfAssetId($product_option_values['sf_asset_id'] ? $product_option_values['sf_asset_id'] : null);
                    if ($product_option_values['model'] == 'ProductOptionsValue' && $product_option->getProduct()->getStockManagment() == ProductPeer::STOCK_PRODUCT_OPTIONS)
                    {
                        if (isset($product_option_values['stock'])) {
                            $product_option->setStock($product_option_values['stock']);
                        } 
                        elseif ($product_option->isLeaf() && !isset($product_option_values['validate_stock']))
                        {
                            $product_option->setStock(null);
                        }
                    }
                       
                    stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stProductOptionsBackend.preSaveOption', array('product_option'=>$product_option)));
                    $product_option->save();

                    if ($product_option_values['model'] == 'ProductOptionsValue')
                    {
                        ProductOptionsValuePeer::clearImportHash($product_option->getProductId());
                        if (stConfig::getInstance('stSearchBackend')->get('options'))
                        {
                            stNewSearch::buildIndexAllLanguages($product_option->getProduct());
                        }
                    }
                }
            }

            if($field_values)
            {
                $errors['errors'] = $this->verifyFieldData($field_values, $id);
                if(count($errors['errors']) == 0)
                {
                    $field = ProductOptionsFieldPeer::retrieveByPk($id);
                    $field->setCulture($field_values['culture']);
                    $model = $this->getRequestParameter('model');
                    
                    if(isset($field_values['name'])) $field->setName(trim($field_values['name']));
                    if(isset($field_values['filter_type'])) $field->setProductOptionsFilterId(trim($field_values['filter_type']));
                    else $field->setProductOptionsFilterId(null);
                    if(isset($field_values['typ'])) $field->setTyp(trim($field_values['typ']));
                    if(isset($field_values['default_value'])) 
                    {
                        $default_product_option = call_user_func(array($model.'Peer', 'retrieveByPK'), $field_values['default_value']);
                        $field->setDefaultValue($default_product_option->getOptValue());
                        $field->setOptValueId($default_product_option->getId());
                    }
                    $field->save();
                    ProductOptionsValuePeer::updateProductColor($this->getRequestParameter('product_id'));
                }
            }

            $this->getResponse()->setHttpHeader('Content-type', 'application/json');
            $json = json_encode($errors);
            stFastCacheManager::clearCache();
            return $this->renderText($json);
        }
        return sfView::HEADER_ONLY;
    }

    /**
     * Sprawdza poprawność danych wprowadzonych
     * w formularzu dotyczącym właściwości pola.
     *
     * @return array()
     */
    private function verifyFieldData($data, $id)
    {
        $errors = array();
        $i18n = $this->getContext()->getI18n();

        if(empty($data['name']) ||  trim($data['name']) == '')
        {
            $error['id'] = 'error_for_field_name';
            $error['msg'] = $i18n->__('Podaj nazwe pola');
            $errors[] = $error;
        }

        return $errors;
    }
    /**
     * Sprawdza poprawność danych wprowadzonych
     * w formularzu dotyczącym właściwości opcji.
     *
     * @return array()
     */
    private function verifyOptionData($data, $id)
    {
        $errors = array();
        $i18n = $this->getContext()->getI18n();

        if(empty($data['root']) && (empty($data['value']) || trim($data['value']) == ''))
        {
            $error['id'] = 'error_for_product_option_value';
            $error['msg'] = $i18n->__('Podaj nazwe opcji');
            $errors[] = $error;
        }
        else
        {
            
            if(isset($data['model']) && $option_object = call_user_func($data['model'].'Peer::retrieveByPk',$id))
            {
                if(!$option_object->isRoot())
                {
                    $parent = $option_object->getParent();
                    foreach($parent->getChildren() as $sibling)
                    {
                        if($sibling->getId() != $id && $sibling->getValue() == $data['value'] && $sibling->getProductOptionsFieldId() == $option_object->getProductOptionsFieldId())
                        {
                            $error['id'] = 'error_for_product_option_value';
                            $error['msg'] = $i18n->__('Istnieje już opcja dla tego pola o podanej wartości');
                            $errors[] = $error;
                        }
                    }
                }
            }
        }

        if(isset($data['price']) && !empty($data['price']))
        {
            if(!is_numeric(rtrim($data['price'], '%')))
            {
                $error['id'] = 'error_for_product_option_price';
                $error['msg'] = $i18n->__('Niewłaściwy format modyfikatora ceny');
                $errors[] = $error;
            }
        }

        if(isset($data['weight']) && !empty($data['weight']))
        {
            if(!is_numeric(rtrim($data['weight'], '%')))
            {
                $error['id'] = 'error_for_product_option_weight';
                $error['msg'] = $i18n->__('Niewłaściwy format modyfikatora wagi');
                $errors[] = $error;
            }
        }        

        if(isset($data['old_price']) && !empty($data['old_price']))
        {
            if(!is_numeric($data['old_price'])){
                $error['id'] = 'error_for_product_option_old_price';
                $error['msg'] = $i18n->__('Niewłaściwy format starej ceny');
                $errors[] = $error;
            }
        }

        if(isset($data['color'])) 
        {
            if (strlen(trim($data['color']))!=6) {
                $error['id'] = 'error_for_product_option_filter';
                $error['msg'] = $i18n->__('Niewłaściwy format koloru opcji, proszę podać w postaci #123456');
                $errors[] = $error;
            }
        }

        if(isset($data['use_product'])) 
        {
            $code = trim($data['use_product']);
            if (!empty($code))
            {
                $c = new Criteria();
                $c->add(ProductPeer::CODE, $code);

                if (ProductPeer::doCount($c)) {
                    $error['id'] = 'error_for_product_option_use_product';
                    $error['msg'] = $i18n->__('Produkt o podanym kodzie już istnieje');
                    $errors[] = $error;
                }
            }
        }

        $event = stEventDispatcher::getInstance()->filter(new sfEvent($this, 'stProductOptionsBackend.verifyOptionData'), $errors);

        return $event->getReturnValue();
    }

    /**
     * Zmienia wartość/nazwe wartości/pola.
     *
     * @return   sfView::HEADER_ONLY
     */
    public function executeChangeProductOptionValue()
    {
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stProduct', false);
        $model = $this->getRequestParameter("model");
        $value = $this->getRequestParameter("value");
        $id = $this->getRequestParameter("id");
        $field = $this->getRequestParameter('field');

        if (! empty($value))
        {
            if($field==null || $field=='undefined')
            {

                $product_option = call_user_func($model.'Peer::retrieveByPK',$id);

                $product_option->setCulture($this->getRequestParameter('language','pl_PL'));
                
                $product_option->setValue($value);

                $product_option->save();
                
                //Zmiany w szablonie wiec usuwanie informaji na temat szablonu w root
                if ($model == 'ProductOptionsValue') {
                    stProductOptionsTreeBackendActions::clearTemplateInfo($product_option);
                    
                    if (stConfig::getInstance('stSearchBackend')->get('options'))
                    {
                        stNewSearch::buildIndexAllLanguages($product_option->getProduct());
                    }
                }
            }
            else
            {
                $field = ProductOptionsFieldPeer::retrieveByPk($field);
                $field->setCulture($this->getRequestParameter('language','pl_PL'));
                $field->setName($value);
                $field->save();
                if ($model == 'ProductOptionsValue') {
                    stProductOptionsTreeBackendActions::clearTemplateInfo($field);
                }
                
                //Zmiany w szablonie wiec usuwanie informaji na temat szablonu w root
            }

            stFastCacheManager::clearCache();
        }

        
        return sfView::HEADER_ONLY;
    }

    /**
     * Akcja usuwająca wartość z drzewa.
     *
     * @return   sfView
     */
    public function executeRemoveProductOption()
    {
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stProduct', false);
        $model = $this->getRequestParameter("model");
        $peer = $model.'Peer';
        $field = $this->getRequestParameter("field");
        $parent_id = $this->getRequestParameter("parent_id");
        $id = $this->getRequestParameter("id");

        if($field==null || $field=='undefined')
        {
            $option = call_user_func($model.'Peer::retrieveByPk',$id);
            if ($option)
            {
                $option->delete();

                if ($model == 'ProductOptionsValue')
                {
                    $product = $option->getProduct();
                }

                $output = json_encode(array('id' => $option->getId()));
            }
        }
        else
        {
            $field = ProductOptionsFieldPeer::retrieveByPk($field);
            if($field)
            {
                $c = new Criteria();
                $c->addSelectColumn(constant($peer.'::ID'));
                $c->add(constant($peer.'::PRODUCT_OPTIONS_FIELD_ID'), $field->getId());
                $rs = call_user_func($peer.'::doSelectRs', $c);


                $product = null;

                $fields = array();

                while($rs->next())
                {
                    $row = $rs->getRow();
                    $option = call_user_func($peer.'::retrieveByPk', $row[0]);
                    
                    if ($model == 'ProductOptionsValue' && null === $product)
                    {
                        $product = $option->getProduct();
                    }

                    $option->delete();
                }

                $field->delete();

                $output = json_encode(array('id' => $id));
            }
        }

        if($model == 'ProductOptionsValue' && $product)
        {
            ProductOptionsValuePeer::updateStock($product);
        
            $s = new Criteria();
            $s->add(ProductPeer::ID, $product->getId());
            $u = new Criteria();
            $c = new Criteria();
            $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product->getId());
            $u->add(ProductPeer::OPT_HAS_OPTIONS, ProductOptionsValuePeer::doCount($c));
            BasePeer::doUpdate($s, $u, Propel::getConnection());  
            ProductOptionsValuePeer::clearImportHash($product->getId());
            if (stConfig::getInstance('stSearchBackend')->get('options'))
            {
                stNewSearch::buildIndexAllLanguages($product);
            }
        }
         

        stFastCacheManager::clearCache();
        $this->getResponse()->setHttpHeader('Content-Type', 'application/json');
        return $this->renderText($output);
    }
    
    public function deleteRecurrence($model, $option_id) {
        $option = call_user_func($model.'Peer::retrieveByPk', $option_id);
        
        $c2 = new Criteria(); 
        if ($model == 'ProductOptionsDefaultValue') $c2->add(constant($model.'Peer::PRODUCT_OPTIONS_TEMPLATE_ID'), $option->getProductOptionsTemplateId()); 
        else $c2->add(constant($model.'Peer::PRODUCT_ID'),$option->getProductId());
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
    
    /**
     * Dodaje nowy atrybut lub wartość
     *
     * @return   sfView
     */
    public function executeAppendProductOption()
    {
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stProduct', false);
        $output = '';

        $model = $this->getRequestParameter("model");
        $id = $this->getRequestParameter('id');
        $parent_id = $this->getRequestParameter('parent_id');
        $field = $this->getRequestParameter('field');
        $value = $this->getRequestParameter('name');

        if($field==null || $field=='undefined')
        {
            $field = new ProductOptionsField();
            $parent = call_user_func($model.'Peer::retrieveByPk', $id);
            $field->setCulture($parent->getCulture());
            $field->setName($value);
            $last = $parent->retrieveLastChild();
            if ($last && $last->getProductOptionsField())
            {
                $field->setFieldOrder($last->getProductOptionsField()->getFieldOrder() + 1);
            }
            $field->setProductOptionsTemplateId($parent->getProductOptionsTemplateId());
            if ($model == 'ProductOptionsValue') {
                $field->setProductOptionsTemplateId(0);
            }
            $field->setOptValueId($parent->getId());
            $field->save();
            stProductOptionsTreeBackendActions::clearTemplateInfo($field);

            $output = json_encode(array('name' => $field->getName(), 'field' => $field->getId(), 'text' => $field->getName(), 'parent_id' => $id, 'cls' => 'st_product_options-tree-root'));
        }
        else
        {
            //dodawanie nowej wartości
            $parent = call_user_func($model.'Peer::retrieveByPk',$this->getRequestParameter('parent_id'));
            if($model == 'ProductOptionsValue')
            {
                if($parent->isRoot() && !$parent->hasChildren() && $parent->getProduct()->getStock() != null)
                {
                    $parent->getProduct()->setStock(0);
                }
            }
            if ($parent)
            {
                $product_options = new $model;
                $product_options->setCulture($parent->getCulture());
                $product_options->setProductOptionsFieldId($field);
                $product_options->setValue($value);
                if ($model == 'ProductOptionsValue')
                {
                    $product_options->setStock(0);
                }
                $product_options->insertAsLastChildOf($parent);
                $product_options->save();

                $output = json_encode(array('id' => $product_options->getId(), 'name' => $product_options->getValue(), 'parent_id' => $id));
            }
            
            if($model == 'ProductOptionsValue') $parent->getProduct()->save();
            stProductOptionsTreeBackendActions::clearTemplateInfo($parent);            
        }
        $this->getResponse()->setHttpHeader('Content-Type', 'application/json');
        return $this->renderText($output);
    }

    /**
     * Pobiera atrybuty lub wartości atrybutów dla danego rodzica
     *
     * @return   sfView
     */
    public function executeFetchProductOptionValues()
    {
        $i18n = $this->getContext()->getI18n();

        $model = $this->getRequestParameter("model");
        $node = $this->getRequestParameter('node');
        $parent_id = $this->getRequestParameter('parent_id');

        $field = $this->getRequestParameter('field');

        $output = '';

        $extjs_data = array();
        if ($field==null || $field=='undefined')
        {
        	$c = new Criteria();

            $c->addAscendingOrderByColumn(ProductOptionsFieldPeer::FIELD_ORDER);
            
            if ($model == 'ProductOptionsDefaultValue')
        	{
	            $c->addJoin(ProductOptionsFieldPeer::ID, ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID);

	            $c->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, $node);

                $c->addAscendingOrderByColumn(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID);
                $c->addAscendingOrderByColumn(ProductOptionsDefaultValuePeer::LFT); 
            }
            else
            {
	            $c->addJoin(ProductOptionsFieldPeer::ID, ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID);

	            $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $node);

                $c->addAscendingOrderByColumn(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID);
                $c->addAscendingOrderByColumn(ProductOptionsValuePeer::LFT); 
            }

            $c->addGroupByColumn(ProductOptionsFieldPeer::ID);

            $fields = ProductOptionsFieldPeer::doSelect($c);

            foreach ($fields as $field)
            {

                $field->setCulture($this->getRequestParameter('language','pl_PL'));
                $qtip = '<ul type="hidden"><li>'.$i18n->__('Nazwa pola').': '.$field->getName().'<li/>';
                if($field->getTyp())
                {
                    $qtip .= '<li>'.$i18n->__('Typ').': '.$field->getTyp().'<li/>';
                }
                if($field->getDefaultValue())
                {
                    $qtip .= '<li>'.$i18n->__('Domyślna wartość').': '.$field->getDefaultValue().'</li></ul>';
                }
                $extjs_data[] = array('field' => $field->getId(),
                                        'language' => $this->getRequestParameter('language','pl_PL'),
                                        'text' => $field->getName() ? $field->getName() : $i18n->__('opcja',array(),'stProductOptionsTreeBackend'),
                                        'cls' => 'st_product_options-tree-root', 
                                        'qtip' => $qtip);
            }
        }
        else
        {
            $product_options = call_user_func($model.'Peer::retrieveByPk',$parent_id);
            $product_options = $product_options->getChildren();
            foreach($product_options as $product_options)
            {
                $product_options->setCulture($this->getRequestParameter('language','pl_PL'));
                if($product_options->getProductOptionsFieldId()==$field)
                {
                    sfLoader::loadHelpers(array('Helper','stAsset'));
                    $qtip  = '<ul type="hidden"><li>'.$i18n->__('Wartość').': '.$product_options->getValue().'<li/>';
                    if($product_options->getPrice())
                    {
                        $qtip .= '<li>'.$i18n->__('Cena').': '.$product_options->getPrice().'</li>';
                    }
                    if($model=='ProductOptionsValue')
                    {
                        if($asset = $product_options->getsfAsset())
                        {
                            $qtip .= '<li>'.$i18n->__('Zdjęcie').': '.st_asset_image_tag($asset, 'icon').'</li>';
                        }
                    }
                    $qtip .= '</ul>';
                    $extjs_data[] = array('id' => $product_options->getId(),
                                            'language' => $this->getRequestParameter('language','pl_PL'),
                                            'text' => $product_options->getValue() ? $product_options->getValue() : $i18n->__('wartość'),
                                            'qtip' => $qtip);
                }
            }
        }

        $output = json_encode($extjs_data);

        $this->getResponse()->setHttpHeader('Content-Type', 'application/json');
        return $this->renderText($output);
    }

    /**
     * Przenosi wartości w drzewie
     *
     * @return   sfView
     */
    public function executeMoveProductOption()
    {
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'stProduct', false);
        
        $model = $this->getRequestParameter('model');
        $peer = $model.'Peer';
        $field = $this->getRequestParameter('field');
        $id = $this->getRequestParameter('id');
        $sibling_id = $this->getRequestParameter('next_sibling_id');
        $parent_id = $this->getRequestParameter('parent_id');
        $sibling_field = $this->getRequestParameter('next_sibling_field');
        $parent_field = $this->getRequestParameter('parent_field');
        $fields = $this->getRequestParameter('fields', array());

        $options = array();

        if ($sibling_field)
        {
            $c = new Criteria();
            $c->add(constant($peer.'::PRODUCT_OPTIONS_FIELD_ID'), $sibling_field);
            $c->addAscendingOrderByColumn(constant($peer.'::LFT'));
            $options['sibling'] = call_user_func(array($peer, 'doSelectOne'), $c);
        }        
        elseif ($sibling_id)
        {
            $options['sibling'] = call_user_func(array($peer, 'retrieveByPk'), $sibling_id);
        }
        elseif ($parent_field)
        {
            $c = new Criteria();
            $c->add(constant($peer.'::PRODUCT_OPTIONS_FIELD_ID'), $parent_field);
            $tmp = call_user_func(array($peer, 'doSelectOne'), $c);
            $options['parent'] = $tmp->getParent();
        }
        elseif ($parent_id)
        {
            $options['parent'] = call_user_func(array($peer, 'retrieveByPk'), $parent_id);
        }

        if ($field)
        {
            $c = new Criteria();
            $c->add(constant($peer.'::PRODUCT_OPTIONS_FIELD_ID'), $field);
            $c->addAscendingOrderByColumn(constant($peer.'::LFT'));
            $product_options = call_user_func(array($peer, 'doSelect'), $c);           
        }
        else
        {
            $c = new Criteria();
            $c->add(constant($peer.'::ID'), $id);
            $product_options = call_user_func(array($peer, 'doSelect'), $c);
        }

        self::moveOption($product_options, $options);

        foreach ($fields as $order => $id) 
        {
            $field = ProductOptionsFieldPeer::retrieveByPk($id);
            $field->setFieldOrder($order);
            $field->save();
        }
        
        stFastCacheManager::clearCache();

        return sfView::HEADER_ONLY;
    }

    public static function clearTemplateInfo($item) {
        if ($item instanceof  ProductOptionsValue ) {
            $c = new Criteria();
            $c->add(ProductOptionsValuePeer::DEPTH, 0);
            $c->add(ProductOptionsValuePeer::PRODUCT_ID, $item->getProductId());
            $root = ProductOptionsValuePeer::doSelectOne($c);
            $root->setProductOptionsTemplateId(0);
            $root->save();
        }
        
        if ($item instanceof  ProductOptionsField ) {
            $subItem = ProductOptionsValuePeer::retrieveByPk($item->getOptValueId());
            
            
            if ($subItem) {
                $c = new Criteria();
                $c->add(ProductOptionsValuePeer::DEPTH, 0);
                $c->add(ProductOptionsValuePeer::PRODUCT_ID, $subItem->getProductId());
                $root = ProductOptionsValuePeer::doSelectOne($c);
                $root->setProductOptionsTemplateId(0);
                $root->save();
            }
        }
    }

    protected function updateColorImage($product_option)
    {
        $data = $this->getRequestParameter('product_option');

        if (isset($data['color_type']))
        {
            if (!$data['color_type']) 
            {
                $product_option->deleteColorImage();
                $product_option->setColor($data['color']);
            }
            else
            {
                $color_image = $data['color_image'];

                $delete = $color_image['delete'] ? explode(',', $color_image['delete']) : array();

                $modified = $color_image['modified'] ? explode(',', $color_image['modified']) : array();

                $upload_dir = sfConfig::get('sf_web_dir').'/uploads/plupload/'.$color_image['namespace'];

                if ($delete) 
                {
                    $product_option->deleteColorImage();
                }

                if ($modified)
                {
                    $upload = $upload_dir.'/'.$modified[0];

                    if (is_file($upload))
                    {
                        $product_option->deleteColorImage();

                        $product_option->setColorImage($modified[0]);

                        if (!is_dir($product_option->getColorImageDir(true)))
                        {
                            mkdir($product_option->getColorImageDir(true), 0755, true);
                        }

                        rename($upload, $product_option->getColorImagePath(true));
                    }
                } 
            }  

            $product_option->setUseImageAsColor($data['color_type']);    
        }
    }

    public static function moveOption($product_options, $options)
    {
        if ($product_options)
        {
            foreach ((array)$product_options as $option)
            {
                $option = $option->reload();
                if (isset($options['sibling']))
                {
                    $option->moveToPrevSiblingOf($options['sibling']);
                    $options['sibling'] = $options['sibling']->reload();
                }
                elseif (isset($options['parent']))
                {
                    $option->moveToLastChildOf($options['parent']);
                    $options['parent'] = $options['parent']->reload();
                }

                $option->save();
            }      
        }
    }    
}
