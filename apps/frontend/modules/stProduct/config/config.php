<?php

stPluginHelper::addRouting('stProductCategoryLink', '/product/list/*', 'stProduct', 'list', 'frontend');

stPluginHelper::addRouting('stProduct', '/product/:action/*', 'stProduct', 'list', 'frontend');

stPluginHelper::addRouting('stProductShowImage', '/product/image/:folder/:image', 'stProduct', 'showImage', 'frontend');

stPluginHelper::addRouting('stProductUrlLang', '/:lang/:url.html', 'stProduct', 'show', 'frontend', array(), array('lang' => '[a-z]{2,2}'));

stPluginHelper::addRouting('stProductUrl', '/:url.html', 'stProduct', 'show', 'frontend');

stPluginHelper::addRouting('stProductUrlLang', '/:lang/:url.html', 'stProduct', 'show', 'frontend', array(), array('lang' => '[a-z]{2,2}'));

stPluginHelper::addRouting('stProductUrl', '/:url.html', 'stProduct', 'show', 'frontend');

stPluginHelper::addRouting('stProductSearchUrlLang1', '/product/:lang/search/:page/:type/:sort_by/:sort_order/:producer_filter', 'stProduct', 'list', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '\d+', 'sort_order' => 'asc|desc'));

stPluginHelper::addRouting('stProductSearchUrl1', '/product/search/:page/:type/:sort_by/:sort_order/:producer_filter', 'stProduct', 'list', 'frontend', array(), array('page' => '\d+', 'sort_order' => 'asc|desc'));

stPluginHelper::addRouting('stProductSearchUrlLang4', '/product/:lang/search', 'stProduct', 'list', 'frontend', array("page"=>1), array('lang' => '[a-z]{2,2}'));

stPluginHelper::addRouting('stProductSearchLinkUrlLang3', '/product/:lang/search/:query_url/:page', 'stProduct', 'list', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '[2-9]|\d{2,}', 'query_url' => '[a-z0-9-]+'));

stPluginHelper::addRouting('stProductSearchLinkUrlLang1', '/product/:lang/search/:query_url/:page/:type/:sort_by/:sort_order/:producer_filter', 'stProduct', 'list', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '\d+', 'sort_order' => 'asc|desc', 'query_url' => '[a-z0-9-]+'));

stPluginHelper::addRouting('stProductSearchLinkUrl1', '/product/search/:query_url/:page/:type/:sort_by/:sort_order/:producer_filter', 'stProduct', 'list', 'frontend', array(), array('page' => '\d+', 'sort_order' => 'asc|desc', 'query_url' => '[a-z0-9-]+'));

stPluginHelper::addRouting('stProductSearchLinkUrl4', '/product/search/:query_url', 'stProduct', 'list', 'frontend', array('page' => 1, 'query_url' => '[a-z0-9-]+'));

stPluginHelper::addRouting('stProductSearchLinkUrl3', '/product/search/:query_url/:page', 'stProduct', 'list', 'frontend', array(), array('page' => '[2-9]|\d{2,}', 'query_url' => '[a-z0-9-]+'));

stPluginHelper::addRouting('stProductSearchLinkUrlLang4', '/product/:lang/search/:query_url', 'stProduct', 'list', 'frontend', array("page"=>1), array('lang' => '[a-z]{2,2}', 'query_url' => '[a-z0-9-]+'));

stPluginHelper::addRouting('stProductSearchLinkUrlLang3', '/product/:lang/search/:query_url/:page', 'stProduct', 'list', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '[2-9]|\d{2,}', 'query_url' => '[a-z0-9-]+'));

stPluginHelper::addRouting('stProductSearchUrl4', '/product/search', 'stProduct', 'list', 'frontend', array('page' => 1));

stPluginHelper::addRouting('stProductSearchUrl3', '/product/search/:page', 'stProduct', 'list', 'frontend', array(), array('page' => '[2-9]|\d{2,}'));

stPluginHelper::addRouting('stProductCategoryUrlLang1', '/category/:lang/:url/:page/:type/:sort_by/:sort_order/:producer_filter', 'stProduct', 'list', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '\d+', 'sort_order' => 'asc|desc'));

stPluginHelper::addRouting('stProductCategoryUrl1', '/category/:url/:page/:type/:sort_by/:sort_order/:producer_filter', 'stProduct', 'list', 'frontend', array(), array('page' => '\d+', 'sort_order' => 'asc|desc'));

stPluginHelper::addRouting('stProductCategoryUrl4', '/category/:url', 'stProduct', 'list', 'frontend', array('page' => 1));

stPluginHelper::addRouting('stProductCategoryUrl3', '/category/:url/:page', 'stProduct', 'list', 'frontend', array(), array('page' => '[2-9]|\d{2,}'));

stPluginHelper::addRouting('stProductCategoryUrlLang4', '/category/:lang/:url', 'stProduct', 'list', 'frontend', array("page"=>1), array('lang' => '[a-z]{2,2}'));

