<?php

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('stGoogleShoppingBackend', 'backend');
    stPluginHelper::addRouting('stGoogleShoppingPlugin', '/google_shopping/:action/*', 'stGoogleShoppingBackend', 'list', 'backend');
    stPluginHelper::addRouting('stGoogleShoppingPluginDefault', '/google_shopping', 'stGoogleShoppingBackend', 'list', 'backend');
    stSocketView::addComponent('stGoogleShoppingBackend.generateCustom.Content', 'stGoogleShoppingBackend', 'generateXml');
    $dispatcher->connect('stAdminGenerator.generateStProduct', array('stGoogleShoppingPluginListener', 'generate'));
    $dispatcher->connect('autoStProductActions.postGetGoogleShoppingOrCreate', array('stGoogleShoppingPluginListener', 'postGetGoogleShoppingOrCreate'));
    $dispatcher->connect('stAdminGenerator.generateStProduct', array('stGoogleShoppingPluginListener', 'generateStProduct'));            
}

if (floatval(phpversion()) >= 7.1)
{
stTaskConfiguration::addTask(
'googleshopping_task', // unikalne id zadania 
'stGoogleShoppingTask', // klasa zadania
'Generowanie pliku dla Google Shopping', // Nazwa zadania jaka będzie wyświetlana w panelu lub w logach
    array(
        'time_interval' => stTaskConfiguration::TIME_INTERVAL_6HOURS, // odstęp czasowy
        'is_system' => true, // zadanie systemowe nie może być zmieniane przez użytkownika
    )
);
}