<?php
class stSoteshopPartner {
	static public function getOrderLink() {
		$file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'partner_config.yml';
		if (file_exists($file)) {
			$yml = sfYaml::load($file);
			if(isset($yml['order_link'])) return $yml['order_link'];
		}
		return 'http://www.sote.pl';
	}

	static public function getSystemName() {
		$file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'partner_config.yml';
		if (file_exists($file)) {
			$yml = sfYaml::load($file);
			if(isset($yml['system_name'])) return $yml['system_name'];
		}
		return null;
	}
}