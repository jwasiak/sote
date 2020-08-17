<?php
/**
 * Plik z konfiguracją stRSSPlugin
 * 
 * @package stRSSPlugin
 * @author Karol Blejwas <karol.blejwas@sote.pl>
 * @copyright SOTE
 * @license SOTE
 * @version $Id: config.php 2092 2008-11-18 19:28:41Z michal $
 */

stPluginHelper::addEnableModule('stRSSFrontend', 'frontend');

stPluginHelper::addRouting('stRSSFrontend', '/feed/:action/*', 'stRSSFrontend', 'products', 'frontend');
stPluginHelper::addRouting('stRSSFrontend', '/feed/:action/*', 'stRSSFrontend', 'new', 'frontend');
stPluginHelper::addRouting('stRSSFrontend', '/feed/:action/*', 'stRSSFrontend', 'promotion', 'frontend');