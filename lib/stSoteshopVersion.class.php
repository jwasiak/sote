<?php
class stSoteshopVersion {

	const ST_SOTESHOP_VERSION_TYPE_ALL = 0;
	const ST_SOTESHOP_VERSION_TYPE_PACKAGE = 1;
	const ST_SOTESHOP_VERSION_TYPE_CUSTOM_FILE = 2;

	const ST_SOTESHOP_VERSION_UNKNOWN = 0;
	const ST_SOTESHOP_VERSION_POLISH = 1;
	const ST_SOTESHOP_VERSION_UNITED_KINDOM = 2;
	const ST_SOTESHOP_VERSION_INTERNATIONAL = 3;

	private static $packageVersion = array('pl' => self::ST_SOTESHOP_VERSION_POLISH,
	                                'uk' => self::ST_SOTESHOP_VERSION_UNITED_KINDOM,
	                                'international' => self::ST_SOTESHOP_VERSION_INTERNATIONAL);

	public static function getVersion($type = self::ST_SOTESHOP_VERSION_TYPE_ALL) {
		if ($type == self::ST_SOTESHOP_VERSION_TYPE_ALL) {
			$package = self::getVersion(self::ST_SOTESHOP_VERSION_TYPE_PACKAGE);
			$customFile = self::getVersion(self::ST_SOTESHOP_VERSION_TYPE_CUSTOM_FILE);
			if ($package != self::ST_SOTESHOP_VERSION_UNKNOWN) return $package;
			else return $customFile;
		} elseif ($type == self::ST_SOTESHOP_VERSION_TYPE_PACKAGE) {
			foreach (self::$packageVersion as $package => $version) {
				if (file_exists(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.'soteshop_'.$package)) return $version;
			}
		} elseif ($type == self::ST_SOTESHOP_VERSION_TYPE_CUSTOM_FILE) {
			$installCustomPath = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'install_custom.yml';
			if (file_exists($installCustomPath)){
				$installCustom = sfYaml::load($installCustomPath);
				if (isset($installCustom['package'])) {
					foreach (self::$packageVersion as $package => $version) {
						if ($installCustom['package'] == 'soteshop_'.$package) return $version;
					}
				}
			}
		}
		return self::ST_SOTESHOP_VERSION_UNKNOWN;
	}
}