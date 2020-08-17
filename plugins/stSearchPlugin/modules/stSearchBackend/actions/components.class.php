<?php
/** 
 * SOTESHOP/stSearchPlugin 
 * 
 * Ten plik należy do aplikacji stSearchPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stSearchPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 6510 2010-07-15 15:44:40Z pawel $
 */

/** 
 * stReview components
 *
 * @author Paweł Byszewski <pawel.byszewski@sote.pl>, Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 *
 * @package     stSearchPlugin
 * @subpackage  actions
 */
class stSearchBackendComponents extends autoStSearchBackendComponents
{
    public function executeSimpleSearchFields() {
        $i18n = $this->getContext()->getI18n();
        $this->fields = array(
            'product_name'=>$i18n->__('Nazwa produktu'),
            'product_code'=>$i18n->__('Kod produktu'),
            'product_short_desc'=>$i18n->__('Opis skrócony produktu'),
            'product_long_desc'=>$i18n->__('Opis pełny produktu'),
            'product_keywords'=>$i18n->__('Słowa kluczowe produktu'),
            'product_producer'=>$i18n->__('Nazwa producenta produktu')
        );
        $this->configFields = $this->config->get('simple_search_fields');
        
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stSearchFrontend.SimpleSearchFileds', array()));
    }

    public function executeSimpleFullSearchFields() {
        $i18n = $this->getContext()->getI18n();
        $this->fields = array(
                'product_name'=>$i18n->__('Nazwa produktu'),
                'product_code'=>$i18n->__('Kod produktu'),
                'product_short_desc'=>$i18n->__('Opis skrócony produktu'),
                'product_long_desc'=>$i18n->__('Opis pełny produktu'),
                'product_keywords'=>$i18n->__('Słowa kluczowe produktu'),
                'product_producer'=>$i18n->__('Nazwa producenta produktu')
        );
        $this->configFields = $this->config->get('simple_full_search_fields');

        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stSearchFrontend.SimpleSearchFileds', array()));
    }

    public function executeAdvancedSearchFields() {
        $i18n = $this->getContext()->getI18n();
        $this->fields = array(
            'product_name'=>$i18n->__('Nazwa produktu'),
            'product_code'=>$i18n->__('Kod produktu'),
            'product_short_desc'=>$i18n->__('Opis skrócony produktu'),
            'product_long_desc'=>$i18n->__('Opis pełny produktu'),
            'product_keywords'=>$i18n->__('Słowa kluczowe produktu'),
            'product_producer'=>$i18n->__('Nazwa producenta produktu')
        );
        $this->configFields = $this->config->get('advanced_search_fields');
        
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stSearchFrontend.AdvancedSearchFileds', array()));
    }

    public function executeAdvancedFullSearchFields() {
        $i18n = $this->getContext()->getI18n();
        $this->fields = array(
                'product_name'=>$i18n->__('Nazwa produktu'),
                'product_code'=>$i18n->__('Kod produktu'),
                'product_short_desc'=>$i18n->__('Opis skrócony produktu'),
                'product_long_desc'=>$i18n->__('Opis pełny produktu'),
                'product_keywords'=>$i18n->__('Słowa kluczowe produktu'),
                'product_producer'=>$i18n->__('Nazwa producenta produktu')
        );
        $this->configFields = $this->config->get('advanced_full_search_fields');

        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stSearchFrontend.AdvancedSearchFileds', array()));
    }
}
?>