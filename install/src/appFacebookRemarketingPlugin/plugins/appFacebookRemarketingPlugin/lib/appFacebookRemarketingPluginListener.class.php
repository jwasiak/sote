<?php

/** 
 * SOTESHOP/appFacebookRemarketingPlugin
 * 
 * 
 * @package     appFacebookRemarketingPlugin
 * @author      Pawel Byszewski <pawel@apes-apps.com>
 */

class appFacebookRemarketingPluginListener
{
    public static function append(sfEvent $event, $components)
    {
        
        if ($event['slot']=='before_head_ends' || $event['slot']=='before-head-ends')
        {
            $components[] = $event->getSubject()->createComponent('appFacebookRemarketingFrontend', 'fbremarketing');
        }

        if ($event['slot']=='basket-ajax-added-product-preview')
        {
            $components[] = $event->getSubject()->createComponent('appFacebookRemarketingFrontend', 'fbAddTrack');
        }
        
        return $components;
    
    }
}