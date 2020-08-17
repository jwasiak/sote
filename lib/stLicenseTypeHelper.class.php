<?php
class stLicenseTypeHelper
{
	public static function addCommercialModule($module)
	{
		$list = sfConfig::get('st_commercial_modules', array());
		$list[] = $module;
		sfConfig::set('st_commercial_modules', $list);
	}

	public static function getCommercialModules()
	{
		return sfConfig::get('st_commercial_modules', array());
	}

	public static function isCommercial($module)
	{
		$plugin = str_replace(array('Frontend', 'Backend'), 'Plugin', $module);
		
        $list = self::getCommercialModules();

		return in_array($plugin, $list) || in_array($module, $list);
	}

	public static function addImageStyle($module = null, $imageParameters = '')
	{
		if (stLicense::isOpen())
		{
			if (is_null($module)) return 'opacity: 0.1';
			if (self::isCommercial($module))
			{
				if (is_array($imageParameters))
				{
					if (isset($imageParameters['style']))
					{
						$imageParameters['style'].= ';opacity: 0.1;';
					} else {
						$imageParameters['style'] = 'opacity: 0.1';
					}
				} else {
					return 'opacity: 0.1';
				}
			}
		}
		return $imageParameters;
	}
}