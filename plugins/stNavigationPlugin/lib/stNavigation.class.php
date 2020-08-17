<?php
/**
 * SOTESHOP/stNavigationPlugin
 *
 * Ten plik należy do aplikacji stNavigationPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package stNavigationPlugin
 * @subpackage libs
 * @copyright SOTE (www.sote.pl)
 * @license http://www.sote.pl/license/sote (Professional License SOTE)
 * @version $Id: stNavigation.class.php 17313 2012-03-01 14:06:53Z michal $
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stNavigation
 *
 * @package stNavigationPlugin
 * @subpackage libs
 */
class stNavigation
{
	/**
	 * namespace stNavigation
	 */
	const SESSION_NAMESPACE = 'soteshop/navigation';

	/**
	 * Instanacja obiektu stNavigation
	 * @var stNavigation
	 */
	protected static $instance = null;

	/**
	 * Obiekt sfContext
	 * @var Context
	 */
	private $context;

	/**
	 * Tablica ze ścieżką
	 * @var array
	 */
	private $navigationPath = array();

	/**
	 * Tablica ostatnio przeglądanych produktów
	 * @var array
	 */
	private $lastViewedProducts = array();

	/**
	 * Konfiguracja modułu
	 * @var object
	 */
	private $config = null;

	/**
	 * Informacja o zapisaniu historii produktów do bazy
	 * @var bool
	 */
	private $isLastViewedProductsSaved = false;

	/**
	 * Publiczny konstruktor
	 *
	 */
	public function __construct()
	{
		$this->config = stConfig::getInstance(sfContext::getInstance(), 'stNavigationBackend');
	}

	/**
	 * Incjalizacja klasy stNavigation
	 *
	 * @param string $context
	 */
	public function initialize($context)
	{
		$this->context = $context;
		$this->lastViewedProducts = $this->context->getUser()->getAttribute('lastViewedProducts', array(), self::SESSION_NAMESPACE);
		$this->isLastViewedProductsSaved = $this->context->getUser()->getAttribute('isLastViewedProductsSaved', false, self::SESSION_NAMESPACE);
	}

	/**
	 * Zwraca instancje obiektu
	 *
	 * @param string $context
	 * @return stNavigation
	 */
	public static function getInstance($context)
	{
		if (!isset(self::$instance))
		{
			$class = __CLASS__;
			self::$instance = new $class();
			self::$instance->initialize($context);
		}
		return self::$instance;
	}

	/**
	 * Dodawanie elementu do ścieżki
	 *
	 * @param $name string nazwa elementu
	 * @param $link string link
	 * @param $active bool aktywny/nieaktywny link
	 * @return stNavigation
	 */
	public function addNavigationPathElement($name, $link, $bold = false)
	{
		$active = true;
		if ($link == false || $link == null || empty($link)) $active = false;
		$this->navigationPath[] = array('name' => $name, 'link' => $link, 'active' => $active, 'title' => $name, 'bold' => $bold);
		return $this;
	}

	/**
	 * Usuwanie elementu ze ścieżki
	 *
	 * @param $name string nazwa elemnetu
	 */
	public function deleteNavigationPathElement($name)
	{
		if (is_array($this->navigationPath))
		{
			foreach ($this->navigationPath as $key => $path)
			{
				if ($name == $path['name'])
				{
					$keyToUnset = $key;
					break;
				}
			}
			unset($this->navigationPath[$keyToUnset]);
		}
	}

	/**
	 * Usuwanie wszystkich elementów ze ścieżki
	 */
	public function clearNavigationPath()
	{
		$this->navigationPath = array();
	}

	/**
	 * Pobieranie ścieżki
	 *
	 * @return array ścieżka
	 */
	public function getNavigationPath()
	{
		$navigationPath = $this->navigationPath;
		if ($this->getConfig('decrease') == 1)
		{
			$last = end($this->navigationPath);
			foreach($this->navigationPath as $key => $path)
			{
				if($path != $last || ($path == $last && $this->getConfig('decrease_last') == 1))
				{
				    if (mb_strlen($path['name'], 'UTF-8') > $this->getConfig('decrease_length')) $navigationPath[$key]['name'] = mb_substr($path['name'], 0, $this->getConfig('decrease_length'), 'UTF-8').'..';
				    else $navigationPath[$key]['name'] = $path['name'];
				}
			}
		}
		return $navigationPath;
	}

