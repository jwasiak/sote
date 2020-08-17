<?php
/**
 * SOTESHOP/stBase
 *
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBase
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stActions.class.php 332 2009-09-07 13:26:12Z marcin $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stI18N.
 *
 * @package     stBase
 * @subpackage  libs
 */
class stI18N
{
	/**
	 * Tablica z tlumaczeniami
	 * @var array
	 */
	protected $messages = array();

	/**
	 * Instacja stI18N
	 */
	static protected $instance = null;

	/**
	 * Culture
	 * @var string
	 */
	protected $culture;

	/**
	 * Obiekt cachu
	 * @var stMessageCache
	 */
	protected $cache = null;

	/**
	 * Pobieranie instancji
	 *
	 * @return stI18N
	 */
	static public function getInstance()
	{
		if (!isset(self::$instance))
		{
			$class = __CLASS__;
			self::$instance = new $class();
		}

		return self::$instance;
	}

	/**
	 * Ustawianie culture
	 *
	 * @param string $culture
	 */
	public function setCulture($culture)
	{
		$this->culture = $culture;
	}

	/**
	 * Ustawianie cachu
	 *
	 * @param stMessageCache $cache
	 */
	public function setCache(stMessageCache $cache)
	{
		$this->cache = $cache;
	}

	/**
	 * Sprawdza czy istnieje tłumaczenia dla podanego zwrotu
	 *
	 * @param string $string 
	 * @param string $catalogue
	 * @return bool
	 */
	public function hasTranslation($string, $catalogue)
	{
		$this->loadCatalogue($catalogue);

		return isset($this->messages[$this->culture][$catalogue][$string]);
	}

	/**
	 * Pobieranie przetłumaczonych zwrotów
	 *
	 * @param string $string
	 * @param array $args
	 * @param string $catalogue
	 * @return string
	 */
	public function format($string, $args = array(), $catalogue)
	{
		if ($this->hasTranslation($string, $catalogue))
		{
			$string = $this->messages[$this->culture][$catalogue][$string];
		} 

		if (is_array($args) && !empty($args))
		{
			foreach ($args as $key => $value)
			{
				if (is_object($value) && method_exists($value, '__toString'))
				{
					$args[$key] = $value->__toString();
				}
			}
			$string = strtr($string, $args);
		}

		return $string;
	}

	/**
	 * Ładowanie katalogu z wersjami językowymi
	 *
	 * @param string $catalogue
	 * @return bool
	 */
	protected function loadCatalogue($catalogue)
	{
		if (isset($this->messages[$this->culture][$catalogue])) 
		{
			return true;
		}

		if (sfConfig::get('sf_i18n_cache'))
		{
			$translations = $this->cache->get($catalogue, $this->culture);

			if (is_array($translations) && !empty($translations))
			{
				$this->messages[$this->culture][$catalogue] = $translations;
				return true;
			}
		}

		$culture = explode('_', $this->culture);
		$culture = $culture[0];

		$files = array();
		if ($culture != 'pl' && $culture != 'en') {
		    $files[] = sfConfig::get('sf_app_i18n_dir').DIRECTORY_SEPARATOR.$catalogue.'.en.xml';
		    $files[] = sfConfig::get('sf_app_i18n_dir').DIRECTORY_SEPARATOR.$catalogue.'.user.en.xml';
		}
		
		$files[] = sfConfig::get('sf_app_i18n_dir').DIRECTORY_SEPARATOR.$catalogue.'.'.$culture.'.xml';
		$files[] = sfConfig::get('sf_app_i18n_dir').DIRECTORY_SEPARATOR.$catalogue.'.user.'.$culture.'.xml';

		$translations = array();
		foreach ($files as $key => $file)
		{
			if (is_file($file))
			{
				$XML = simplexml_load_file($file, 'SimpleXMLElement', LIBXML_NOCDATA);

				if ($XML != false)
				{
					$translationUnit = $XML->xpath('//trans-unit');

					foreach ($translationUnit as $unit)
					{
						$source = (string) $unit->source->asXML();
						$source = $this->formatTranslationString($source, 'source');
						// $source = (string) $unit->source;
						if ($key == 0)
						{
							$target = (string) $unit->target->asXML();
							$translations[$source] = $this->formatTranslationString($target, 'target');
							// $translations[$source] = (string) $unit->target;
						} else {
							$target = (string) $unit->target->asXML();
							$target = $this->formatTranslationString($target, 'target');
							if (!empty($target)) $translations[$source] = $target;
						}
					}
				}
			}
		}

		$this->messages[$this->culture][$catalogue] = $translations;

		if (sfConfig::get('sf_i18n_cache'))
		{
			$this->cache->save($translations, $catalogue, $this->culture);
		}

		return true;
	}
	
	protected function formatTranslationString($string, $type)
	{
		$string = mb_eregi_replace('</{0,1}'.$type.'/{0,1}>', '', $string);
		$string = html_entity_decode($string);
		return $string;
	}
}