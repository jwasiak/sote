<?php
/**
 * SOTESHOP/stCeneoPlugin
 *
 * Ten plik należy do aplikacji stCeneoPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCeneoPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stCeneo.class.php 16419 2011-12-08 13:05:55Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stCeneo
 *
 * @package     stCeneoPlugin
 * @subpackage  libs
 */
class stCeneo extends stPriceCompareGenerateFile implements stPriceCompareGenerateFileInterface
{
    /**
     * Konstruktor
     */
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }

    /**
     * Generowanie nagłówka pliku
     *
     * @return string
     */
    protected function getFileHead()
    {
        $content = xml_open_tag('?xml version="1.0" encoding="UTF-8"?');
        $content.= xml_open_tag('offers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="1"');
        return $content;
    }

    /**
     * Generowanie zawartości pliku
     *
     * @param $step integer numer kroku
     * @return string
     */
    protected function getFileBody($step)
    {
        $priceCompareProducts = $this->getProducts($step);

        $content = "";
        foreach ($priceCompareProducts as $priceCompareProduct)
        {
            $parsedProduct = new stPriceCompareProductParser($priceCompareProduct->getProduct());

            if ($parsedProduct->checkProduct())
            {
                $this->product = $priceCompareProduct->getProduct();
                $this->price = $parsedProduct->getPrice();
                stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stCeneoPlugin.stCeneoChangePrice', array()));

                $productContent = xml_cdata_tag('cat', $parsedProduct->getCategory());
                $productContent.= xml_cdata_tag('name', $parsedProduct->getName());
                $productContent.= xml_tag('imgs', xml_tag('main', null, array('url' => $parsedProduct->getPhoto())));

                if ($this->getConfig('description_type') == 'full') $productContent.= xml_cdata_tag('desc', $parsedProduct->getDescription());
                elseif ($this->getConfig('description_type') == 'short') $productContent.= xml_cdata_tag('desc', $parsedProduct->getShortDescription());

                $attributeContent = '';
                if ($parsedProduct->hasProducer())
                {
                    $attributeContent.= xml_cdata_tag('a', $parsedProduct->getProducer(true), array('name' => 'Producent'));
                }

                if ($this->getConfig('use_product_code') == true)
                    $attributeContent.= xml_cdata_tag('a', $parsedProduct->getCode(), array('name' => 'Kod_producenta'));
                elseif($this->getConfig('use_man_code') == true)
                    $attributeContent.= xml_cdata_tag('a', $parsedProduct->getManCode(), array('name' => 'Kod_producenta'));

                if ($this->getConfig('use_ean_code') == true)
                {
                    $attributeContent.= xml_cdata_tag('a', $parsedProduct->getManCode(), array('name' => 'EAN'));
                }
                if ($this->getConfig('use_isbn_code') == true)
                {
                	$attributeContent.= xml_cdata_tag('a', $parsedProduct->getManCode(), array('name' => 'ISBN'));
                }
                if ($this->getConfig('use_attribute') == true)
                {
                                             
                    $variants = appProductAttributeVariantPeer::doSelectArrayWithAttribyteByProduct($priceCompareProduct->getProduct(), 'pl_PL');
                    $attributes = appProductAttributePeer::doSelectArrayByProduct($priceCompareProduct->getProduct(), 'pl_PL');                
                    
                    if($attributes){ 
                      
                        foreach ($attributes as $id => $attribute) {                                                    
                            
                            $variantss = "";            
                            $elements = count($variants[$id]);            
                            $i = 1;
                            
                            foreach ($variants[$id] as $variant)
                            {                            
                                $variantss .= $variant['value'];                                                        
                                
                                if($elements>1){
                                    if($elements!=$i){
                                        $variantss .= ", ";
                                    }                                                                                                                                                                               
                                }
                                                            
                                $i++;                 
                            }                                                
                            
                            if ($attribute['type'] == 'C' ){
                                 
                                $color_wariants = "";            
                                $color_elements = count($variants[$id]);            
                                $d = 1;

                                foreach ($variants[$id] as $variant){
                                
                                    $color_wariants .= $variant['name'];                                                        
                                    
                                    if($color_elements>1){
                                        if($color_elements!=$d){
                                            $color_wariants .= "/";
                                        }                                                                     
                                    }                                   
                                    $d++; 
                                }
                                if($color_wariants){
                                $attributeContent.= xml_cdata_tag('a', $color_wariants, array('name' => $attribute['name']));
                                }

                            }


                            if ($attribute[type] == 'B' ){
                                
                                if(isset($variants[$id]) && !empty($variants[$id])){
                                    $variantss = "Tak";
                                }else{
                                    $variantss = "Nie";
                                }                            
                            }    
                            
                            if ($attribute[type] != 'C' ){                        
                                $attributeContent.= xml_cdata_tag('a', $variantss, array('name' => $attribute[name]));                                                        
                            }                                                                     
                             
                                
                        }
                   
                    } 

                }   
                
                
                $attributeContent = stEventDispatcher::getInstance()->filter(new sfEvent($this, 'stCeneoPlugin.stCeneoAttributesContent', array('product' => $this->product)), $attributeContent)->getReturnValue();

                $productContent.= xml_tag('attrs', $attributeContent);

                $oParameters = array();
                $oParameters['id'] = $parsedProduct->getId();
                $oParameters['url'] = $parsedProduct->getUrl();
                $oParameters['price'] = $this->price;
                $avail = $parsedProduct->getPriceCompareAvailability($this, 99);
                $oParameters['avail'] = ($avail == 0)? 99 : $avail;
                if ($parsedProduct->hasWeight()) $oParameters['weight'] = $parsedProduct->getWeight();
                if ($this->getConfig('use_stock') && $parsedProduct->hasStock() && $parsedProduct->getStock() >= 0) $oParameters['stock'] = floor($parsedProduct->getStock());

                $content.= xml_tag('o', $productContent, $oParameters);
            }
            unset($parsedProduct);
        }
        return $content;
    }

    /**
     * Generowanie stopki pliku
     *
     * @return string
     */
    protected function getFileFoot()
    {
        return xml_close_tag('offers');
    }

    /**
     * Pobieranie infromacji o porównywarce podczas eksportu
     *
     * @param $object object
     * @return integer
     */
    static public function getProduct($object = null)
    {
        return stPriceCompareGenerateFile::getProductForExport(__CLASS__, $object);
    }

    /**
     * Ustawianie infromacji o porównywarce podczas importu
     *
     * @param $object object
     * @param $value integer
     * @return boolean
     */
    static public function setProduct($object = null, $active = 0)
    {
        return stPriceCompareGenerateFile::setProductForImport(__CLASS__, $object, $active);
    }

    /**
     * Pobieranie informacji o statusach dostępności Ceneo
     *
     * @return array
     */
    static public function getCeneoAvailabilities()
    {
        return array(1 => __('produkt dostępny'), 3 => __('produkt dostępny do trzech dni'), 7 => __("produkt dostępny do tygodnia"), 14 => __("produkt dostępny powyżej tygodnia"), 99 => __('sprawdź dostępność w sklepie'));
    }
}