<?php
/** 
 * Zwraca HTML przycisku dla danej akcji
 *
 * @param   string      $type               Typ akcji (dostepne: save, save_and_add, save_and_list, delete, list, edit)
 * @param   string      $label              Etykieta przycisku
 * @param   string      $action             Akcja przycisku (np. category/index)
 * @param   mixed       $html_options       opcje HTML
 * @return       string      HTML
 */
function st_get_update_action($type, $label, $action = null, $html_options = array())
{
    $html_options = _parse_attributes($html_options);
    
    if ($type == 'create' || $type == 'add')
    {
        $type = 'add';
    }
    elseif ($type == 'save_and_list' || $type == 'save_and_add' || $type == 'save')
    {
        $type = 'save';
    }
    
    $html_options['style'] = 'background-image: url(/images/update/red/icons/' . $type . '.png?v=2)';
    
    if (is_null($action))
    {
        $action_content = submit_tag($label, $html_options);
    }
    else
    {
        $action_content = button_to($label, $action, $html_options);
    }
    
    return content_tag('li', content_tag('div', content_tag('div', $action_content)), array('class' => 'st_admin-action-' . $type));
}

/** 
 * Zwraca HTML otwierający definiowanie akcji
 *
 * @param   string      $html_options       opcje HTML
 * @return       string      HTML
 */
function st_get_update_actions_head($html_options = array())
{
    $html_options = _parse_attributes($html_options);
    if (isset($html_options['class']))
    {
        $html_options['class'] = 'st_admin-actions ' . $html_options['class'];
    }
    else
    {
        $html_options['class'] = 'st_admin-actions';
    }
    
    return tag('ul', $html_options, true);
}

/** 
 * Zwraca HTML zamykający definiowanie akcji
 *
 * @return       string      HTML
 */
function st_get_update_actions_foot()
{
    return '</ul>' . tag('br', array('class' => 'st_clear_all'));
}

function st_external_link_to($name = '', $internal_uri = '', $options = array())
{
   $options = _parse_attributes($options);
   
   $options['class'] = 'st_admin_external_link';
   
   return link_to($name, $internal_uri, $options); 
}

function st_program_name()
{
    return 'SOTESHOP';
}

function get_shop_version() {
    $version = (stRegisterSync::getPackageVersion('soteshop') != '') ? stRegisterSync::getPackageVersion('soteshop') : stRegisterSync::getPackageVersion('soteshop_base');

    if (stCommunication::getIsSeven()) {
        list(, $y, $z) = explode('.', $version, 3);
        if ($y >= 3)
            $version = '7.'.($y-3).'.'.$z;
    }

    return $version;
}
