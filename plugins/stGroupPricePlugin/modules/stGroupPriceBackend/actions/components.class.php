<?php
/**
 * SOTESHOP/stGroupPriceBackend
 *
 *
 * @package     stGroupPricePlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

class stGroupPriceBackendComponents extends autoStGroupPriceBackendComponents {

	public function executeConfigContent() {

	}

	public function executeProductsInGroup()
    {	
		$c = new Criteria();
		$c -> add(ProductPeer::GROUP_PRICE_ID, $this->group_price->getId());
		$products = ProductPeer::doCount($c);
		
		if($products){
			$this->products_in_group = $products; 
		}else{
			$this->products_in_group = "-";
		}
		$this->group_price_id = $this->group_price->getId();
    }
	
	public function executeLinkToChangePrice()
    {
		$this->executeProductsInGroup();
    }
	
}