<?php
/** 
 * SOTESHOP/stAdminGeneratorPlugin 
 * 
 * Ten plik należy do aplikacji stAdminGeneratorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAdminGeneratorPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 396 2009-09-09 07:59:20Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/** 
 * stSlideBannerBackend actions.
 *
 * @author Your name here
 *
 * @package     stAdminGeneratorPlugin
 * @subpackage  actions
 */
class stSlideBannerBackendComponents extends autostSlideBannerBackendComponents
{
   public function executeConfigContent()
   {
       $config = stConfig::getInstance($this->getContext(), 'stSlideBannerBackend');
       $this->bannerConfig = $config->load();
   }
}
