<?php
/**
 * SOTESHOP/stWebApiPlugin
 *
 * Ten plik należy do aplikacji stWebApiPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stModuleWebApi.class.php 16947 2012-02-01 14:10:42Z piotr $
 */

/**
 * Komponenty aplikacji stCategory
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 */
class StCategoryWebApi extends autoStCategoryWebApi {

    public function AddCategory($object) {
        if (isset($object->_culture))
            $this->__setCulture($object->_culture);

        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateAddCategoryFields($object);

        if (!$object->parent_id) {
            $item = new Category();
            $item->setCulture(stLanguage::getHydrateCulture());

            $item->makeRoot();
            $item->setName($object->name);
            $item->save();

            $item->setScope($item->getId());
            $item->save();
        } else {
            $parent = CategoryPeer::retrieveByPK($object->parent_id);

            if (!is_object($parent))
                throw new SoapFault('2', sprintf($this->__(WEBAPI_ADD_ERROR), $this->__('niepoprawny parametr parent_id')));

            $parent->setCulture(stLanguage::getHydrateCulture());

            $item = new Category();
            $item->setCulture(stLanguage::getHydrateCulture());
            $item->setName($object->name);
            $item->insertAsLastChildOf($parent);
            $item->save();
        }

        if ($item) {
            try {
                if (isset($object->main_page))
                    $item->setMainPage($object->main_page);

                if (isset($object->description))
                    $item->setDescription($object->description);

                if (isset($object->is_active))
                    $item->setIsActive($object->is_active);

                if (isset($object->is_hidden))
                    $item->setIsHidden($object->is_hidden);

                if (isset($object->show_children_products))
                    $item->setShowChildrenProducts($object->show_children_products);

                $item->save();

                if (isset($object->image) && isset($object->image_filename))
                    $this->setCategoryImage($item, $object->image_filename, $object->image);

                if (isset($object->url)) {
                    $item->setUrl($object->url);
                    $item->save();
                }
            } catch (Exception $e) {
                throw new SoapFault('2', $this->__(WEBAPI_ADD_ERROR));
            }

            ProductHasCategoryPeer::cleanCache();

            $object = new StdClass();
            $this->getFieldsForAddCategory($object, $item);
            ProductHasCategoryPeer::cleanCache();
            return $object;
        } else {
            throw new SoapFault('1', $this->__(WEBAPI_ADD_ERROR));
        }
    }

    public function DeleteCategory($object) {
        $status = parent::DeleteCategory($object);
        ProductHasCategoryPeer::cleanCache();
        return $status;
    }

    public function UpdateCategory($object) {
        if (isset($object->_culture))
            $this->__setCulture($object->_culture);

        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateUpdateCategoryFields($object);

        $item = CategoryPeer::retrieveByPk($object->id);
        if ($item) {
            try {
                $item->setCulture(sfContext::getInstance()->getUser()->getCulture());

                if (isset($object->name))
                    $item->setName($object->name);

                if (isset($object->main_page))
                    $item->setMainPage($object->main_page);

                if (isset($object->description))
                    $item->setDescription($object->description);

                if (isset($object->is_active))
                    $item->setIsActive($object->is_active);

                if (isset($object->is_hidden))
                    $item->setIsHidden($object->is_hidden);

                if (isset($object->show_children_products))
                    $item->setShowChildrenProducts($object->show_children_products);

                if (isset($object->url))
                    $item->setUrl($object->url);

                $item->save();

                if (isset($object->image) && isset($object->image_filename))
                    $this->setCategoryImage($item, $object->image_filename, $object->image);

            } catch (Exception $e) {
                throw new SoapFault('2', sprintf($this->__(WEBAPI_UPDATE_ERROR), $e->getMessage()));
            }

            ProductHasCategoryPeer::cleanCache();

            $object = new StdClass();
            $object->_update = 1;
            return $object;
        } else {
            throw new SoapFault('1', $this->__(WEBAPI_INCORRECT_ID));
        }
    }

    public function GetCategory($object) {
        if (isset($object->_culture))
            $this->__setCulture($object->_culture);

        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetCategoryFields($object);

        $item = CategoryPeer::retrieveByPk($object->id);
        if ($item) {
            $object = new StdClass();
            $this->getFieldsForGetCategory($object, $item);

            if (is_object($item->getSfAsset())) {
                $object->image_filename = basename($item->getSfAsset()->getPath());
                $object->image = base64_encode(file_get_contents(sfConfig::get('sf_web_dir').'/'.$item->getSfAsset()->getPath()));
            }

            return $object;
        } else {
            throw new SoapFault('1', $this->__(WEBAPI_INCORRECT_ID));
        }
    }

