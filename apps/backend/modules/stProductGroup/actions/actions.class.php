<?php
/**
 * SOTESHOP/stProductGroup
 *
 * Ten plik należy do aplikacji stProductGroup opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProductGroup
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 17601 2012-03-30 11:05:39Z krzysiek $
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>, Paweł Byszewski <pawel.byszewski@sote.pl>
 */

/**
 * Akcje grupy produktów.
 *
 * @package stProductGroup
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>, Paweł Byszewski <pawel.byszewski@sote.pl>
 */

class stProductGroupActions extends autostProductGroupActions
{
    public function executeDelete()
    {
        ProductGroupPeer::cleanCache();
        parent::executeDelete();
    }


      public function executeEdit()
  {
        $this->config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');
        $this->config_group = stConfig::getInstance(sfContext::getInstance(), 'stProductGroup');

        parent::executeEdit(); 
  }

    public function executeProductAddGroup()
    {  
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

        $ids = $this->getRequestParameter('product[selected]', array($this->getRequestParameter('id')));
        $related_id = $this->getRequestParameter('forward_parameters[product_group_id]');
        $forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStProductGroup/product_forward_parameters');
        
        foreach ($ids as $id)
        {
            $product = ProductPeer::retrieveByPK($id);
            $opt_pg = $product->getOptProductGroup();
            if ($opt_pg)
            {
                $opt_pg = unserialize($opt_pg);
                if (!in_array($related_id, $opt_pg))
                {
                    $opt_pg[] = $related_id;
                }
            }
            else
            {
                $opt_pg = array();
                $opt_pg[] = $related_id;     
            }

            $opt_pg = serialize($opt_pg);
            $product->setOptProductGroup($opt_pg);
            $product->save();

            $c = new Criteria();
            $c->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $related_id);
            $c->add(ProductGroupHasProductPeer::PRODUCT_ID, $id);
            
            if (!ProductGroupHasProductPeer::doCount($c))
            {
                $product_group_has_product = new ProductGroupHasProduct();
                $product_group_has_product->setProductGroupId($related_id);
                $product_group_has_product->setProductId($id);
                $product_group_has_product->save();
            }
        }

        ProductGroupPeer::cleanCache();
        
        return $this->redirect('stProductGroup/productList?page='.$this->getRequestParameter('page', 1).'&product_group_id='.$forward_parameters['product_group_id']);
    }

  
    public function executeProductRemoveGroup()
    {  
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

        $ids = $this->getRequestParameter('product[selected]', array($this->getRequestParameter('id')));
        $related_id = $this->getRequestParameter('forward_parameters[product_group_id]');
        $forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStProductGroup/product_forward_parameters');
        
        foreach ($ids as $id)
        {
            $product = ProductPeer::retrieveByPK($id);
            $opt_pg = $product->getOptProductGroup();
            if ($opt_pg)
            {
                $opt_pg = unserialize($opt_pg);
                if (in_array($related_id, $opt_pg))
                {
                    $opt_pg = array_flip($opt_pg);
                    unset($opt_pg[$related_id]);
                    $opt_pg = array_flip($opt_pg);
                }
            }
            $opt_pg = serialize($opt_pg);
            $product->setOptProductGroup($opt_pg);
            $product->save();
        }

        $c = new Criteria();
        $c->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $related_id);
        $c->add(ProductGroupHasProductPeer::PRODUCT_ID, array_values($ids), Criteria::IN);

        BasePeer::doDelete($c, Propel::getConnection());  

        ProductGroupPeer::cleanCache();      
        
        return $this->redirect('stProductGroup/productList?page='.$this->getRequestParameter('page', 1).'&product_group_id='.$forward_parameters['product_group_id']);
    }

    public function addProductFiltersCriteria($c)
    {
        parent::addProductFiltersCriteria($c);

        if (isset($this->filters['list_image']) && $this->filters['list_image'] !== '')
        {
            $c->add(ProductPeer::OPT_IMAGE, null, $this->filters['list_image'] ? Criteria::ISNOTNULL : Criteria::ISNULL);
        }

        if (isset($this->filters['list_assigned']) && $this->filters['list_assigned'] !== '')
        {
            $c->addJoin(ProductPeer::ID, sprintf("%s AND %s = %d", ProductGroupHasProductPeer::PRODUCT_ID, ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $this->forward_parameters['product_group_id']), Criteria::LEFT_JOIN);
            
            if ($this->filters['list_assigned'])
            {
                $c->add(ProductGroupHasProductPeer::ID, null, Criteria::ISNOTNULL);
            }
            else
            {
                $c->add(ProductGroupHasProductPeer::ID, null, Criteria::ISNULL);
            }
        }
    }

  protected function saveConfig() 
  {      
    parent::saveConfig();
    stFastCacheManager::clearCache();
  }

  protected function saveProductGroup($product_group)
    {

        $this->config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');

        $this->config_group = stConfig::getInstance(sfContext::getInstance(), 'stProductGroup');

        $new_type = $this->getRequestParameter('new_type');

        $new_product_date = $this->getRequestParameter('new_product_date');

        if (isset($new_type))
        {
            $this->config_group->set('new_type', $new_type);
            $this->config_group->save();
        }

        if (isset($new_product_date))
        {
            $this->config->set('new_product_date', $new_product_date);
            $this->config->save();
        }


        if (!$this->getRequest()->hasErrors() && $this->hasRequestParameter('product_group[delete_image]'))
        {
            $currentFile = sfConfig::get('sf_upload_dir')."/product_group/".$product_group->getImage();
            $product_group->setImage('');
            if (is_file($currentFile))
            {
                unlink($currentFile);
            }      
        }

        if (!$this->getRequest()->hasErrors() && $this->hasRequestParameter('product_group[label]'))
        {
            $product_group->setLabel($this->getRequestParameter('product_group[label]'));
        }

        parent::saveProductGroup($product_group);

        $this->saveProductGroupImage($product_group);

        stFastCacheManager::clearCache();
    }
    
    protected function saveProductGroupImage($product_group)
    {
        if ($this->getRequest()->getFileError('product_group[image]') == UPLOAD_ERR_OK)
        {
            $filename = $this->getRequest()->getFileName('product_group[image]');

            $filepath = $this->getRequest()->getFilePath('product_group[image]');

            $ext = sfAssetsLibraryTools::getFileExtension($filename);

            // dodaj zdjecie 
            if (!$this->getRequest()->hasErrors() && $this->getRequest()->getFileSize('product_group[image]'))
            {
              $currentFile = sfConfig::get('sf_upload_dir')."/product_group/".$filename;
              if (is_file($currentFile))
              {
                unlink($currentFile);
              }
              $this->getRequest()->moveFile('product_group[image]', sfConfig::get('sf_upload_dir')."/product_group/".$filename);
              $product_group->setImage($filename);
            }

            $product_group->save();
        }
    }

    public function executeFixOptProductGroup()
    {

    }
  
    protected function addFiltersCriteria($c)
    {
        $c->add(ProductGroupPeer::FROM_BASKET_VALUE, null, Criteria::ISNULL);

        parent::addFiltersCriteria($c);
    }    

  public function handleErrorEdit()
  {
    $this->config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');
    $this->config_group = stConfig::getInstance(sfContext::getInstance(), 'stProductGroup');

    $this->preExecute();
    $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStProductGroup/forward_parameters');    
    $this->product_group = $this->getProductGroupOrCreate();
    $this->updateProductGroupFromRequest();

    $this->labels = $this->getLabels();

    $this->related_object = $this->product_group;
    

    return sfView::SUCCESS;
  }


}
