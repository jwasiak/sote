<?php

/**
 * Subclass for performing query and update operations on the 'st_product_has_sf_asset' table.
 *
 * 
 *
 * @package lib.model
 */
class ProductHasSfAssetPeer extends BaseProductHasSfAssetPeer
{
    const IMAGE_FOLDER = 'images';
    
    const FILE_FOLDER = 'files';
    
    /**
     * Dodaje plik do produktu
     *
     * @param string $filename Nazwa pliku jaka zostanie nadana po dodaniu
     * @param string $source_file Pełna ścieżka do dodawanego pliku
     * @param Product $product Produkt
     * 
     * @return sfAsset Utworzony plik
     */
    public static function createAsset($filename, $source_file, $product)
    {
        $product_has_asset = new ProductHasSfAsset();
    	
        $product_has_asset->setProduct($product);
        
        $asset = $product_has_asset->createAsset($filename, $source_file);
        
        $product_has_asset->save();
        
        return $asset;
    }
    
    /**
     * Pobiera domyślne zdjęcie produktu
     * 
     * @param int $product_id Id produktu
     * @param const $from Katalog 
     */  
    public static function retrieveDefaultByProductId($product_id)
    {
        $c = new Criteria();
         
        $c->addJoin(sfAssetPeer::FOLDER_ID, sfAssetFolderPeer::ID);
        
        $c->add(ProductHasSfAssetPeer::PRODUCT_ID, $product_id);
        
        $c->add(ProductHasSfAssetPeer::IS_DEFAULT, true);
        
        $c->setLimit(1);
        
        $product_has_asset = self::doSelectJoinsfAsset($c);
        
        return isset($product_has_asset[0]) ? $product_has_asset[0] : null;         
    }

    /**
     * Pobiera wszystkie zdjęcia dla danego produktu
     * 
     * @param int $product_id Id produktu
     * @param bool $without_default Wszystkie zdjęcia bez domyślnego
     * @param const $from Katalog 
     */
    public static function doSelectImages($product_id, $without_default = false)
    {
        $c = new Criteria();
         
        $c->addJoin(ProductHasSfAssetPeer::SF_ASSET_ID, sfAssetPeer::ID);
                
        $c->add(ProductHasSfAssetPeer::PRODUCT_ID, $product_id);

        $c->addAscendingOrderByColumn(ProductHasSfAssetPeer::ID);
        
        if ($without_default)
        {
            $c->add(ProductHasSfAssetPeer::IS_DEFAULT, false);
        }
        
        return sfAssetPeer::doSelectJoinsfAssetFolder($c); 	 
    }
}
