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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 11356 2011-03-02 13:48:05Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPriceCompareActions
 *
 * @package     stPriceCompare
 * @subpackage  actions
 */
class stPriceCompareActions extends stActions
{
	/**
	 * Akcja index
	 */
	public function executeIndex()
	{
		$priceCompares = stPriceCompare::getPriceCompares();
		$this->plugins = array();
		$this->pluginChecked = array();
		$this->pluginCount = array();

		$this->productsCount = ProductPeer::doCount(new Criteria());

		foreach ($priceCompares as $pluginName => $pluginOptions)
		{
			if (class_exists($pluginOptions['peerName'])) {
				$this->plugins[$pluginName] = $pluginOptions;

				$c = new Criteria();
				$c->add(constant($pluginOptions['peerName'].'::ACTIVE'), 1);
				$this->pluginCount[$pluginName] = call_user_func($pluginOptions['peerName']."::doCount", $c);

				if ($this->pluginCount[$pluginName] == $this->productsCount)
				{
					$this->pluginChecked[$pluginName] = true;
				} else {
					$this->pluginChecked[$pluginName] = false;
				}

				if (empty($this->pluginCount[$pluginName]))
				{
					$this->pluginCount[$pluginName] = 0;
				}
			}
		}
		
		$this->menu_items = $this->getMenuItems();
	}

	/**
	 * Dodaje wszystkie produkty do zaznaczonych porownywarek
	 */
	public function executeSetForAll() {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
		//czyszczenie starych wpisow
		$priceCompares = stPriceCompare::getPriceCompares();
		$plugins = array();

		// sprawdzanie ilości produktów
		$productsCount = ProductPeer::doCount(new Criteria());

		//dla wszystkich zaznaczonych plugin wykonacj dodawanie
		$peerName = $this->getRequestParameter('price_compare',array());
		foreach ($peerName as $peer) {
         stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), 'st'.substr($peer, 0, -4).'Backend');
			$c = new Criteria();
			$c->add(constant($peer.'::ACTIVE'), 1);
			if (call_user_func($peer."::doCount", $c) != $productsCount)
			{
				call_user_func($peer."::doDeleteAll");

				$query = "ALTER TABLE ".constant($peer."::TABLE_NAME")." AUTO_INCREMENT = 1;";
				$connection = Propel::getConnection();
				$statement = $connection->prepareStatement($query);
				$statement->executeQuery();
			}

			$c = new Criteria();
			$c->add(constant($peer.'::ACTIVE'), 1);
			if (call_user_func($peer."::doCount", $c) != $productsCount)
			{
				$query = "INSERT INTO ".constant($peer."::TABLE_NAME")." (`created_at`, `updated_at`, `product_id`, `active`) Select NOW(), NOW(), `id`, '1' FROM ".ProductPeer::TABLE_NAME.";";
				$connection = Propel::getConnection();
				$statement = $connection->prepareStatement($query);
				$statement->executeQuery();

				$this->setFlash('stPriceCompare_setForAll_notice', $this->getContext()->getI18N()->__('Produkty zostały dodane do porównywarek.'));
			}
		}
		$this->redirect('stPriceCompare/index');
	}

	/**
	 * Konfiguracja
	 */
	public function executeConfig()
	{
		$this->config = stConfig::getInstance($this->getContext());

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->setFromRequest('config');
            $this->config->save();
            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
        }
        $this->config->load();
        
        $this->menu_items = $this->getMenuItems();
	}
	
	protected function getMenuItems()
	{
	    $i18n = $this->getContext()->getI18N();
	
	    return array(
		          '@stPriceCompareDefault' => $i18n->__('Dodawanie produktów do porównywarek cen'),
		          'stPriceCompare/config' => $i18n->__('Konfiguracja'));
	}
}