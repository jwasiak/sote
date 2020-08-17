<?php
/** 
 * SOTESHOP/stMigrationSoteshopPlugin 
 * 
 * Ten plik należy do aplikacji stMigrationSoteshopPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stMigrationSoteshopPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stMigrationProduct.class.php 13946 2011-07-05 13:22:43Z marcin $
 */

/** 
 * Klasa odpowiadająca za obsługę procesu migracji
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigrationSoteshopPlugin
 * @subpackage  libs
 */
class stMigrationProduct extends stMigrationModel
{
    protected $rootCategory = null;
    
    protected $mProductOptions = null;
    
    protected $mWholesale = null;

    public function postSave($product, $con = null)
    {

        $default = true;

        foreach ($product->mImageFiles as $image)
        {
            $this->addImageToProduct($product, $image, $default, $con);

            $default = false;
        }

        $this->addProductOptions($product, $this->mProductOptions, $con);
    }
    
    public function setMCode($product, $v)
    {
        $v = stMigrationSoteshopHelper::fixString($v);
        
        $c = new Criteria();
        
        $c->add(ProductPeer::CODE, $v);
        
        $same_product = ProductPeer::doSelectOne($c);
        
        $product->setCode(is_object($same_product) ? 'DUPLICATE_' . $v : $v);
    }
    
    public function setMVat($product, $v)
    {
        $c = new Criteria();
        
        $c->add(TaxPeer::VAT, $v);
        
        $tax = TaxPeer::doSelectOne($c);
        
        if (is_null($tax))
        {
            $tax = new Tax();
            
            $tax->setVat($v);
        }
        
        $product->setOptVat($v);
        
        $product->setTax($tax);
    }
    
    public function setMProducer($product, $v)
    {
        if (!empty($v))
        {
            $c = new Criteria();
            
            $c->add(ProducerI18nPeer::NAME, $v);
            
            $c->add(ProducerI18nPeer::CULTURE, 'pl_PL');
            
            $producer = ProducerPeer::doSelectWithI18n($c);
            
            if (!isset($producer[0]))
            {
                $producer = new Producer();
                
                $producer->setCulture('pl_PL');
                
                $producer->setName($v);
            }
            else
            {
                $producer = $producer[0];
            }
            
            $product->setProducer($producer);
        }
    }
    
    public function setMName($product, $names)
    {
        if (!empty($names['name']))
        {
            $product->setCulture('pl_PL');
            
            $product->setName($names['name']);
        }
        
        if (!empty($names['en_name']))
        {
            $product->setCulture('en_US');
            
            $product->setName($names['en_name']);
        }
        
        if (!empty($names['de_name']))
        {
            $product->setCulture('de');
            
            $product->setName($names['de_name']);
        }
    }
    
    public function setMDescription($product, $descriptions)
    {
        if (!empty($descriptions['xml_description']))
        {
            $product->setCulture('pl_PL');
            
            $product->setDescription($descriptions['xml_description']);
        }
        
        if (!empty($descriptions['en_xml_description']))
        {
            $product->setCulture('en_US');
            
            $product->setDescription($descriptions['en_xml_description']);
        }
        
        if (!empty($descriptions['de_xml_description']))
        {
            $product->setCulture('de');
            
            $product->setDescription($descriptions['de_xml_description']);
        }
    }
    
    public function setMShortDescription($product, $descriptions)
    {
        if (!empty($descriptions['xml_description']))
        {
            $product->setCulture('pl_PL');
            
            $product->setShortDescription($descriptions['xml_description']);
        }
        
        if (!empty($descriptions['en_xml_short_description']))
        {
            $product->setCulture('en_US');
            
            $product->setShortDescription($descriptions['en_xml_short_description']);
        }
        
        if (!empty($descriptions['de_xml_short_description']))
        {
            $product->setCulture('de');
            
            $product->setShortDescription($descriptions['de_xml_short_description']);
        }
    }
    
    public function setMImage($product, $v, $user_id)
    {
        $pathinfo = pathinfo($v);

        $ext = isset($pathinfo['extension']) ? $pathinfo['extension'] : '';

        $image = isset($pathinfo['filename']) ? $pathinfo['filename'] : '';

        $product->mImageFiles = array();

        $this->getLogger()->info(sprintf('Przenosze zdjęcia z produktu o id "%s" do produktu o kodzie "%s"', $user_id, $product->getCode()));

        if (strtolower($ext) == 'jpg' || strtolower($ext) == 'gif' || strtolower($ext) == 'png')
        {
            for($i = 0; $i <= 10; $i++)
            {
                $filename = stMigrationSoteshopHelper::fixString($image) . ($i ? '-' . $i : '') . '.' . $ext;

                $url_filename = rawurlencode($image) . ($i ? '-' . $i : '') . '.' . $ext;

                $image_path = $this->uploadImage($this->getMigrationParam('www') . '/photo/' . $url_filename);

                if ($image_path)
                {
                    $product->mImageFiles[] = $image_path;
                }
                else
                {
                    break;
                }
            }
        }
        else
        {
            $this->getLogger()->notice('Produkt nie zawiera zdjęć...');
        }
    }
    
    public function setMGroup($product, $main_page, $bestseller, $promotion)
    {
        if (!empty($main_page))
        {
            $this->addProductToGroupType($product, 'MAIN_PAGE');
        }
        
        if (!empty($promotion))
        {
            $this->addProductToGroupType($product, 'PROMOTION');
        }
    }
    
