<?php
stPluginHelper::addEnableModule('sfCombineFilter', 'frontend');
stPluginHelper::addRouting('sfCombineFilterCss', '/combined/:cachefilename/:lastmodified.css', 'sfCombineFilter', 'download', 'frontend', array('type' => 'css'));
stPluginHelper::addRouting('sfCombineFilterJs', '/combined/:cachefilename/:lastmodified.js', 'sfCombineFilter', 'download', 'frontend', array('type' => 'js'));
