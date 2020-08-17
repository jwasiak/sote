<?php

/**
 * Subclass for performing query and update operations on the 'st_language_has_domain' table.
 *
 *
 *
 * @package plugins.stLanguagePlugin.lib.model
 */
class LanguageHasDomainPeer extends BaseLanguageHasDomainPeer
{
    protected static $allLanguageHasDomain = null;

    protected static $languageByShortcut = array();
    
    public static function doSelectAll($con = null)
    {
        if (!is_null(self::$allLanguageHasDomain))
        {
            return self::$allLanguageHasDomain;
        } else {
            $stCache = new stFunctionCache('stLanguagePlugin');
            self::$allLanguageHasDomain = $stCache->add('allLanguageHasDomain',"LanguageHasDomainPeer::doSelectJoinLanguage", new Criteria(), $con);
            return self::$allLanguageHasDomain; 
        }
        return null;
    }

    public static function doSelectByDomain($domain, $con = null)
    {
        $all = self::doSelectAll($con);
        foreach ($all as $key => $languageHasDomain)
        {
            if ($languageHasDomain->getDomain() == $domain) return $languageHasDomain;
        }
    }

    public static function doSelectByLanguageShortcut($shortcut, $con = null)
    {
        if (!isset(self::$languageByShortcut[$shortcut]))
        {
            $domains = array();

            foreach (self::doSelectAll($con) as $domain)
            {
                if ($domain->getLanguage()->getActive() && $domain->getLanguage()->getShortcut() == $shortcut)
                {
                    $domains[] = $domain;
                }
            }
            
            $event = new sfEvent($domains, 'stLanguageHasDomain.doSelectByLanguageShortcut', array());
            stEventDispatcher::getInstance()->notify($event);

            if ($event->getReturnValue() != null)
            {
                $domains = $event->getReturnValue();
            } 

            self::$languageByShortcut[$shortcut] = $domains;
        }
        
        return self::$languageByShortcut[$shortcut];
    }
}