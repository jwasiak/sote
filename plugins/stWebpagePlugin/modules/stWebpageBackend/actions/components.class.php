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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 392 2009-09-08 14:55:35Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Załączenie klasy stPluginWebpageBackendComponents
 * którą rozszerza stWebpageBackendComponents
 *
 * @package     stWebpagePlugin
 * @subpackage  actions
 */
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stPluginWebpageBackendComponents.class.php';

/** 
 * Klasa stWebpageBackendComponents
 *
 * @package     stWebpagePlugin
 * @subpackage  actions
 */
class stWebpageBackendComponents extends stPluginWebpageBackendComponents
{
// pusta klasa rozszerzajaca stPluginDemoBackendComponents

	    public function executeLinksEditMenu()
    {
        $this->webpage = $this->related_object;

        $i18n = $this->getContext()->getI18n();

        
        $this->items = array('stWebpageBackend/linksEdit?id=' . $this->webpage->getPrimaryKey() => $i18n->__('Edycja podstawowa', null, 'stWebpageBackend'));
        $this->items["stWebpageBackend/webpageGroupList?webpage_id={$this->webpage->getId()}"] = $i18n->__('Dołącz do grupy linków', null, 'stWebpageBackend');
 
        if (!$this->items)
        {
            return sfView::NONE;
        }
        $this->processMenuItems(); 
        $this->selected_item_path = $this->getUser()->getAttribute('selected', false, 'soteshop/component/menu');
    }

        public function executeEditMenu()
    {
        $this->webpage = $this->related_object;

        $i18n = $this->getContext()->getI18n();

        if ($this->webpage->getOtherLink() == null)
        {
        $this->items = array('stWebpageBackend/edit?id=' . $this->webpage->getPrimaryKey() => $i18n->__('Edycja podstawowa', null, 'stWebpageBackend'));
        $this->items["stWebpageBackend/webpageGroupList?webpage_id={$this->webpage->getId()}"] = $i18n->__('Dołącz do grupy linków', null, 'stWebpageBackend');
        $this->items["stWebpageBackend/positioningEdit?webpage_id={$this->webpage->getId()}"] = $i18n->__('Pozycjonowanie', null, 'stWebpageBackend');
 		}else{
 		$this->items = array('stWebpageBackend/linksEdit?id=' . $this->webpage->getPrimaryKey() => $i18n->__('Edycja podstawowa', null, 'stWebpageBackend'));
        $this->items["stWebpageBackend/webpageGroupList?webpage_id={$this->webpage->getId()}"] = $i18n->__('Dołącz do grupy linków', null, 'stWebpageBackend');
 		}

        if (!$this->items)
        {
            return sfView::NONE;
        }
        $this->processMenuItems(); 
        $this->selected_item_path = $this->getUser()->getAttribute('selected', false, 'soteshop/component/menu');
    } 

    public function executeTermsVersion()
    {
        $app_terms = WebpagePeer::retrieveByState('APP_TERMS');
        
        if($app_terms){
            $this->content = $app_terms->getContent();    
        }
    }
    
    public function executePrivacyVersion()
    {
        $app_privacy = WebpagePeer::retrieveByState('APP_PRIVACY');
        
        if($app_privacy){
            $this->content = $app_privacy->getContent();    
        }
    }
    
    public function executeRight2cancelVersion()
    {
        $app_right2cancel = WebpagePeer::retrieveByState('APP_RIGHT2CANCEL');
        
        if($app_right2cancel){
            $this->content = $app_right2cancel->getContent();    
        }
    }

}

?>