<?php
/** 
 * SOTESHOP/stTextPlugin 
 * 
 * Ten plik należy do aplikacji stTextPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stTextPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stTextCache.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stTextCache
 *
 * @package     stTextPlugin
 * @subpackage  libs
 */
class stTextCache
{
    static public function deleteCacheText($modelInstance = null, $con = null)
    {
        sfToolkit::clearGlob(sfConfig::get('sf_root_cache_dir').'/*/*/template/stFrontendMain/_mainText/*');
    }
}