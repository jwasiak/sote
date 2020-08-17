<?php
/**
 * SOTESHOP/stSearchPlugin
 *
 * Ten plik należy do aplikacji stSearchPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stSearchPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 16982 2012-02-07 11:41:26Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */

/**
 * Klasa stSearchFrontendComponents
 *
 * @package     stSearchPlugin
 * @subpackage  actions
 */
class stSearchFrontendComponents extends sfComponents
{
	/**
	 * Komponent searchBox
	 */
	public function executeSearchBox()
	{
		$this->smarty = new stSmarty('stSearchFrontend');

		$this->product_config = stConfig::getInstance(null, 'stProduct');
                
        $this->search_config = stConfig::getInstance(null, 'stSearchBackend');

        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stSearchFrontendComponents.postSearchBox'));
	}

	/**
	 * Komponent main_search_box
	 */
	public function executeMainSearchBox()
	{
		$this->smarty = new stSmarty('stSearchFrontend');
		$this->config = stConfig::getInstance($this->getContext(), 'stSearchBackend');
		 
		$this->producer_show = $this->config->get('producer_show');
		$this->category_show = $this->config->get('category_show');
		$this->category_depth = $this->config->get('category_depth');

		$this->selectProducerList = array($this->getContext()->getI18n()->__('Wybierz producenta'));
		 
		if ($this->producer_show)
		{
			foreach (ProducerPeer::doSelectArray() as $id => $producer) {
				$this->selectProducerList[$id] = $producer['name'];
			}
		}
		 
		$selectedCategories = $this->getRequestParameter('st_search_category',array());
		if ($this->category_show)
		{
			$c = new Criteria();
			$c->addAscendingOrderByColumn(CategoryPeer::SCOPE);
			$c->addAscendingOrderByColumn(CategoryPeer::LFT);
			if ($this->category_depth) $c->add(CategoryPeer::DEPTH, $this->category_depth, Criteria::LESS_THAN);
			$this->selectCategoryList = '';
			foreach (ProductHasCategoryPeer::doSelectCategories($c) as $category) {
				$this->selectCategoryList.='<option '.((array_search($category->getId(),$selectedCategories)!==false)?"selected":"").' value="'.$category->getId().'">'.$this->getNbsp($category->getDepth()).$category->getName().'</option>';
			}
		}
	}

	/**
	 * Komponent no_query
	 */
	public function executeNoQuery()
	{
		$this->smarty = new stSmarty('stSearchFrontend');
	}

	/**
	 * Komponent no_result
	 */
	public function executeNoResults()
	{
		$this->smarty = new stSmarty('stSearchFrontend');
	}

	public function getNbsp($i = 0)
	{
		$data = '';
		for ($e = 0; $e<$i*4; $e++) {
			$data.='&nbsp;';
		}
		return $data;
	}

	public function executeProducers()
	{
		$c = clone $this->searchCriteria;
        $c->clearOrderByColumns();
		$c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID);
		$c->setOffset(0);
		$c->setLimit(0);
        $c->addGroupByColumn(ProductPeer::PRODUCER_ID);
        $c->addAscendingOrderByColumn(ProducerPeer::OPT_NAME);
		$this->producers = ProducerPeer::doSelectWithI18n($c);

		$this->chosen_producer = $this->getRequestParameter('st_search[producer]');
		 
	}
}
