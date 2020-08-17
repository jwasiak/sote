<?php
/** 
 * SOTESHOP/stBlogPlugin 
 * 
 * Ten plik należy do aplikacji stBlogPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBlogPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 12100 2013-02-01 07:18:36Z pawel $
 * @author      Paweł Byszewski <pawel.byszewski@sote.pl>
 */

if (SF_APP == 'backend') {
	stPluginHelper::addEnableModule('stBlogBackend', 'backend');
    stPluginHelper::addRouting('stBlogPlugin', '/blog/:action/*', 'stBlogBackend', 'list', 'backend');   
    stPluginHelper::addRouting('blog', '/blog/:action/*', 'stBlogBackend', 'list', 'backend');    
}

if (SF_APP == 'frontend') {
	stPluginHelper::addEnableModule('stBlogFrontend', 'frontend');
    stPluginHelper::addRouting('blog', '/blog/:action/*', 'stBlogFrontend', 'list', 'frontend');
	stPluginHelper::addRouting('stBlogUrlLang', '/blog/:lang/:url.html', 'stBlogFrontend', 'show', 'frontend', array(), array('lang' => '[a-z]{2,2}'));
	stPluginHelper::addRouting('stBlogUrl', '/blog/:url.html', 'stBlogFrontend', 'show', 'frontend');

    stPluginHelper::addRouting('stBlogAllUrl', '/blog', 'stBlogFrontend', 'list', 'frontend', array('page' => 1));
    stPluginHelper::addRouting('stBlogAllUrlLang', '/blog/:lang', 'stBlogFrontend', 'list', 'frontend', array('page' => 1), array('lang' => '[a-z]{2,2}'));
    stPluginHelper::addRouting('stBlogCategoryUrl', '/blog/category/:url', 'stBlogFrontend', 'list', 'frontend', array('page' => 1), array('url' => '[a-z0-9-]+'));
    stPluginHelper::addRouting('stBlogCategoryUrlLang', '/blog/category/:lang/:url', 'stBlogFrontend', 'list', 'frontend', array('page' => 1),  array('lang' => '[a-z]{2,2}', 'url' => '[a-z0-9-]+'));
    stPluginHelper::addRouting('stBlogCategoryUrlLangPage', '/blog/category/:url/:page', 'stBlogFrontend', 'list', 'frontend', array(), array('page' => '[2-9]|\d{2,}', 'url' => '[a-z0-9-]+'));
    stPluginHelper::addRouting('stBlogCategoryUrlLangPage', '/blog/category/:lang/:url/:page', 'stBlogFrontend', 'list', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '[2-9]|\d{2,}', 'url' => '[a-z0-9-]+'));
    stPluginHelper::addRouting('stBlogAllUrlPage', '/blog/:page', 'stBlogFrontend', 'list', 'frontend', array(), array('page' => '[2-9]|\d{2,}'));

    stPluginHelper::addRouting('stBlogAllUrlLangPage', '/blog/:lang/:page', 'stBlogFrontend', 'list', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '[2-9]|\d{2,}'));
}