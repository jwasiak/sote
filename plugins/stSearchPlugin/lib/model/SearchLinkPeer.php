<?php

/**
 * Subclass for performing query and update operations on the 'st_search_link' table.
 *
 * 
 *
 * @package plugins.stSearchPlugin.lib.model
 */ 
class SearchLinkPeer extends BaseSearchLinkPeer
{
    /**
     * Zwraca instancje modelu SearchLink po linku url
     *
     * @param string $url
     * @param string $culture
     * @return SearchLink
     */
    public static function retrieveByUrl($url, $culture)
    {
        $c = new Criteria();
        $c->add(SearchLinkI18nPeer::URL, $url);
        $c->add(SearchLinkI18nPeer::CULTURE, $culture);
        $c->setLimit(1);
        $results = self::doSelectWithI18n($c);

        return $results ? $results[0] : null;
    }
}