	/**
	 * Dodawanie produktu do ścieżki 
	 *
	 * @param $product object Product obiekt produktu
	 */
	public function addProduct(Product $product)
	{
		$categoryConfig = stConfig::getInstance('stCategory');
			
        $category = $this->context->getUser()->getParameter('selected', null, 'soteshop/stCategory');

        if (!$category && stProducer::getSelectedProducer())
        {
        	$this->addProducer(stProducer::getSelectedProducer(), false);
		}

		if ($category)
		{
			$this->addCategory($category, false);
		}

		$urlParams = array(
			'module' => 'stProduct',
			'action' => 'show',
			'url' => $product->getFriendlyUrl()
		);

		if ($this->context->getRequest()->hasParameter('producer'))
		{
			$urlParams['producer'] = $this->context->getRequest()->getParameter('producer');
		}

		$this->addNavigationPathElement($product->getName(), $urlParams, true);	
	}

	/**
	 * Dodawanie kategorii do ścieżki 
	 *
	 * @param $category object Category obiekt kategorii
	 */
	public function addCategory(Category $category, $bold = true)
	{
		$categoryConfig = stConfig::getInstance(sfContext::getInstance(), 'stCategory');

        $c = new Criteria();

		$c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

		$c->add(CategoryPeer::IS_ACTIVE, true);

		$category_no = CategoryPeer::doCount($c);

        if (stProducer::getSelectedProducer())
        {
        	$this->addProducer(stProducer::getSelectedProducer(), false);
		}	
		
		$urlParams = array(
			'module' => 'stProduct',
			'action' => 'list',
		);

		if ($this->context->getRequest()->hasParameter('producer'))
		{
			$urlParams['producer'] = $this->context->getRequest()->getParameter('producer');
		}

		foreach ($category->getPath() as $cat)
		{
			if (($category_no > 1 && !($categoryConfig->get('hide_root') == 1  && $cat->getLft() == 1)) || ($category_no == 1 && $cat->getLft() != 1))
			{
				$urlParams['url'] = $cat->getFriendlyUrl();
				$this->addNavigationPathElement($cat->getName(), $urlParams);
			}
		}

		$urlParams['url'] = $category->getFriendlyUrl();

		$this->addNavigationPathElement($category->getName(), $urlParams, $bold);
	}

	public function addProducer(Producer $producer, $bold = true)
	{
		$this->addNavigationPathElement($producer->getName(), 'stProduct/producerList?url='.$producer->getFriendlyUrl(), $bold);
	}

	public function addGroup(ProductGroup $product_group, $bold = true)
	{
		$this->addNavigationPathElement($product_group->getName(), 'stProduct/groupList?url='.$product_group->getFriendlyUrl(), $bold);
	}

	/**
	 * Dodanie ostatnio oglądanego produktu do listy 
	 *
	 * @param $product object Product obiekt produktu
	 */
	public function addLastViewedProduct(Product $product)
	{
		$removeProduct = false;
		foreach ($this->lastViewedProducts as $key => $lastViewedProduct)
		{
			if ($product->getId() == $lastViewedProduct['id'])
			{
				$removeProduct = $key;
				break;
			}
		}

		if ($removeProduct !== false) unset($this->lastViewedProducts[$removeProduct]);

		if (count($this->lastViewedProducts) == $this->getConfig('history_products')) array_shift($this->lastViewedProducts);
		$this->lastViewedProducts[] = array('id' => $product->getId(), 'name' => $product->getName(), 'link' => 'stProduct/show?url='.$product->getFriendlyUrl());

		$i = 0;
		$products = array();
		foreach($this->lastViewedProducts as $product)
		{
			$products[$i] = $product;
			$i++;
		}
		$this->lastViewedProducts = $products;

		$this->context->getUser()->setAttribute('lastViewedProducts', $this->lastViewedProducts, self::SESSION_NAMESPACE);
	}

