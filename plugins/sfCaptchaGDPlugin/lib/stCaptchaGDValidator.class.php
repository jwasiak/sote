<?php
/**
 * Plik z klasa stCaptchaGDValidator
 * 
 * @author Bartosz Alejski <bartosz.alejski@sote.pl>
 * @package stCaptchaGDPlugin
 * @license SOTE
 * @copyright SOTE
 * @version
 */

/**
 * Klasa stCaptchaGDValidator
 *
 * @package stCaptchaGDPlugin
 */
class stCaptchaGDValidator extends sfCaptchaGDValidator
{
    public function execute (&$value, &$error)
    {
        $captcha = $value;

        $session_captcha = $this->getParameter('captcha_ref');

        if(!stConfig::getInstance($this->getContext(), 'stSecurityBackend')->get('captcha_on'))
        {
            return true;
        }elseif(!$captcha || $captcha != $session_captcha){
            //sfContext::getInstance()->getUser()->setAttribute('captcha', NULL);
            $error = $this->getParameter('captcha_error');
            return false;
        }

        

        return true;
    }
}