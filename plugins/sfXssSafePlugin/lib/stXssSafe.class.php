<?php
/**
 * Plik z klasa stXssSafe
 * 
 * @package stXssSafePlugin
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 * @copyright SOTE
 * @license SOTE
 * @version 
 */

/**
 * Klasa stXssSafe
 *
 * @package stXssSafePlugin
 */
class stXssSafe
{
    /**
     * Remove dirt from html
     *
     * @param string $dirtyHtml
     * @return string clean Html
     */
    static public function cleanHtml($dirtyHtml)
    {
        sfLoader::loadHelpers('XssSafe');
        return esc_xsssafe($dirtyHtml);
    }
    
	public static function clean($value)
	{
        $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
        
        return str_replace('&amp;', '&', $value);
	}  
}