stPluginHelper::addRouting('stProductCategoryUrlLang3', '/category/:lang/:url/:page', 'stProduct', 'list', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '[2-9]|\d{2,}'));


stPluginHelper::addRouting('stProductGroupUrlLang1', '/group/:lang/:url/:page/:type/:sort_by/:sort_order/:producer_filter', 'stProduct', 'groupList', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '\d+', 'sort_order' => 'asc|desc'));

stPluginHelper::addRouting('stProductGroupUrl1', '/group/:url/:page/:type/:sort_by/:sort_order/:producer_filter', 'stProduct', 'groupList', 'frontend', array(), array('page' => '\d+', 'sort_order' => 'asc|desc'));

stPluginHelper::addRouting('stProductGroupUrlLang2', '/group/:lang/:url/:page/:type/:sort_by/:sort_order', 'stProduct', 'groupList', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '\d+', 'sort_order' => 'asc|desc'));

stPluginHelper::addRouting('stProductGroupUrl2', '/group/:url/:page/:type/:sort_by/:sort_order', 'stProduct', 'groupList', 'frontend', array(), array('page' => '\d+', 'sort_order' => 'asc|desc'));

stPluginHelper::addRouting('stProductGroupUrl4', '/group/:url', 'stProduct', 'groupList', 'frontend', array('page' => 1));

stPluginHelper::addRouting('stProductGroupUrl3', '/group/:url/:page', 'stProduct', 'groupList', 'frontend', array(), array('page' => '[2-9]|\d{2,}'));

stPluginHelper::addRouting('stProductGroupUrlLang4', '/group/:lang/:url', 'stProduct', 'groupList', 'frontend', array("page"=>1), array('lang' => '[a-z]{2,2}'));

stPluginHelper::addRouting('stProductGroupUrlLang3', '/group/:lang/:url/:page', 'stProduct', 'groupList', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '[2-9]|\d{2,}'));

stPluginHelper::addRouting('stProductProducerCategoryUrlLang1', '/manufacturer/:lang/:producer/:url/:page/:type/:sort_by/:sort_order', 'stProduct', 'list', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '\d+', 'sort_order' => 'asc|desc'));

stPluginHelper::addRouting('stProductProducerCategoryUrl1', '/manufacturer/:producer/:url/:page/:type/:sort_by/:sort_order', 'stProduct', 'list', 'frontend', array(), array('page' => '\d+', 'sort_order' => 'asc|desc'));

stPluginHelper::addRouting('stProductProducerCategoryUrl4', '/manufacturer/:producer/:url', 'stProduct', 'list', 'frontend', array('page' => 1));

stPluginHelper::addRouting('stProductProducerCategoryUrl3', '/manufacturer/:producer/:url/:page', 'stProduct', 'list', 'frontend', array(), array('page' => '[2-9]|\d{2,}'));

stPluginHelper::addRouting('stProductProducerCategoryUrlLang4', '/manufacturer/:lang/:producer/:url', 'stProduct', 'list', 'frontend', array("page"=>1), array('lang' => '[a-z]{2,2}'));

stPluginHelper::addRouting('stProductProducerCategoryUrlLang3', '/manufacturer/:lang/:producer/:url/:page', 'stProduct', 'list', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '[2-9]|\d{2,}'));

stPluginHelper::addRouting('stProductProducerUrlLang', '/manufacturer/:lang/:producer/:url.html', 'stProduct', 'show', 'frontend', array(), array('lang' => '[a-z]{2,2}'));

stPluginHelper::addRouting('stProductProducerUrl', '/manufacturer/:producer/:url.html', 'stProduct', 'show', 'frontend');

stPluginHelper::addRouting('stProducerUrlLang1', '/manufacturer/:lang/:url/:page/:type/:sort_by/:sort_order', 'stProduct', 'producerList', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '\d+', 'sort_order' => 'asc|desc'));

stPluginHelper::addRouting('stProducerUrl1', '/manufacturer/:url/:page/:type/:sort_by/:sort_order', 'stProduct', 'producerList', 'frontend', array(), array('page' => '\d+', 'sort_order' => 'asc|desc'));

stPluginHelper::addRouting('stProducerUrl4', '/manufacturer/:url', 'stProduct', 'producerList', 'frontend', array('page' => 1));

stPluginHelper::addRouting('stProducerUrl3', '/manufacturer/:url/:page', 'stProduct', 'producerList', 'frontend', array(), array('page' => '[2-9]|\d{2,}'));

stPluginHelper::addRouting('stProducerUrlLang4', '/manufacturer/:lang/:url', 'stProduct', 'producerList', 'frontend', array("page"=>1), array('lang' => '[a-z]{2,2}'));

stPluginHelper::addRouting('stProducerUrlLang3', '/manufacturer/:lang/:url/:page', 'stProduct', 'producerList', 'frontend', array(), array('lang' => '[a-z]{2,2}', 'page' => '[2-9]|\d{2,}'));

stPluginHelper::addRouting('stProductDownloadAttachment', '/product/attachment/:folder/:culture/:filename', 'stProduct', 'downloadAttachment', 'frontend');