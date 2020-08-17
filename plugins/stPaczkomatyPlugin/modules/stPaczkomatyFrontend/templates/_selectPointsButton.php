<?php
if ($config->get('map_group_points'))
    use_javascript('markerclusterer.min.js');
use_javascript('jquery.ui.map.full.min.js'); 
use_javascript('jquery.mask.min.js'); 
use_javascript('stPaczkomatyPlugin/stPaczkomatyPlugin.js'); 
st_theme_use_stylesheet('stPaczkomatyPlugin.css');

$smarty->assign('mapJsUrl', 'https://maps.google.com/maps/api/js?sensor=true&key=AIzaSyDWeAHDfEfopR31qXHeIbF7XcQsRxm1aTQ');
$messages = array(__('Wybierz Paczkomat'),
                  __('Zmień Paczkomat'),
                  __('Dostawa Paczkomaty'),
                  __('Proszę wybrać Paczkomat.'),
                  __('Paczkomat'),
            );
$smarty->assign('messages', json_encode($messages));
$smarty->assign('mapUrl', url_for('stPaczkomatyFrontend/showMap'));
$smarty->assign('number', $number);
$smarty->display('paczkomaty_select_points_button.html');
