<?php
/** 
 * SOTESHOP/stSmartyPlugin
 * 
 * 
 * @package     stSmartyPlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stSmartyFrontend', 'frontend');

/**
 * Routingi
 */

stPluginHelper::addRouting('stSmartyPlugin', '/smartyFrontend/:action/*', 'stSmartyFrontend', 'index', 'frontend');