<?php
/** 
 * SOTESHOP/stBoxPlugin 
 * 
 * Ten plik należy do aplikacji stBoxPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBoxPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id$
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Klasa stBoxBackendComponents
 *
 * @package     stBoxPlugin
 * @subpackage  actions
 */
class stBoxBackendComponents extends autoStBoxBackendComponents
{
 /**
     * Dostarcza tablicę dla wyboru domyślnych wartości strony
     */
    public function executeDefaultGroupBox()
    {
        $i18n = sfContext::getInstance()->getI18N();

        $configs=array(
        0=>"default_boxes.yml",
        1=>"user_boxes.yml"
        );
        foreach ($configs as $config_id => $config_name)
        {
            // pobiera wartości domyślne dla strony z pliku konfiguracyjnego
            $fileymlRoot = SF_ROOT_DIR . DIRECTORY_SEPARATOR . sfConfig::get('sf_plugins_dir_name'). DIRECTORY_SEPARATOR. 'stBoxPlugin' . DIRECTORY_SEPARATOR . sfConfig::get('sf_config_dir_name') . DIRECTORY_SEPARATOR . $config_name;
            $yml = sfYaml::load($fileymlRoot);
            if ($config_id==0)
            {
                $default_group_boxes = $yml['group_box'];
            }
            elseif(isset($yml['group_box']))
            {
                $user_group_boxes = $yml['group_box'];
            }else{
                $user_group_boxes = array();
            }
        }
        foreach ($default_group_boxes as $system_name => $name)
        {
            $default_group_boxes[$system_name] = $i18n->__($name);
        }

        $default_group_boxes=array_merge($default_group_boxes,$user_group_boxes);
        $chosen_default_group_boxes=$this->getChosenDefaultGroup($this->getRequestParameter("id"));
        $this->default_group_box=(array_diff_key($default_group_boxes, $chosen_default_group_boxes));
    }

    /**
     * Pobiera już wybrane wartości domyślne
     *
     * @param   integer     id                  edytowanej strony $id
     * @return  array       tablicę z wybranymi już wcześniej wartościami
     */
    private function getChosenDefaultGroup($id)
    {
            $c = new Criteria();
            if ($id)
            {
                $c->add(BoxGroupPeer::ID, $id, Criteria::NOT_EQUAL);
            }
            $groups_box = BoxGroupPeer::doSelect($c);
            $chosen_default_group_boxes=array();

            foreach ($groups_box as $group_box)
            {
                if($group_box->getBoxGroup())
                {
                    array_push($chosen_default_group_boxes,$group_box->getBoxGroup());
                }
            }
        $chosen_default_group_boxes=array_flip($chosen_default_group_boxes);
        return $chosen_default_group_boxes;
    }

}