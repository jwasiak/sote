<?php

use_helper('stAdminGenerator', 'Countries');

function st_poczta_polska_list_order_number(PocztaPolskaPaczka $paczka)
{
    return '<a href="'.st_url_for('@stOrder?action=edit&id='.$paczka->getOrderId()).'">'.$paczka->getOrder()->getNumber().'</a>';
}

function st_poczta_polska_uslugi($name, $value, array $params = array())
{
    $options = array();

    $defaults = array('include_custom' => '---');

    if ($params) {
        $params = array_merge($defaults, $params);
    } else {
        $params = $defaults;
    }

    $deliveryPointOnly = isset($params['delivery_point_only']) && $params['delivery_point_only'];

    $ppks = stPocztaPolskaClient::getCourierServiceList();

    foreach (stPocztaPolskaClient::getServices() as $n => $service)
    {
        if ($deliveryPointOnly && in_array($n, $ppks)) continue;

        $options[$n] = __($service['label'], null, 'stPocztaPolskaBackend');
    }

    natsort($options);

    return select_tag($name, options_for_select($options, $value, $params));
}

function st_poczta_polska_zawartosc($name, $value)
{
    $config = stConfig::getInstance('stPocztaPolskaBackend');

    $options = array(
        "Dokumenty" => __("Dokumenty", null, 'stPocztaPolskaBackend'),
        "Kosmetyki" => __("Kosmetyki", null, 'stPocztaPolskaBackend'),
        "Elektronika" => __("Elektronika", null, 'stPocztaPolskaBackend'),
        "Zabawki" => __("Zabawki", null, 'stPocztaPolskaBackend'),
        "Części samochodowe" => __("Części samochodowe", null, 'stPocztaPolskaBackend'),
        "Chemia" => __("Chemia", null, 'stPocztaPolskaBackend'),
        "Meble" => __("Meble", null, 'stPocztaPolskaBackend'),
    );

    $slownik = $config->get('slownik');

    if ($slownik) 
    {
        foreach (explode("|", $slownik) as $label)
        {
            $label = trim($label);
            $options[$label] = $label;
        }
    }

    return select_tag($name, options_for_select($options, $value));
}

function st_poczta_polska_ubezpieczenie($name, $value, $params)
{
    $serviceName = $params['serviceName'];
    unset($params['serviceName']);

    switch($serviceName)
    {
        case 'usluga_paczkowa_24':
        case 'usluga_paczkowa_e24':
        case 'usluga_paczkowa_48':
        case 'przesylka_biznesowa':
            $options = array(
                1000 => '1000',
                5000 => '5000',
                10000 => '10000',
                20000 => '20000',
                50000 => '50000',
                "custom" => __('określona wartość', null, 'stPocztaPolskaBackend'),
            );
        break;

        case 'pocztex_ekspres_24':
        case 'pocztex_krajowy':
            $options = array(
                5000 => '5000',
                10000 => '10000',
                20000 => '20000',
                50000 => '50000',
                "custom" => __('określona wartość', null, 'stPocztaPolskaBackend'),
            );
        break;
    }

    if ($value !== null && $value < 50001 && !isset($options[$value]))
    {
        foreach ($options as $val => $label) 
        {
            if (is_numeric($val) && $value < $val) 
            {
                $value = $val;
                break;
            }
        }
    }

    $js =<<<JS
    <script>
        jQuery(function($) {

            var custom = $('#st_poczta_polska_ubezpieczenie_custom');

            var select = $('#st_poczta_polska_ubezpieczenie');

            select.change(function() {
                if (select.val() == "custom") {
                    custom.show();
                    custom.prop('disabled', false);
                    custom.val(50001);
                    select.removeAttr('name');
                } else {
                    custom.hide();
                    custom.prop('disabled', true);
                    select.attr('name', custom.attr('name'));
                }
            }).change();

            custom.change(function() {
             
                custom.val(stPrice.fixNumberFormat(custom.val(), 0));
                var value = Number(custom.val());

                if (value < 50001) {
                    value = 50001;
                } else if (value > 250000) {
                    value = 250000;
                }

                custom.val(value);
            });

            $('#st_poczta_polska_ubezpieczenie_trigger').change(function() {
                var checked = $(this).prop('checked');
                custom.prop('disabled', !checked);
                select.prop('disabled', !checked);
            });
        });
    </script>
JS;

    return checkbox_tag('', 1, !$params['disabled'], array('id' => 'st_poczta_polska_ubezpieczenie_trigger', 'style' => 'margin-right: 5px')).select_tag($name, options_for_select($options, $value > 50000 ? "custom" : $value), array('id' => 'st_poczta_polska_ubezpieczenie', 'disabled' => $params['disabled']))." ".input_tag($name, $value, array('id' => 'st_poczta_polska_ubezpieczenie_custom', 'disabled' => $params['disabled'])).$js;
    
}

function st_poczta_polska_przesylka_biznesowa_gabaryt_select_tag($name, $selected = null, array $params = array())
{
    return select_tag($name, options_for_select(stPocztaPolskaClient::getGabarytyBiznesowa(), $selected ? $selected : 'M'), $params);
}


function st_poczta_polska_countries_select_tag($name, $selected = null, array $params = array())
{
    return st_countries_select_tag($name, $selected, $params);
}


function st_poczta_polska_list_bufor_sent(PocztaPolskaBufor $bufor)
{
    return st_get_admin_actions_head(). 
        st_get_admin_action('send', __('Wyślij'), '@stPocztaPolskaBackend?action=packagesList&bufor_id='.$bufor->getBuforId()).
        st_get_admin_actions_foot();  

}

