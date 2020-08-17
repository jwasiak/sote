<?php
/** 
 * SOTESHOP/stDiscountPlugin 
 * 
 * Ten plik należy do aplikacji stDiscountPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stDiscountPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 10 2009-08-24 09:32:18Z michal $
 */

class stDiscountBackendComponents extends autostDiscountBackendComponents
{
    public function executeEditMenu()
    {
        // $this->discount = $this->related_object;

        // $i18n = $this->getContext()->getI18n();

        
        // $this->items = array('stDiscountBackend/edit?id=' . $this->discount->getPrimaryKey() => $i18n->__('_edit', null, 'stDiscountBackend'));
        // $this->items["stDiscountBackend/edit?id={$this->discount->getId()}"] = $i18n->__('Edycja', null, 'stDiscountBackend');
        // $this->items["stDiscountBackend/userList?discount_id={$this->discount->getId()}"] = $i18n->__('Przypisz klientów', null, 'stDiscountBackend');
        // $this->items["stDiscountBackend/productList?discount_id={$this->discount->getId()}"] = $i18n->__('Przypisz produkty', null, 'stDiscountBackend');
 
        // if (!$this->items)
        // {
        //     return sfView::NONE;
        // }
        // $this->processMenuItems(); 
        // $this->selected_item_path = $this->getUser()->getAttribute('selected', false, 'soteshop/component/menu');
        $ret = parent::executeEditMenu();

        if ($this->discount->getType() == 'O')
        {
            unset($this->items["stDiscountBackend/productList?discount_id={$this->discount->getId()}"]);
        }

        return $ret;
    } 
}
