<?php

/**
 * SOTESHOP/stProduct
 *
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProduct
 * @subpackage  libs
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: ProductHasSfAsset.php 617 2009-04-09 13:02:31Z michal $
 */

/**
 * Klasa reprezentująca wiersz z tabeli 'st_product_has_sf_asset'
 * 
 * @package     stProduct
 * @subpackage  libs
 *
 */
class ProductHasSfAsset extends BaseProductHasSfAsset
{
   /**
    * Zmienna dodana na potrzeby akcji galleryEdit - nazwa zdjęcia
    * 
    * @var string
    */
   protected $galleryEditImageName = '';
   /**
    * Zmienna dodana na potrzeby akcji galleryEdit - opis zdjęcia
    *
    * @var string
    */
   protected $galleryEditImageDesc = '';

   /**
    * Metoda dodana na potrzeby akcji galleryEdit - ustawia nazwę zdjęcia
    * 
    * @param string $v Nazwa zdjęcia
    */
   public function setGalleryEditImageName($v)
   {
      $this->galleryEditImageName = $v;
   }

   /**
    * Metoda dodana na potrzeby akcji galleryEdit - zwraca nazwę zdjęcia
    * 
    * @return string Nazwa zdjęcia
    */
   public function getGalleryEditImageName()
   {
      if (empty($this->galleryEditImageName))
      {
         $asset = $this->getsfAsset();

         if ($asset)
         {
            $this->galleryEditImageName = $asset->getFilename(true);
         }
      }

      return $this->galleryEditImageName;
   }

   /**
    * Metoda dodana na potrzeby akcji galleryEdit - ustawia opis dla zdjęcia
    * 
    * @return string Nazwa zdjęcia
    */
   public function setGalleryEditImageDesc($v)
   {
      $this->galleryEditImageDesc = $v;
   }

   /**
    * Metoda dodana na potrzeby akcji galleryEdit - zwraca opis dla zdjęcia
    * 
    * @return string Opis zdjęcia
    */
   public function getGalleryEditImageDesc()
   {
      if (empty($this->galleryEditImageDesc))
      {
         $asset = $this->getsfAsset();

         if ($asset)
         {
            $this->galleryEditImageDesc = $asset->getDescription();
         }
      }

      return $this->galleryEditImageDesc;
   }

   /**
    * Metoda dodana na potrzeby akcji galleryEdit - ustawia zdjęcie domyślne (główne)
    * 
    * @param bool $v
    */
   public function setGalleryEditIsDefault($v)
   {
      $this->setIsDefault($v);
   }

   /**
    * Dodaje lub zastępuje plik produktu
    *
    * @param string $filename Nazwa pliku jaka zostanie nadana po dodaniu
    * @param string $source_file Pełna ścieżka do dodawanego pliku
    * @param string $in depreacted
    * @param string $custom_filename Nazwa własna dla załączanego pliku
    * @param string $description Opis zdjęcia      
    * 
    * @return sfAsset Utworzony plik
    */
   public function createAsset($filename, $source_file, $in = ProductHasSfAssetPeer::FILE_FOLDER, $custom_filename = null, $description = null, $check_duplicate = true, $move = true)
   {
      $product = $this->getProduct();

      if ($custom_filename && !empty($custom_filename))
      {
         $filename = $custom_filename.'.'.sfAssetsLibraryTools::getFileExtension($filename);
      }

      if (is_null($product))
      {
         throw new sfException('Brak przypisanego produktu...');
      }

      $asset = $this->getsfAsset();

      if (!$asset)
      {
         $asset = new sfAsset();
      }
      else
      {
         $asset->destroy();
      }

      $folder = sfAssetFolderPeer::retrieveByPath('media/products/'.$product->getAssetFolder().'/images');

      if (!$folder)
      {
         $folder = sfAssetFolderPeer::createFromPath('media/products/'.$product->getAssetFolder().'/images');
      }

      $asset->setsfAssetFolder($folder);

      $asset->setDescription($description);

      $asset->setFilename($filename);

      $asset->create($source_file, 'product', $move, $check_duplicate);

      $this->setsfAsset($asset);

      return $asset;
   }

   /**
    * Zmienia nazwę pliku przypisanego do produktu
    *
    * @param string $custom_filename Nowa nazwa dla pliku
    * 
    * @return sfAsset Zwraca plik ze zmieniona nazwą
    */
   public function renameAsset($custom_filename)
   {
      $asset = $this->getsfAsset();

      $ext = sfAssetsLibraryTools::getFileExtension($asset->getFilename());

      if ($asset->getFilename(true) != $custom_filename)
      {
         $custom_filename = $custom_filename.'.'.$ext;

         $asset->move($asset->getsfAssetFolder(), $custom_filename, 'product');
      }

      return $asset;
   }

   public function save($con = null)
   {
      if ($this->isColumnModified(ProductHasSfAssetPeer::IS_DEFAULT) && $this->getIsDefault() || $this->isNew() && null === $this->getProduct()->getOptImage() || !$this->productHasImages())
      {
         $c = new Criteria();

         $c->add(ProductHasSfAssetPeer::PRODUCT_ID, $this->getProductId());

         $u = new Criteria();

         $u->add(ProductHasSfAssetPeer::IS_DEFAULT, false);

         BasePeer::doUpdate($c, $u, Propel::getConnection());   

         $this->setIsDefault(true);     

         $this->getProduct()->setOptImage($this->getsfAsset()->getRelativePath());
      }

      return parent::save($con);
   }

   /**
    * Zmienia opis pliku przypisanego do produktu
    *
    * @param string $desc Opis
    *
    * @return sfAsset Zwraca plik ze zmienionym opisem
    */
   public function setAssetDescription($desc)
   {
      $asset = $this->getsfAsset();

      if ($asset)
      {
         $asset->setDescription($desc);
      }

      return $asset;
   }
   
   protected function productHasImages()
   {
      $c = new Criteria();
      $c->add(ProductHasSfAssetPeer::PRODUCT_ID, $this->getProductId());
      return ProductHasSfAssetPeer::doCount($c) > 0;
   }

}