function st_poczta_polska_sent_list_actions(PocztaPolskaPaczka $paczka)
{
    return st_get_admin_actions_head(). 
        st_get_admin_action('printPdf', __('Etykieta', null, 'stPocztaPolskaBackend'), '@stPocztaPolskaBackend?action=downloadAddressLabel&paczka_id='.$paczka->getId()).
        st_get_admin_action('printPdf', __('Książka adresowa', null, 'stPocztaPolskaBackend'), '@stPocztaPolskaBackend?action=downloadOutboxBook&paczka_id='.$paczka->getId()).
        st_get_admin_action('more', __('Śledź przesyłkę', null, 'stPocztaPolskaBackend'), $paczka->getTrackingUrl()).
        st_get_admin_actions_foot();  

}

function st_poczta_polska_package_list_actions(PocztaPolskaPaczka $paczka)
{
    $page = sfContext::getInstance()->getRequest()->getParameter('page', 1);
    return st_get_admin_actions_head(). 
        st_get_admin_action('printPdf', __('Etykieta', null, 'stPocztaPolskaBackend'), '@stPocztaPolskaBackend?action=downloadAddressLabels&paczka_id='.$paczka->getId()).
        st_get_admin_action('printPdf', __('Blankiety pobrań', null, 'stPocztaPolskaBackend'), '@stPocztaPolskaBackend?action=downloadBlankietyPobrania&paczka_id='.$paczka->getId()).
        '<li style="padding-top: 5px"><a href="'.st_url_for('@stPocztaPolskaBackend?action=packagesDelete&id='.$paczka->getId().'&page='.$page).'" data-admin-confirm="'.__('Jesteś pewien?', null, 'stAdminGeneratorPlugin').'" data-admin-action="delete"><img src="/images/backend/beta/icons/16x16/remove.png" title="'.__('Usuń', null, 'stAdminGeneratorPlugin').'" class="tooltip"></a></li>'.
        st_get_admin_actions_foot();  

}

function st_poczta_polska_list_urzad_nadania(PocztaPolskaBufor $bufor)
{
    $client = stPocztaPolskaClient::getInstance();

    try
    {
        $options = $client->getUrzedyNadania();
    }
    catch(Exception $e)
    {
        $options = array();
    }

    return isset($options[$bufor->getUrzadNadania()]) ? $options[$bufor->getUrzadNadania()] : null;
}

function st_urzedy_nadania_select($name, $value)
{
    $request = sfContext::getInstance()->getRequest();
    
    if ($request->getMethod() == sfRequest::POST && $request->hasParameter('config'))
    {
        $data = $request->getParameter('config');
        $client = new stPocztaPolskaClient($data['login'], $data['password'], isset($data['test_mode']));        
    }
    else
    {
        $client = stPocztaPolskaClient::getInstance();
    }

    try
    {
        $disable_cache = $request->getMethod() == sfRequest::POST && $request->hasParameter('config');
        $options = $client->getUrzedyNadania(!$disable_cache);
    }
    catch(Exception $e)
    {
        $options = array();
    }  

    return select_tag($name, options_for_select($options, $value, array('include_custom' => __('Wybierz', null, 'stPocztaPolskaBackend'))));
}

function st_poczta_polska_profile_select($name, $value)
{
    $client = stPocztaPolskaClient::getInstance();

    $response = $client->getProfilList(new getProfileList());   
}

function st_poczta_polska_optional_input($name, $value, $options)
{
    return st_admin_optional_input($name, $value, $options);
}


function st_poczta_polska_rachunki($name, $value)
{
    $config = stConfig::getInstance('stPocztaPolskaBackend');

    $options = array();

    if ($config->get('rachunek1')) 
    {
        $options[str_replace(" ", "", $config->get('rachunek1'))] = $config->get('rachunek1');
    }

    if ($config->get('rachunek2')) 
    {
        $options[str_replace(" ", "", $config->get('rachunek2'))] = $config->get('rachunek2');
    }

    if ($config->get('rachunek3')) 
    {
        $options[str_replace(" ", "", $config->get('rachunek3'))] = $config->get('rachunek3');
    }

    return select_tag($name, options_for_select($options, $value));
}

function st_poczta_polska_punkt_odbioru($name, PocztaPolskaPunktOdbioru $pp)
{    
    $id = get_id_from_name($name);

    $widget_id = 'punkt_odbioru_'.uniqid();

    $content = input_tag($widget_id, !$pp->getPni() ? "" : $pp->getShortName(), array('readonly' => true, 'size' => 50));

    $content .= '<br><a href="#" id="'.$id.'_choose" style="vertical-align: middle">'.__('Zmień punkt odbioru', null, 'stPocztaPolskaBackend').'</a>';

    $content .= input_hidden_tag($name, !$pp->getPni() ? "" : json_encode($pp->getPoint()));

    $content .= '<script src="https://mapa.ecommerce.poczta-polska.pl/widget/scripts/ppwidget.js"></script>';

    $pobranie = intval($pp->isPobranie());

    $content .= "
    <script>
        jQuery(function($) {
            var pobranie = $pobranie;
            var input = $('#$id');
            var punkt = input.val() ? JSON.parse(input.val()) : null;
            var adres = punkt ? punkt['street']+', '+punkt['city'] : undefined;
            $('#{$id}_choose').click(function() {
                PPWidgetApp.toggleMap(function(point) {
                    $('#$widget_id').val(point['name']+', '+point['street']+' '+point['zipCode']+' '+point['city']);
                    input.val(JSON.stringify(point));
                }, pobranie, adres);
            });
        });
    </script>
    ";

    return $content;
}