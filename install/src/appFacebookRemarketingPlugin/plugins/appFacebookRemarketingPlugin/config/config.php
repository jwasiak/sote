<?php
/** 
 * SOTESHOP/appFacebookRemarketingPlugin
 * 
 * 
 * @package     appFacebookRemarketingPlugin
 * @author      Pawel Byszewski <pawel@apes-apps.com>
 */

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('appFacebookRemarketingBackend', 'backend');
    stPluginHelper::addRouting('appFacebookRemarketingPlugin', '/facebook_pixel/*', 'appFacebookRemarketingBackend', 'index', 'backend');
    stConfiguration::addModule('appFacebookRemarketingPlugin', 'group_2');
}

if (SF_APP == 'frontend') {
    stPluginHelper::addEnableModule('appFacebookRemarketingFrontend', 'frontend');
    $dispatcher->connect('smarty.slot.append', array('appFacebookRemarketingPluginListener', 'append'));
}