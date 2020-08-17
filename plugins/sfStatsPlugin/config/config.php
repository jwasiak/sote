<?php
/**
 * Konfiguracja modułu sfStatsPlugin
 *
 * @package sfStatsPlugin
 * @author Paweł Byszewski <pawel.byszewski@sote.pl>
 * @copyright SOTE
 * @license SOTE
 * @version SVN: $Id: config.php 2642 2008-12-03 08:15:55Z pawel $
 */

/**
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('sfStats', 'backend');

/**
 * Dodawanie routingów
 */

stPluginHelper::addRouting('stStatsPlugin', '/raports/:action/*', 'sfStats', 'list', 'backend');
stPluginHelper::addRouting('raports', '/raports/:action/*', 'sfStats', 'list', 'backend');
stPluginHelper::addRouting('raports/config', '/raports/:action/*', 'sfStats', 'list', 'backend');