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
 * @version     $Id: stPluginWebpageBackendComponents.class.php 6721 2010-07-21 11:43:09Z krzysiek $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * stWebpageBackend components. Dodaje wybór domyślnych wartości stron.
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>  
 *
 * @package     stWebpagePlugin
 * @subpackage  libs
 */
class stPluginWebpageBackendComponents extends autoStWebpageBackendComponents
{
    
    /** 
     * Dostarcza tablicę dla wyboru domyślnych wartości strony
     */
    public function executeDefaultGroupPage()
    {
        $i18n = sfContext::getInstance()->getI18N();

        $configs=array(
        0=>"default_pages.yml",
        1=>"user_pages.yml"
        );
        foreach ($configs as $config_id => $config_name)
        {
            // pobiera wartości domyślne dla strony z pliku konfiguracyjnego
            $fileymlRoot = SF_ROOT_DIR . DIRECTORY_SEPARATOR . sfConfig::get('sf_plugins_dir_name'). DIRECTORY_SEPARATOR. 'stWebpagePlugin' . DIRECTORY_SEPARATOR . sfConfig::get('sf_config_dir_name') . DIRECTORY_SEPARATOR . $config_name;
            $yml = sfYaml::load($fileymlRoot);
            if ($config_id==0)
            {
                $default_group_pages = $yml['group_page'];
            }
            elseif(isset($yml['group_page']))
            {
                $user_group_pages = $yml['group_page'];
            }else{
                $user_group_pages = array();
            }
        }
        foreach ($default_group_pages as $system_name => $name)
        {
            $default_group_pages[$system_name] = $i18n->__($name);
        }

        $default_group_pages=array_merge($default_group_pages,$user_group_pages);
        $chosen_default_group_pages=$this->getChosenDefaultGroupPages($this->getRequestParameter("id"));           
        $this->default_group_page=(array_diff_key($default_group_pages, $chosen_default_group_pages));
    }

    /** 
     * Pobiera już wybrane wartości domyślne
     *
     * @param   integer     id                  edytowanej strony $id
     * @return  array       tablicę z wybranymi już wcześniej wartościami  
     */
    private function getChosenDefaultGroupPages($id)
    {
            $c = new Criteria();
            if ($id)
            {
                $c->add(WebpageGroupPeer::ID, $id, Criteria::NOT_EQUAL);
            }
            $groups_webpage = WebpageGroupPeer::doSelect($c);
            $chosen_default_group_pages=array();
            foreach ($groups_webpage as $group_webpage)
            {
                if($group_webpage->getGroupPage())
                {
                    array_push($chosen_default_group_pages,$group_webpage->getGroupPage());
                }
            }
        $chosen_default_group_pages=array_flip($chosen_default_group_pages);
        return $chosen_default_group_pages;
    }
}
?>
