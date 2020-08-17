<?php
/**
 * SOTESHOP/stPriceCompare
 *
 * Ten plik należy do aplikacji stPriceCompare opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPriceCompare
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPriceCompareGenerateFile.class.php 12590 2011-04-29 12:46:07Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPriceCompareGenerateFile
 *
 * @package    stPriceCompare
 * @subpackage libs
 */
abstract class stPriceCompareGenerateFile
{
	/**
	 * Ilość rekordów przetwarzanych na jeden ra
	 *
	 * @var integer
	 */
	protected $productsByStep = 100;

	/**
	 * Instancja obiektu sfContext
	 *
	 * @var sfContext
	 */
	protected $context;

	/**
	 * Nazwa porównywarki cen
	 *
	 * @var unknown_type
	 */
	protected $priceCompareName = '';

	/**
	 * Nazwa pliku wynikowego
	 *
	 * @var string
	 */
	protected $fileName = '';

	/**
	 * Ścieżka do pliku wynikowego
	 *
	 * @var string
	 */
	protected $filePath;

	/**
	 * Konfiguracja stPriceCompare
	 *
	 * @var stConfig
	 */
	protected $priceCompareConfig;

	protected $count = null;

	/**
	 * Kostruktor
	 *
	 * @param $priceCompareName string nazwa porównywarki cen
	 */
	public function __construct($priceCompareName)
	{
		$this->priceCompareName = self::getModelName($priceCompareName);

		$this->fileName = strtolower($this->priceCompareName).'.xml';

		$this->context = sfContext::getInstance();
		sfLoader::loadHelpers(array('Helper','stPriceCompare', 'stPartial', 'Partial', 'stProductImage'), $this->context->getModuleName());
		$this->filePath = sfConfig::get('sf_web_dir').'/uploads/'.$this->fileName;

		$this->priceCompareConfig = stConfig::getInstance($this->context, 'stPriceCompare');

		$this->context->getRequest()->setHostByCulture(stLanguage::getOptLanguage());

        stPluginHelper::addRouting('stProductUrlLangFrontend', '/:lang/:url.html', 'stProduct', 'show', null, array(), array('lang' => '[a-z]{2,2}'));
        stPluginHelper::addRouting('stProductUrlFrontend', '/:url.html', 'stProduct', 'show', null);
        stPluginHelper::addRouting('frontend_homepage_lang', '/:lang', 'stFrontendMain', 'index', null, array(), array('lang' => '[a-z]{2,2}'));
        stPluginHelper::addRouting('frontend_homepage', '/', 'stFrontendMain', 'index');

        sfLoader::loadHelpers(array('Helper', 'stUrl'));
	}

	/**
	 * Zwracac adresu produktu dla danej wersji językowej
	 *
	 * @param Product $product
	 * @param string $language
	 * @return void
	 */
	public function getProductUrl(Product $product, $language = null)
	{
		return st_url_for(array('module' => 'stProduct', 'action' => 'show', 'url' => $product->getFriendlyUrl()), true, 'frontend', null, $language);
	}

	/**
	 * Zwraca adresu strony głównej dla danej wersji językowej
	 *
	 * @param string $language
	 * @return void
	 */
	public function getHomepageUrl($language = null)
	{
		return st_url_for(array('module' => 'stFrontendMain', 'action' => 'index'), true, 'frontend', null, $language);
	}

	/**
	 * Zapisywanie nagłówka pliku
	 */
	public function init()
	{
		if (file_exists($this->filePath)) unlink($this->filePath);

		$fh = fopen($this->filePath,"a+");
		fwrite($fh, $this->getFileHead());
		fclose($fh);
	}

	/**
	 * Zapisywanie zawartości pliku
	 *
	 * @param $step integer numer kroku
	 * @return integer numer kolejnego kroku
	 */
	public function generate($step)
	{
		$fh = fopen($this->filePath,"a+");
		fwrite($fh, $this->getFileBody($step));
		fclose($fh);
		return $step+1;
	}

	/**
	 * Zapisywanie stopki pliku
	 */
	public function close()
	{
		$fh = fopen($this->filePath,"a+");
		fwrite($fh, $this->getFileFoot());
		fclose($fh);

		$this->context->getUser()->setAttribute('stProgressBar-st'.$this->priceCompareName.'GenerateXml', st_get_partial('st'.$this->priceCompareName.'Backend/get_file'), 'symfony/flash');
	}

	/**
	 * Pobieranie ilości kroków
	 *
	 * @return integer ilość kroków  
	 */
	public function getStepsCount()
	{
		$peerClass = $this->priceCompareName.'Peer';
		$c = new Criteria();
		$c->add(constant($peerClass.'::ACTIVE'), 1);
		$c->add(ProductPeer::ACTIVE, 1);
		$c->add(ProductPeer::IS_GIFT, 0);
		$c2 = $c->getNewCriterion(ProductPeer::HIDE_PRICE, null, Criteria::ISNULL);
		$c3 = $c->getNewCriterion(ProductPeer::HIDE_PRICE, 0);
		$c2->addOr($c3);
		$c->add($c2);
		if ($this->priceCompareConfig->get('stock'))
		{
			$c4 = $c->getNewCriterion(ProductPeer::STOCK, null, Criteria::ISNULL);
			$c5 = $c->getNewCriterion(ProductPeer::STOCK, 0, Criteria::GREATER_THAN);
			$c4->addOr($c5);
			$c->add($c4);
		}
		$this->count = call_user_func($peerClass.'::doCountJoinAll', $c);
		return intval(ceil($this->count/$this->productsByStep));
	}