    public function GetCategoryList($object) {
        if (isset($object->_culture))
            $this->__setCulture($object->_culture);

        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetCategoryListFields($object);

        $c = new Criteria();
        if (isset($object->_modified_from) && isset($object->_modified_to)) {
            $criterion = $c->getNewCriterion(CategoryPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
            $criterion->addAnd($c->getNewCriterion(CategoryPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
            $c->add($criterion);
        } else {
            if (isset($object->_modified_from)) {
                $criterion = $c->getNewCriterion(CategoryPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $c->add($criterion);
            }
            
            if (isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(CategoryPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                $c->add($criterion);
            }
        }

        if (!isset($object->_limit))
            $object->_limit = 20;

        $c->setLimit($object->_limit);
        $c->setOffset($object->_offset);
        
        $items = CategoryPeer::doSelect($c);
        if ($items) {
            $itemsArray = array();
            foreach ($items as $item) {
                $object = new StdClass();
                $this->getFieldsForGetCategoryList($object, $item);

                if (is_object($item->getSfAsset())) {
                    $object->image_filename = basename($item->getSfAsset()->getPath());
                    $object->image = base64_encode(file_get_contents(sfConfig::get('sf_web_dir').'/'.$item->getSfAsset()->getPath()));
                }

                $itemsArray[] = $object;
            }
            return $itemsArray;
        } else {
            return array();
        }
    }

    public function GetCategoryChildrens($object) {
        if (isset($object->_culture))
            $this->__setCulture($object->_culture);

        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetCategoryChildrensFields($object);

        $c = new Criteria();
        if ($object->parent_id != 0) {
            $c->add(CategoryPeer::PARENT_ID, $object->parent_id);
        } else {
            $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);
        }

        $items = CategoryPeer::doSelect($c);
        if ($items) {
            $itemsArray = array();
            foreach ($items as $item) {
                $object = new StdClass();
                $this->getFieldsForGetCategoryChildrens($object, $item);

                if (is_object($item->getSfAsset())) {
                    $object->image_filename = basename($item->getSfAsset()->getPath());
                    $object->image = base64_encode(file_get_contents(sfConfig::get('sf_web_dir').'/'.$item->getSfAsset()->getPath()));
                }
                $itemsArray[] = $object;
            }
            return $itemsArray;
        } else {
            return array();
        }
    } 

    public function getProductCategoryList($object) {
        if (isset($object->_culture))
            $this->__setCulture($object->_culture);

        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidategetProductCategoryListFields($object);

        $c = new Criteria();
        if (isset($object->_modified_from) && isset($object->_modified_to)) {
            $criterion = $c->getNewCriterion(ProductHasCategoryPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
            $criterion->addAnd($c->getNewCriterion(ProductHasCategoryPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
            $c->add($criterion);
        } else {
            if (isset($object->_modified_from)) {
                $criterion = $c->getNewCriterion(ProductHasCategoryPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $c->add($criterion);
            }

            if (isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(ProductHasCategoryPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                $c->add($criterion);
            }
        }

        if (!isset($object->_limit))
            $object->_limit = 20;

        $c->setLimit($object->_limit);
        $c->setOffset($object->_offset);

        $c->add(ProductHasCategoryPeer::PRODUCT_ID, $object->id);
        $items = ProductHasCategoryPeer::doSelectJoinProduct($c);

        if ($items) {
            $itemsArray = array();
            foreach ($items as $item) {
                $object = new StdClass();
                $this->getFieldsForgetProductCategoryList($object, $item);
                $itemsArray[] = $object;
            }
            return $itemsArray;
        } else {
            return array();
        }
    }

    public function setCategoryImage($item, $filename, $image) {
        $tmpFile = sfConfig::get('sf_cache_dir').'/webapi_category.tmp';

        if (is_object($item->getSfAsset())) {
            $item->getSfAsset()->delete();
            $item->setSfAsset(null);
        }

        file_put_contents($tmpFile, base64_decode($image));
        $item->createAsset($item->getId().'.'.pathinfo($filename, PATHINFO_EXTENSION), $tmpFile);
        $item->save();
    }
}
