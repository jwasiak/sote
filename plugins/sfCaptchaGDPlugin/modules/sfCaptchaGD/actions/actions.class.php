<?php

require_once(dirname(__FILE__).'/../../../lib/sfCaptchaGD.class.php');

/**
 * Captcha actions.
 *
 * @package    sfCaptchaGD
 * @subpackage sfCaptchaGDActions
 * @author     Alex Kubyshkin <glint@techinfo.net.ru>
 * @version
 */
class sfCaptchaGDActions extends sfActions
{
    /**
     * Output captcha image
     *
     */
    public function executeGetImage()
    {
        $width = $this->getRequestParameter('width');
        $height = $this->getRequestParameter('height');

        $captcha = new sfCaptchaGD($width, $height);
        //    if (! $this->getRequest()->hasError('captcha')){
        //      $captcha->generateImage($this->getUser()->getAttribute('captcha'));
        //    } else {
        $captcha->generateImage();
        //    }
        $this->getUser()->setAttribute('captcha', $captcha->securityCode);

        $response = $this->getResponse();

        $response->setHttpHeader('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->setHttpHeader('Pragma', 'no-cache');         

        return sfView::HEADER_ONLY;
    }
}
