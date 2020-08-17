<?php
/** 
 * SOTESHOP/stProductGroup 
 * 
 * Ten plik należy do aplikacji stProductGroup opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProductGroup
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 6385 2010-07-13 13:12:38Z krzysiek $
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 */

/** 
 * Komponenty stProductGroup
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 *
 * @package     stProductGroup
 * @subpackage  actions
 */
class stProductGroupComponents extends autoStProductGroupComponents
{
    /** 
     * Dostarcza tablicę dla wyboru domyślnych wartości grup strony
     */
    public function executeDefaultProductGroup()
    {
        $i18n = sfContext::getInstance()->getI18N();
        // pobiera wartości domyślne dla grup produktu z pliku konfiguracyjnego
        $fileymlRoot = sfConfig::get('sf_app_module_dir'). DIRECTORY_SEPARATOR. 'stProductGroup' . DIRECTORY_SEPARATOR . sfConfig::get('sf_config_dir_name') . DIRECTORY_SEPARATOR . "default_product_group.yml";
        $yml = sfYaml::load($fileymlRoot);
        $default_product_group = $yml['product_group'];
        if (stTheme::hideOldConfiguration()) {
            array_splice($default_product_group, 5, 1);
        }
        foreach ($default_product_group as $system_name=>$name)
        {
            $default_product_group[$system_name] = $i18n->__($name);
        }
        $chosen_default_product_group=$this->getChosenDefaultProductGroup($this->getRequestParameter("id"));
        $this->default_product_group=(array_diff_key($default_product_group, $chosen_default_product_group));
    }

    /** 
     * Pobiera już wybrane wartości domyślne
     *
     * @param   integer     id                  edytowanej strony $id
     * @return  array       tablicę z wybranymi już wcześniej wartościami 
     */
    private function getChosenDefaultProductGroup($id)
    {
        $c = new Criteria();
        if ($id)
        {
            $c->add(ProductGroupPeer::ID, $id, Criteria::NOT_EQUAL);
        }
        $product_groups = ProductGroupPeer::doSelect($c);
        $chosen_default_product_group=array();
        foreach ($product_groups as $product_group)
        {
            if($product_group->getProductGroup())
            {
                if ($product_group->getProductGroup() != 'NONE')
                {
                    array_push($chosen_default_product_group,$product_group->getProductGroup());
                }
            }
        }
        $chosen_default_product_group=array_flip($chosen_default_product_group);
        return $chosen_default_product_group;
    }

}
?>