	public function getCount()
	{
		if (null === $this->count)
		{
			$this->getStepsCount();
		}

		return $this->count;
	}

	/**
	 * Pobieranie produktów dla danego kroku
	 *
	 * @param integer $step krok
	 * @return array
	 */
	protected function getProducts($step)
	{
		$peerClass = $this->priceCompareName.'Peer';
		$c = new Criteria();
		$c->add(constant($peerClass.'::ACTIVE'), 1);
		$c->add(ProductPeer::ACTIVE, 1);
		$c->add(ProductPeer::IS_GIFT, 0);
		$c2 = $c->getNewCriterion(ProductPeer::HIDE_PRICE, null, Criteria::ISNULL);
		$c3 = $c->getNewCriterion(ProductPeer::HIDE_PRICE, 0);
		$c2->addOr($c3);
		$c->add($c2);
		if ($this->priceCompareConfig->get('stock'))
		{
			$c4 = $c->getNewCriterion(ProductPeer::STOCK, null, Criteria::ISNULL);
			$c5 = $c->getNewCriterion(ProductPeer::STOCK, 0, Criteria::GREATER_THAN);
			$c4->addOr($c5);
			$c->add($c4);
		}
		$c->setOffset($this->productsByStep*$step);
		$c->setLimit($this->productsByStep);
		$c->addAscendingOrderByColumn(constant($peerClass.'::PRODUCT_ID'));
		return call_user_func($peerClass.'::doSelectJoinAll', $c);
	}

	/**
	 * Pobieranie infromacji o porównywarce podczas eksportu
	 *
	 * @param $object object
	 * @return integer
	 */
	static public function getProductForExport($priceCompareName, $object = null)
	{
		$peerClass = self::getModelName($priceCompareName).'Peer';

		$c = new Criteria();
		$c->add(constant($peerClass.'::PRODUCT_ID'), $object->getId());
		$c->add(constant($peerClass.'::ACTIVE'), 1);
		$priceCompareObject = call_user_func($peerClass.'::doSelectOne', $c);
		if (is_object($priceCompareObject)) return 1;
		return 0;
	}

	/**
	 * Ustawianie infromacji o porównywarce podczas importu
	 *
	 * @param $object object
	 * @param $value integer
	 * @return boolean
	 */
	static public function setProductForImport($priceCompareName, $object = null, $active = 0)
	{
		$class = self::getModelName($priceCompareName);
		$peerClass = $class.'Peer';

		$c = new Criteria();
		$c->add(constant($peerClass.'::PRODUCT_ID'), $object->getId());
		$priceCompareObject = call_user_func($peerClass.'::doSelectOne', $c);
		if (!is_object($priceCompareObject))
		{
			$priceCompareObject = new $class();
			$priceCompareObject->setProductId($object->getId());
		}
		if ($priceCompareObject->getActive() != $active) $priceCompareObject->setActive($active);
		$priceCompareObject->save();
		return true;
	}

	/**
	 * Generowanie nagłówka pliku
	 *
	 * @return string
	 */
	abstract protected function getFileHead();

	/**
	 * Generowanie zawartości pliku
	 *
	 * @param integer $step numer kroku
	 * @return string
	 */
	abstract protected function getFileBody($step);

	/**
	 * Generowanie stopki pliku
	 *
	 * @return string
	 */
	abstract protected function getFileFoot();

	/**
	 * Pobieranie zmiennej z konfiguracji
	 *
	 * @param $name nazwa zmiennej
	 * @return mixed
	 */
	public function getConfig($name)
	{
		if (file_exists(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'st'.$this->priceCompareName.'Backend.yml'))
		{
			$config = stConfig::getInstance($this->context, 'st'.$this->priceCompareName.'Backend');
			return $config->get($name, null);
		}
		return '';
	}

	/**
	 * Pobieranie adresu sklepu
	 *
	 * @return string
	 */
	protected function getShopUrl()
	{
	    if(stConfig::getInstance('stSecurityBackend')->get('ssl')=="shop"){
	        $http = "https"; 
	    } else {
	        $http = "http";
	    }
	    
		return $http.'://'.$this->context->getRequest()->getHost();
	}

	/**
	 * Pobieranie informacji o dostępności
	 *
	 * @return array
	 */
	static public function getAvailabilities()
	{
		return AvailabilityPeer::doSelect(new Criteria());
	}

	protected static function getModelName($name)
	{
		if (strpos($name, 'st') === 0) {
			$name = substr($name, 2);
		} 

		return ucfirst($name);
	}
}