	/**
	 * Pobieranie listy ostatnio oglądanych produktów
	 *
	 * @return array lista ostatnio oglądanych produktów
	 */
	public function getLastViewedProducts()
	{
		if ($this->context->getUser()->isAuthenticated())
		{
			if ($this->isLastViewedProductsSaved == false)
			{
				$sfGuardUser = $this->context->getUser()->getGuardUser();

				$c = new Criteria();
				$c->add(GuardUserHasNavigationPeer::SF_GUARD_USER_ID, $sfGuardUser->getId());
				$guardUserHasNavigation = GuardUserHasNavigationPeer::doSelectOne($c);

				if (is_object($guardUserHasNavigation))
				{
					$lastViewedProducts = unserialize(preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $guardUserHasNavigation->getProducts()));

					/**
					 * Sprawdzanie czy produktu są aktywne
					 */
					$lastViewedProductsIds = array();
					foreach ($lastViewedProducts as $lastViewedProduct) $lastViewedProductsIds[] = $lastViewedProduct['id'];

					$c = new Criteria();
					$c->add(ProductPeer::ID, $lastViewedProductsIds, Criteria::IN);
					$products = ProductPeer::doSelect($c);

					$NewlastViewedProducts = array();
					foreach ($products as $product)
					{
						if ($product->getActive())
						{
							foreach ($lastViewedProducts as $lastViewedProduct)
							{
								if ($product->getId() == $lastViewedProduct['id'])
								{
									$NewlastViewedProducts[] = $lastViewedProduct;
									break;
								}
							}
						}
					}

					/**
					 * Megowanie tablicy z sesji i bazy danych
					 */
					$allLastViewedProducts = array_merge($NewlastViewedProducts, $this->lastViewedProducts);
					$allLastViewedProducts = array_reverse($allLastViewedProducts);
					$allLastViewedProductsUnique = array();
					foreach ($allLastViewedProducts as $lastViewedProduct)
					{
						if (!in_array($lastViewedProduct, $allLastViewedProductsUnique))
						{
							$allLastViewedProductsUnique[] = $lastViewedProduct;
						}
					}
					$allLastViewedProducts = array_splice($allLastViewedProductsUnique,0,$this->getConfig('history_products'));
					$allLastViewedProducts = array_reverse($allLastViewedProducts);

					/**
					 * Zapisywanie danych do sesji
					 */
					$this->isLastViewedProductsSaved = true;
					$this->context->getUser()->setAttribute('isLastViewedProductsSaved', $this->isLastViewedProductsSaved, self::SESSION_NAMESPACE);

					$this->context->getUser()->setAttribute('lastViewedProducts', $allLastViewedProducts, self::SESSION_NAMESPACE);
					return $allLastViewedProducts;
				} else {
					$this->isLastViewedProductsSaved = true;
					$this->context->getUser()->setAttribute('isLastViewedProductsSaved', $this->isLastViewedProductsSaved, self::SESSION_NAMESPACE);
				}
			}
		}
		return $this->lastViewedProducts;
	}

	/**
	 * Pobieranie ostatnio oglądanego produktu
	 *
	 * @return mixed array/bool array - informacja o produkcie/false - brak produktu
	 */
	public function getLastViewedProduct()
	{
		$lastViewedProducts = $this->getLastViewedProducts();
                
                $avail_config = stConfig::getInstance(sfContext::getInstance(), 'stAvailabilityBackend');
                
		$count = count($lastViewedProducts)-1;
		if ($this->context->getModuleName() =='stProduct' && $this->context->getActionName() == 'show') $count = count($lastViewedProducts)-2;
		if ($count >= 0 && isset($lastViewedProducts[$count]))
		{
                        
			$product = ProductPeer::retrieveByPK($lastViewedProducts[$count]['id']);
                        
			if (!is_object($product) || $product->getActive() == 0 || $avail_config->get('hide_products_avail_on'))
			{
				unset($lastViewedProducts[$count]);
				$this->context->getUser()->setAttribute('lastViewedProducts', $lastViewedProducts, self::SESSION_NAMESPACE);
				$this->lastViewedProducts = $this->context->getUser()->getAttribute('lastViewedProducts', array(), self::SESSION_NAMESPACE);
				return $this->getLastViewedProduct();
			}
			$lastViewedProducts[$count]['name'] = $product->getName();
			return $lastViewedProducts[$count];
		}
		return false;
	}

	/**
	 * Pobieranie danych z konfiguracji
	 *
	 * @param $name string nazwa pola z konfiguracji
	 * @return mixed wartość pola z konfiguracji
	 */
	public function getConfig($name, $i18n = false)
	{
	    if ($i18n == true) return $this->config->get($name, null, true);
		return $this->config->get($name);
	}

	/**
	 * Zapisywanie listy przeglądanych produktów do bazy danych
	 */
	public function saveLastViewedProducts()
	{
		if ($this->context->getUser()->isAuthenticated())
		{
			$sfGuardUser = $this->context->getUser()->getGuardUser();

			$c = new Criteria();
			$c->add(GuardUserHasNavigationPeer::SF_GUARD_USER_ID, $sfGuardUser->getId());
			$guardUserHasNavigation = GuardUserHasNavigationPeer::doSelectOne($c);

			if (is_object($guardUserHasNavigation))
			{
				if (serialize($this->lastViewedProducts) != $guardUserHasNavigation->getProducts())
				{
					$guardUserHasNavigation->setProducts(serialize($this->lastViewedProducts));
					$guardUserHasNavigation->save();
				}
			} else {
				$guardUserHasNavigation = new GuardUserHasNavigation();
				$guardUserHasNavigation->setSfGuardUserId($sfGuardUser->getId());
				$guardUserHasNavigation->setProducts(serialize($this->lastViewedProducts));
				$guardUserHasNavigation->save();
			}
		}
	}
}