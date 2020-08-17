<?php
/**
 * SOTESHOP/stOkazjePlugin
 *
 * Ten plik należy do aplikacji stOkazjePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOkazjePlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stOkazje.class.php 12554 2011-04-27 08:30:56Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stOkazje
 *
 * @package     stOkazjePlugin
 * @subpackage  libs
 */
class stOkazje extends stPriceCompareGenerateFile implements stPriceCompareGenerateFileInterface
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
		$content.= xml_open_tag('okazje');
		$content.= xml_open_tag('offers');
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
				$productContent = xml_tag('id', $parsedProduct->getId());
				$productContent.= xml_cdata_tag('name', $parsedProduct->getName());
				$productContent.= xml_cdata_tag('description', $parsedProduct->getDescription());
				$productContent.= xml_cdata_tag('category', $parsedProduct->getCategory());
				$productContent.= xml_tag('price', $parsedProduct->getPrice());
				$productContent.= xml_tag('url', $parsedProduct->getUrl());
				if ($parsedProduct->hasProducer()) $productContent.= xml_cdata_tag('producer', $parsedProduct->getProducer());
				$productContent.= xml_tag('image', $parsedProduct->getPhoto());
				
				if ($this->getConfig('use_product_code') == true)
				{
					$productContent.= xml_tag('attribute', $parsedProduct->getCode(), array('name' => 'code'));
				}
				
				$productContent.= xml_tag('availability', $parsedProduct->getPriceCompareAvailability($this, 0));

				$content.= xml_tag('offer', $productContent);
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
		$content = xml_close_tag('offers');
		$content.= xml_close_tag('okazje');
		return $content;
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
	 * Pobieranie informacji o statusach dostępności Okazje.info
	 *
	 * @return array
	 */
	static public function getOkazjeAvailabilities()
	{
		return array(0 => __('sprawdź dostępność w sklepie'), 1 => __('produkt dostępny'), 3 => __('produkt dostępny do 3 dni'), 7 => __('produkt dostępny do 7 dni'), 14 => __('produkt dostępny nie wcześniej niż za tydzień'));
	}
}