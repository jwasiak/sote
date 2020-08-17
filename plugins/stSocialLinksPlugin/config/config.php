<?php
/** 
 * Enabling frontend and backend modules
 */
stPluginHelper::addEnableModule('stSocialLinksFrontend', 'frontend');
stPluginHelper::addEnableModule('stSocialLinksBackend', 'backend');

/** 
 * Adding nessesary Routing
 */
stPluginHelper::addRouting('stSocialLinksPlugin', '/sociallinks/*', 'stSocialLinksBackend', 'index', 'backend');


/**
 * Adding to configuration
 */
stConfiguration::addModule('stSocialLinksPlugin', 'group_2');