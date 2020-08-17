<?php

stPluginHelper::addRouting('stUpdateGadget', '/update_gadget/:action/*', 'stUpdateGadget', 'update', 'backend');

$gadget = array('category' => 'Różne',
                'thumb' => '/images/backend/main/icons/stDefaultApp.png',
                'refresh' => 1800,
                'author' => array('name' => 'SOTE', 'website' => 'http://www.sote.pl'),
                'title' => 'Aktualizacje SOTESHOP',
                'description' => 'Element pokazujący dostępność aktualizacji dla sklepu SOTESHOP.',
                'source' => '@stUpdateGadget?action=update',
                'min_height' => 100,
                'max_height' => 150
                );

$dashboard = array_merge(sfConfig::get('app_dashboard_gadget_directory'), array('update' => $gadget));
sfConfig::set('app_dashboard_gadget_directory', $dashboard);
