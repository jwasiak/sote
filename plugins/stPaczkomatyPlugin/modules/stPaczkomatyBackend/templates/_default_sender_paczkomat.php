<?php use_helper('stPaczkomaty');
echo show_paczkomaty_dropdown_list('config[default_sender_paczkomat]', !$sf_request->hasParameter('config[default_sender_paczkomat]') ? $config->get('default_sender_paczkomat') : $sf_request->getParameter('config[default_sender_paczkomat]'), array('paczkomaty' => array('function' => 'ParcelSend')));
