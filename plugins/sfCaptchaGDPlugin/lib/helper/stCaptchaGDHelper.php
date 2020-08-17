<?php
/**
 * Funkcje pomocnicze   
 *
 * @package stCaptchaGDPlugin
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 * @copyright SOTE
 * @license SOTE
 * @version $Id: stCaptchaGDHelper.php 11 2009-08-24 09:33:22Z michal $
 */

/**
 * Pobieranie obrazka z captchą
 *
 * @return string
 */
function get_captcha($imageWidth = '', $imageHeight = '')
{
    if (empty($imageWidth)) $imageWidth = sfConfig::get('app_sf_captchagd_image_width', 100);
    if (empty($imageHeight)) $imageHeight = sfConfig::get('app_sf_captchagd_image_height', 30);
    
    return '<img src="'.url_for('@stcaptchaGDPlugin').'?width='.$imageWidth.'&height='.$imageHeight.'">';
}