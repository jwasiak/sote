<?php
/**
 * SOTESHOP/stNokautPlugin
 *
 * Ten plik należy do aplikacji stNokautPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stNokautPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stNokaut.class.php 6125 2010-07-07 11:35:39Z pawel $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stNokaut
 *
 * @package     stNokautPlugin
 * @subpackage  libs
 */
class stNokaut extends stPriceCompareGenerateFile implements stPriceCompareGenerateFileInterface
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
		$content.= xml_open_tag('!DOCTYPE nokaut SYSTEM "http://www.nokaut.pl/integracja/nokaut.dtd"');
		$content.= xml_open_tag('nokaut');
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
				$this->product = $priceCompareProduct->getProduct();
				$this->price = $parsedProduct->getPrice();
				stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stNokautPlugin.stNokautChangePrice', array()));

				$productContent = xml_tag('id', $parsedProduct->getId());
				$productContent.= xml_cdata_tag('name', $parsedProduct->getName());
				$productContent.= xml_cdata_tag('description', $parsedProduct->getDescription());
				$productContent.= xml_tag('url', $parsedProduct->getUrl());
				$productContent.= xml_tag('image', $parsedProduct->getPhoto());
				$productContent.= xml_tag('price', $this->price);
				$productContent.= xml_cdata_tag('category', $parsedProduct->getCategory());
				if ($parsedProduct->hasProducer()) $productContent.= xml_cdata_tag('producer', $parsedProduct->getProducer());

				if ($this->getConfig('use_product_code') == true)
				{
					$productContent.= xml_tag('property',$parsedProduct->getCode(), array('name' => 'producer code'));
				}

				$productContent.= xml_tag('availability', $parsedProduct->getPriceCompareAvailability($this, 4));

				$content.= price_compare_xml_tag('offer', $productContent);
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
		$content.= xml_close_tag('nokaut');
		return $content;
	}

	/**
	 * Pobieranie infromacji o porównywarce podczas eksportu
	 *
	 * @param object $object
	 * @return integer
	 */
	static public function getProduct($object = null)
	{
		return stPriceCompareGenerateFile::getProductForExport(__CLASS__, $object);
	}

	/**
	 * Ustawianie infromacji o porównywarce podczas importu
	 *
	 * @param object $object
	 * @param integer $value
	 * @return boolean
	 */
	static public function setProduct($object = null, $active = 0)
	{
		return stPriceCompareGenerateFile::setProductForImport(__CLASS__, $object, $active);
	}

	/**
	 * Pobieranie informacji o statusach dostępności Nokaut
	 *
	 * @return array
	 */
	static public function getNokautAvailabilities()
	{
		return array(4 => __('sprawdź dostępność w sklepie'), 0 => __('produkt dostępny od ręki'), 1 => __('produkt dostępny do tygodnia'), 2 => __('produkt dostępny powyżej tygodnia'), 3 => __('produkt na życzenie'));
	}
}