<?php
/**
 * SOTESHOP/stPositioningPlugin
 *
 * Ten plik należy do aplikacji stPositioningPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPositioningFilter.class.php 1611 2009-10-19 09:49:03Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPositioningFilter
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 */
class stPositioningFilter extends sfFilter
{
    /**
     * Wykonywanie filtra
     *
     * @param $filterChain
     */
    public function execute($filterChain)
    {
        $context = $this->getContext();
        $response = $context->getResponse();
        $config = stConfig::getInstance($context, 'stPositioningBackend');
        
        if ($config->get('redirect'))
        {
            $stWebRequest = new stWebRequest();
            if ($config->get('domain') != $stWebRequest->getHost())
            {
                $uri = str_replace($stWebRequest->getHost(), $config->get('domain'), $stWebRequest->getUriPrefix());

                if ($context->getUser()->getCulture() != sfConfig::get('sf_i18n_default_culture')) 
                {
                    $languages = LanguagePeer::doSelectActive();
                    foreach($languages as $language)
                    {
                        if ($language->getOriginalLanguage() == $context->getUser()->getCulture())
                        {
                            $userLanguage = $language->getShortcut();
                            break;
                        }
                    }
                    
                    if (isset($userLanguage) && !empty($userLanguage)) $uri = $uri."?lang=".$userLanguage;
                } 
                $context->getController()->redirect($uri, 0, 302);
            }
        }
        
        if ($this->isFirstCall())
        {
            $positioning = PositioningPeer::doSelectDefaultValues();

            if(is_object($positioning))
            {
                $positioning->setCulture(stLanguage::getHydrateCulture());                
                $response->setTitle($positioning->getTitle());
                $response->addMeta('keywords', $positioning->getKeywords());
                $response->addMeta('description', $positioning->getDescription());
            }
            
            if ($config->get('verify'))
            {
                $domain = new stWebRequest();
                $verifyDomains = $config->get('verify');
                $response->addMeta('google-site-verification', @$verifyDomains[$domain->getHost()]);
            }
        }
        
        $filterChain->execute();
    }
}
