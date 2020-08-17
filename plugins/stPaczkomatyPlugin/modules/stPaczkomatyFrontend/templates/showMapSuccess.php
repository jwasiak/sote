<?php
$smarty->assign('machinesNamespace', $machinesNamespace);
$messages = array(__('Wybierz Paczkomat'),
                  __('Zmień Paczkomat'),
                  __('Dostawa Paczkomaty'),
                  __('Proszę wybrać Paczkomat.'),
                  __('Paczkomat'),
            );
$smarty->assign('messages', json_encode($messages));
$smarty->assign('configMapGroupPoints', $config->get('map_group_points'));
$smarty->display('paczkomaty_show_map.html');
