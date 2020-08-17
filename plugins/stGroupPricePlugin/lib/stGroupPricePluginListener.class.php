<?php

class stGroupPricePluginListener {


	public static function generateStProduct(sfEvent $event) {
		$event -> getSubject() -> attachAdminGeneratorFile('stGroupPricePlugin', 'stProduct.yml');
	}

}
