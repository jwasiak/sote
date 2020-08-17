<?php
/**
 * SOTESHOP/stLanguagePlugin
 *
 * Ten plik należy do aplikacji stLanguagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLanguagePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stLanguageFastCache.class.php 6723 2010-07-21 11:56:58Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stLanguageFastCache
 *
 * @package     stLanguagePlugin
 * @subpackage  libs
 */
class stLanguageFastCache
{
	/**
	 * Tworzenie pliku cache
	 */
	public static function create()
	{
		$cacheArray = array();

		$languages = LanguagePeer::doSelectLanguages();
		$defaultLanguage = LanguagePeer::doSelectDefault();

		if (is_object($defaultLanguage)) $cacheArray['default'] = $defaultLanguage->getOriginalLanguage();

        // foreach($languages as $language)
        // {
        //  $cacheArray['languages'][$language->getOriginalLanguage()] = $language->getShortcut();
        // }
        //
        // required for propel-load-data without default language object m@sote.pl 2011-01-19
		
		$domains = LanguageHasDomainPeer::doSelectAll();
		
		foreach ($domains as $domain)
		{
		    if (is_object($domain))
		    {
		        $langobj=$domain->getLanguage();
		        if (is_object($langobj))
		        {
			        $cacheArray['domains'][$langobj->getOriginalLanguage()][] = $domain->getDomain();
		        }
		    }
		}
		
		$serialized = serialize($cacheArray);

		self::clear();
		file_put_contents(self::getFileName(), $serialized);
	}

	/**
	 * Usuwanie pliku cache
	 */
	public static function clear()
	{
		if (file_exists(self::getFileName())) @unlink(self::getFileName());
	}

	/**
	 * Pobieranie nazwy pliku cache
	 *
	 * @return string ścieżka do pliku
	 */
	public static function getFileName()
	{
		return sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'fastcache'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'languages.db';
	}
}