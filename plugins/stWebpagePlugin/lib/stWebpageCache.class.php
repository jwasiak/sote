<?php
/** 
 * SOTESHOP/stWebpagePlugin 
 * 
 * Ten plik należy do aplikacji stWebpagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stWebpagePlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stWebpageCache.class.php 392 2009-09-08 14:55:35Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Enter description here...
 *
 * @package     stWebpagePlugin
 * @subpackage  libs
 */
class stWebpageCache
{
    static public function deleteCacheWebpage($modelInstance = null, $con = null)
    {
        stCacheManager::remove('webpage/index/webpage_id/'.$modelInstance->getId().'.cache');
        stCacheManager::remove('sf_cache_partial/stWebpageFrontend/_groupWebpage/*');
    }
    
    static public function deleteCacheWebgroup($modelInstance = null, $con = null)
    {
         stCacheManager::remove('sf_cache_partial/stWebpageFrontend/_groupWebpage/*');
    }
}