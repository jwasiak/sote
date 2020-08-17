<?php
/** 
 * SOTESHOP/stTabNavigatorPlugin 
 * 
 * Ten plik należy do aplikacji stTabNavigatorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stTabNavigatorPlugin
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stTabNavigatorHelper.php 15099 2011-09-16 10:31:59Z marcin $
 */

/** 
 * stTabNavigatorPlugin
 *
 * @package stTabNavigatorPlugin
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 */
use_helper('Javascript', 'I18N');

/** 
 * Wyświetla kontrolke dla obiektu stTabNavigator
 *
 * @param   stTabNavigator $tab_navigator   instancja obiektu
 * @param               array       $params             parametry
 */
function st_include_tab_navigator($tab_navigator, $params = array())
{
    echo st_get_tab_navigator($tab_navigator, $params);
}

/** 
 * Zwraca kontrolke dla obiektu stTabNavigator
 *
 * @param   stTabNavigator $tab_navigator   instancja obiektu
 * @param               array       $params             parametry
 * @return       string      HTML
 */
function st_get_tab_navigator($tab_navigator, $params = array())
{
    st_theme_use_stylesheet('stTabNavigator.css');

    sfContext::getInstance()->getResponse()->addJavascript('/plugins/stTabNavigatorPlugin/js/stTabNavigator.js');

    if (!isset($params['target_url']))
    {
        $params['target_url'] = $tab_navigator->getTargetUrl();
    }

    if (!isset($params['class']))
    {
        $params['class'] = 'st_tab_navigator';
    }

    if (!isset($params['param_name']))
    {
        $params['param_name'] = $tab_navigator->getName();
    }

    if (!isset($params['id']))
    {
        $params['id'] = $params['class'].'-'.$tab_navigator->getName();
    }
    else
    {
        $params['id'] .= '-'.$tab_navigator->getName();
    }

    if (!isset($params['s_tab_class']))
    {
        $params['s_tab_class'] = 'st_selected';
    }

    if (!isset($params['f_tab_class']))
    {
        $params['f_tab_class'] = 'st_first';
    }

    if (!isset($params['l_tab_class']))
    {
        $params['l_tab_class'] = 'st_last';
    }

    if (!isset($params['d_tab_class']))
    {
        $params['d_tab_class'] = 'st_dummy';
    }

    if (!isset($params['c_tab_class']))
    {
        $params['c_tab_class'] = 'st_content_tab';
    }

    $content = '';
    
    if(count($tab_navigator->getTabs())==0)
    {
        return;
    }

    foreach ($tab_navigator->getTabs() as $tab)
    {
        $params['tab_class']='';
        if ($tab->getIndex() == $tab_navigator->getCurrentTab()->getIndex())
        {
            $params['tab_class'] .= $params['s_tab_class']. ' ';
        }

        if ($tab->getIndex() == $tab_navigator->getLastTab()->getIndex())
        {
            $params['tab_class'] .= $params['l_tab_class']. ' ';
        }
        elseif ($tab->getIndex() == $tab_navigator->getFirstTab()->getIndex())
        {
            $params['tab_class'] .= $params['f_tab_class']. ' ';
        }

        $content .= _link_to_tab($tab, $params)."\n";
    }

    $content .= content_tag('li', '', array('class' => $params['d_tab_class']));

    $ul_content = content_tag('ul', $content);

    $tab_content = _get_tab_content($tab_navigator, $params);

    $select_js = '<script type="text/javascript">jQuery(document).ready(function() { jQuery("#'.$params['id'].'-link-'.$tab_navigator->getCurrentTab()->getIndex().' > a").click(); });</script>';

    return content_tag('div', $ul_content, array('id' => $params['id'], 'class' => $params['class'])).$tab_content.$select_js;

}

/** 
 * Zwraca link dla zakładki
 *
 * @param   stTab       $tab                obiekt zakładki  
 * @param               array       $params             parametry
 * @return   string
 */
function _link_to_tab($tab, $params = array())
{
    $target_url = $params['target_url'];
    $param_name = $params['param_name'];
    $tab_navigator_id = $params['id'];

    $tab_class = $params['tab_class'];

    if (strpos($target_url, '?') === false)
    {
        $url_for = url_for($target_url.'?'.$param_name.'='.$tab->getIndex());
    }
    else
    {
        $url_for = url_for($target_url.'&'.$param_name.'='.$tab->getIndex());
    }

    $tab_id = $tab_navigator_id.'-link-'.$tab->getIndex();

    $params_for_url = $tab->getParamsForUrl();

    $params_for_url[$param_name] = $tab->getIndex();

    $indicator = content_tag('div', image_tag('/plugins/stTabNavigatorPlugin/images/ajax-loader.gif'), array('class' => 'st_indicator'));
 
    $link_to_remote = content_tag('a', content_tag('span',__($tab->getLabel(), '', $tab->getModuleName())), array('href' => '#'));
    
    $url = url_for($params_for_url);
    
    $js = <<<JS
    <script type="text/javascript">
    //<![CDATA[
      jQuery(function($) {
         $('li#$tab_id a').click(function(event) {
            stTabNavigator.selectTab('$tab_navigator_id', '$tab_id', '{$params['s_tab_class']}');
            $('#{$params['id']}-content').html('$indicator');
            $('#$tab_navigator_id-content').load('$url', function() { $('st_indicator-$param_name').hide(); });
            event.preventDefault();
         });
      });    
    //]]>  
    </script>
JS;

    if ($tab_class)
    {
        return content_tag('li', $link_to_remote.$js, array('id' => $tab_id, 'class' => $tab_class));
    }

    return content_tag('li', $link_to_remote.$js, array('id' => $tab_id));
}

/** 
 * Zwraca kontener zawierający zawartość zakładki
 *
 * @param   stTabNavigator $tab_navigator
 * @param               array       $params             parametry
 * @return   unknown
 */
function _get_tab_content($tab_navigator, $params = array())
{

    return content_tag('div', '', array('id' => $params['id'].'-content', 'class' => $params['c_tab_class']));
}