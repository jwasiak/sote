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

   public function preSave($product, $con = null)
   {
      $product->setCulture(stLanguage::getOptLanguage());
   }

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

   public function setMPositioning($product, $title, $keywords, $description)
   {
      if ($title && $keywords && $description)
      {
         $php = new ProductHasPositioning();

         $php->setCulture('pl_PL');


         $php->setTitle($title);

         $php->setKeywords($keywords);

         $php->setDescription($description);


         $product->addProductHasPositioning($php);
      }
   }

   public function setMCode($product, $v)
   {
      $c = new Criteria();

      $c->add(ProductPeer::CODE, $v);

      $count = ProductPeer::doCount($c);

      $product->setCode($count ? 'DUPLICATE_'.$count.'_'.$v : $v);
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
      $names = array_values($names);

      $count = count($names);

      for ($i = 0; $i < $count; $i++)
      {
         if (!empty($names[$i]))
         {
            $culture = stMigrationSoteshopHelper::getCultureByLangId($i);

            $product->setCulture($culture);

            $product->setName($names[$i]);
         }
      }
   }

   public function setMDescription($product, $descriptions)
   {
      $descriptions = array_values($descriptions);

      $count = count($descriptions);

      for ($i = 0; $i < $count; $i++)
      {
         if (!empty($descriptions[$i]))
         {
            $culture = stMigrationSoteshopHelper::getCultureByLangId($i);

            $product->setCulture($culture);

            $product->setDescription($descriptions[$i]);
         }
      }
   }

   public function setMShortDescription($product, $descriptions)
   {
      $descriptions = array_values($descriptions);

      $count = count($descriptions);

      for ($i = 0; $i < $count; $i++)
      {
         if (!empty($descriptions[$i]))
         {
            $culture = stMigrationSoteshopHelper::getCultureByLangId($i);

            $product->setCulture($culture);

            $product->setShortDescription($descriptions[$i]);
         }
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
         for ($i = 0; $i <= 10; $i++)
         {
            $filename = stMigrationSoteshopHelper::fixString($image).($i ? '-'.$i : '').'.'.$ext;

            $url_filename = rawurlencode($image).($i ? '-'.$i : '').'.'.$ext;

            $image_path = $this->uploadImage($this->getMigrationParam('www').'/photo/'.$url_filename);

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
      if (!is_array($attributes))
         return;

      foreach ($attributes as $name => $options)
      {
         $pof = new ProductOptionsField();

         $pof->setCulture('pl_PL');

         $pof->setName($name);

         $pof->save($con);

         foreach ($options as $name => $params)
         {
//            $root = $root->reload();

            $pov = new ProductOptionsValue();

            $pov->setCulture('pl_PL');

            $pov->setProduct($product);

            $pov->setProductOptionsField($pof);

            $pov->setValue($name);

            $pov->setPrice($params['price']);

            $pov->setSfAssetId(isset($product->imageNo2Asset[$params['image']]) ? $product->imageNo2Asset[$params['image']] : null);

            $pov->insertAsLastChildOf($root);

            $pov->save($con);
            
            $root->setRgt($pov->getRgt()+1);

//            $this->addProductOptionsRecursive($product, $params['nested'], $pov, $con);
         }
      }
   }

   protected function categoryWalk($path, $ids = array())
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

      for ($i = 0; $i < $count && !empty($path[$i]); $i++)
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

      for ($j = $i; $j < $count && !empty($path[$j]); $j++)
      {

         $category = new Category();

         $category->setCulture('pl_PL');

         $category->setName($path[$j]);

         $dictionary = $this->getDictionary($path[$j]);

         if ($dictionary) 
         {
            foreach ($dictionary as $culture => $name) {
               if ($name) 
               {
                  $category->setCulture($culture);
                  $category->setName($name);
               }
            }
         }

         $category->insertAsLastChildOf($tmp);

         $category->setCulture(stLanguage::getOptLanguage());

         $category->save();

         if (isset($ids[$j]))
         {
            $this->addCategoryPositioning($category, $ids[$j]);
         }

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

      $filename = basename($image);

      $product_has_asset->createAsset($filename, $image, ProductHasSfAssetPeer::IMAGE_FOLDER);

      $product_has_asset->save($con);

      $product->imageNo2Asset[$filename] = $product_has_asset->getSfAssetId();
   }

}