    public function setMCategoryMulti($product, $category_multi_1, $category_multi_2)
    {
        if (!empty($category_multi_1))
        {
            $categories = explode("/", $category_multi_1);
            
            $category = $this->categoryWalk($categories);
            
            $this->addProductToCategory($product, $category);
        }
        
        if (!empty($category_multi_2))
        {
            $categories = explode("/", $category_multi_2);
            
            $category = $this->categoryWalk($categories);
            
            $this->addProductToCategory($product, $category);
        }
    }
    
    /**
     * @param Product $product
     */
    public function setMCategory($product, $categories)
    {
        $category = $this->categoryWalk(array_values($categories));
        
        $this->addProductToCategory($product, $category);
    }
    
    public function setMPrice($product, $price_brutto, $vat)
    {
        $product->setPriceNettoByBrutto($price_brutto, $vat);
    }
    
    public function setMProductOptions($product, $xml_options)
    {
        $this->mProductOptions = $xml_options;
    }

    protected function addProductOptions($product, $xml_options, $con = null)
    {
        if (!empty($xml_options))
        {
            $root = new ProductOptionsValue();

            $root->makeRoot();

            $root->setProduct($product);

            $root->setCulture('pl_PL');

            $root->save($con);

            $attributes = stMigrationSoteshopHelper::xmlOptionsToArray($xml_options);

            $this->addProductOptionsRecursive($product, $attributes, $root, $con);
        }
    }

    protected function addProductOptionsRecursive($product, $attributes, $root, $con = null)
    {
        if (!is_array($attributes)) return;

        foreach ($attributes as $name => $options)
        {
            $pof = new ProductOptionsField();

            $pof->setCulture('pl_PL');

            $pof->setName($name);

            $pof->save($con);

            foreach ($options as $name => $params)
            {
//                $root = $root->reload();

                $pov = new ProductOptionsValue();

                $pov->setCulture('pl_PL');

                $pov->setProduct($product);

                $pov->setProductOptionsField($pof);

                $pov->setValue($name);

                $pov->setPrice($params['price']);

                $pov->insertAsLastChildOf($root);

                $pov->save($con);
                
                $root->setRgt($pov->getRgt()+1);

//                $this->addProductOptionsRecursive($product, $params['nested'], $pov, $con);
            }
        }
    }
    
    protected function categoryWalk($path)
    {
        $tmp = $this->getRootCategory();
        
        if (is_null($tmp))
        {
            $tmp = new Category();
            
            $tmp->setCulture('pl_PL');
            
            $tmp->setName('Kategorie');
            
            $tmp->makeRoot();
            
            $tmp->save();
            
            $tmp->setScope($tmp->getId());
            
            $tmp->save();
        }
        
        $tmp = $tmp->reload();
        
        $count = count($path);
        
        for($i = 0; $i < $count && !empty($path[$i]); $i++)
        {
            $c = new Criteria();
            
            $c->add(CategoryI18nPeer::NAME, $path[$i]);
            
            $c->add(CategoryPeer::PARENT_ID, $tmp->getId());
            
            $c->add(CategoryI18nPeer::CULTURE, 'pl_PL');
            
            $category = CategoryPeer::doSelectWithI18n($c);
            
            if (!isset($category[0]))
                break;
            
            $tmp = $category[0];
        }
        
        $tmp->setCulture('pl_PL');
        
        for($j = $i; $j < $count && !empty($path[$j]); $j++)
        {
            
            $category = new Category();
            
            $category->setCulture('pl_PL');
            
            $category->setName($path[$j]);
            
            $category->insertAsLastChildOf($tmp);
            
            $category->save();
            
            $tmp = $category;
        }
        
        return $tmp;
    }
    
    protected function getRootCategory()
    {
        if (is_null($this->rootCategory))
        {
            $c = new Criteria();
            
            $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);
            
            $this->rootCategory = CategoryPeer::doSelectOne($c);
        }
        
        return $this->rootCategory;
    }
    
    protected function getProductGroupByType($type = 'MAIN_PAGE')
    {
        $c = new Criteria();
        
        $c->add(ProductGroupPeer::PRODUCT_GROUP, $type);
        
        return ProductGroupPeer::doSelectOne($c);
    }
    
    protected function addProductToGroupType($product, $group_type = 'MAIN_PAGE')
    {
        $product_group = $this->getProductGroupByType($group_type);
        
        $product_group_has_product = new ProductGroupHasProduct();
        
        $product_group_has_product->setProduct($product);
        
        $product_group_has_product->setProductGroup($product_group);
        
        $product->addProductGroupHasProduct($product_group_has_product);
    }
    
    protected function addProductToCategory($product, $category)
    {
        $product_has_category = new ProductHasCategory();
        
        $product_has_category->setCategory($category);
        
        $product->addProductHasCategory($product_has_category);
    }
    
    protected function addImageToProduct($product, $image, $default = false, $con = null)
    {
        $product_has_asset = new ProductHasSfAsset();
        
        $product_has_asset->setIsDefault($default);
        
        $product_has_asset->setProduct($product);
        
        $product_has_asset->createAsset(basename($image), $image, ProductHasSfAssetPeer::IMAGE_FOLDER);
        
        $product_has_asset->save($con);
    }

}