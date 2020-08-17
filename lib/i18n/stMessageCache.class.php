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
 * Klasa stMessageCache
 *
 * @package     stBase
 * @subpackage  libs
 */
class stMessageCache extends sfMessageCache
{
	/**
	 * Przeciążenie metody initialize z sfMessageCache
	 * 
	 * @param array $options
	 */
	public function initialize($options = array())
	{
		$this->cache = new sfFileCache();
		$this->cache->initialize($options);
		
		if (isset($options['lifeTime'])) $this->lifetime = $options['lifeTime'];
	}

	/**
	 * Przeciążenie metody get z sfMessageCache
	 *
	 * @param string $catalogue
	 * @param string $culture
	 */
	public function get($catalogue, $culture, $lastmodified = 0)
	{
		if (time() > $this->cache->lastModified($culture, $catalogue)+$this->lifetime) return false;
		return unserialize($this->cache->get($culture, $catalogue));
	}
}