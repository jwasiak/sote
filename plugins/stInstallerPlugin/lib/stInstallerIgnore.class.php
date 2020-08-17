<?php
/**
 * SOTESHOP/stInstallerPlugin
 *
 * Ten plik należy do aplikacji stInstallerPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stInstallerPlugin
 * @subpackage  lib
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stInstallerIgnore.class.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * Baza ignorowanych plików synchornizacji
 */
class stInstallerIgnore
{
	/**
	 * Odczytuje i zwraca listę wyrażeń regularnych, dla pomijanych plików
	 *
	 * @param string $app nazwa aplikacji np. stAppName
	 * @return array(ereg=>(ignore|discard)) discard - odrzuca zawsze, ignore - pomija jesli plik juz istnieje
	 */
	static public function getIgnore($app)
	{

		$ignore=array();

		$file=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'ignore.yml';
		if (file_exists($file))
		{
			$data=sfYaml::load($file);
			if (! empty($data['ignore']))
			{
				$ignore = $data['ignore'];
			}
		}

		$file=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.
		$app.DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'ignore.yml';
		if (file_exists($file))
		{
			$data=sfYaml::load($file);
			if (! empty($data['ignore']))
			{
				$ignore = array_merge($ignore, $data['ignore']);
			}
		}

		return $ignore;
	}

	/**
	 * Odczytywanie listy wzorców dla plików, które mają zostać zsynchronizowane.
	 * W przypadku ignore_replace pliki te będą trakowane jako ignore jeżeli zostąły zmienione, w przeciwnym wypadku będą napisywane. 
	 * 
	 * @param string $app Nazwa aplikacji
	 * @return array lista wzorców dla plików 
	 */
	static public function getIgnoreReplace($app)
	{
		$files = array(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'ignore.yml',
		sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'ignore.yml');

		$ignoreReplace = array();

		foreach($files as $file)
		{
			if (file_exists($file))
			{
				$data = sfYaml::load($file);
				if (isset($data['ignore_replace'])) $ignoreReplace = array_merge($ignoreReplace, $data['ignore_replace']);

			}
		}

		return array_unique($ignoreReplace);
	}
}

