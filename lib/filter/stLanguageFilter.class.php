<?php
/**
 * SOTESHOP/stLanguagePlugin
 *
 * Ten plik należy do aplikacji stLanguagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLanguagePlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stLanguageFilter.class.php 16153 2011-11-17 09:39:02Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stLanguageFilter
 *
 * @package     stLanguagePlugin
 * @subpackage  libs
 */
class stLanguageFilter extends sfFilter
{
    /**
     * Wykonywanie filtra
     *
     * @param $filterChain
     */
    public function execute($filterChain)
    {

        $context = sfContext::getInstance();
        
        if ($this->isFirstCall() && $context->getModuleName()!='stPaypalFrontend' && !$context->getRequest()->isXmlHttpRequest() && $context->getRequest()->getMethod() != sfRequest::POST)
        {
            $context = $this->getContext();

            $request = $this->getContext()->getRequest();
            
            if ($request->hasParameter('lang'))
            {
                $shortcut = $request->getParameter('lang');
                $language = LanguagePeer::retrieveByShortcut($shortcut);

                if ($language)
                {
                    $this->changeLanguage($language);
                    $host = stLanguage::getInstance($context)->hasLangParameterInUrl($shortcut, true);

                    if ($host)
                    {
                        sfLoader::loadHelpers(array('Helper','stUrl'));
                        $r = sfRouting::getInstance();
                        list(,$redirect) = $context->getController()->convertUrlStringToParameters($r->getCurrentInternalUri());
                        unset($redirect['lang']);
                        $redirect_url = st_url_for($redirect, true, null, $host);
    
                        if ($redirect_url != $context->getRequest()->getUri())
                        {
                            $context->getController()->redirect($redirect_url, 0, 301);
                            exit();
                        }
                    }
                }
            }
            else
            {
                $c = new Criteria();
                $c->add(LanguageHasDomainPeer::DOMAIN, $request->getHost());
                $c->addJoin(LanguageHasDomainPeer::LANGUAGE_ID, LanguagePeer::ID);
                $language = LanguagePeer::doSelectOne($c);

                if ($language && $context->getUser()->getAttribute('lang.host') != $request->getHost()) 
                {
                    $this->changeLanguage($language);
                } 
            }

            stLanguage::getInstance($context)->setPath(sfRouting::getInstance()->getCurrentInternalUri());
        }
        elseif ($context->getRequest()->isXmlHttpRequest())
        {
            $context = $this->getContext();

            $request = $this->getContext()->getRequest();
            
            if ($request->hasParameter('lang'))
            {
                $shortcut = $request->getParameter('lang');
                $language = LanguagePeer::retrieveByShortcut($shortcut);

                if ($language)
                {
                    $this->changeLanguage($language);
                }
            }            
        }
        
        $filterChain->execute();
    }

    protected function changeLanguage(Language $language)
    {
        $context = $this->getContext();
        $request = $context->getRequest();

        stLanguage::changeLanguageByShortcut($language->getShortcut());

        if ($context->getUser()->getCulture() != $context->getUser()->getAttribute('currencyLanguage'))
        {
            $this->changeCurrency($language);
        }

        $context->getUser()->setAttribute('lang.shortcut', $language->getShortcut());
        $context->getUser()->setAttribute('lang.host', $request->getHost());        
    }

    /**
     * Zmiana waluty
     *
     */
    protected function changeCurrency(Language $language)
    {
        $context = $this->getContext();

        $context->getUser()->setAttribute('currencyLanguage', $context->getUser()->getCulture());

        $stCurrency = stCurrency::getInstance($context);

        if ($language->getCurrencyId()) {
            $currency = CurrencyPeer::retrieveByPK($language->getCurrencyId());
            if (is_object($currency) && $currency->getActive()) {
                $currencyId = $currency->getId();
            } else {
                $currencyId = $stCurrency->getMainCurrency()->getId();
            }
        } else {
            $currencyId = $stCurrency->getMainCurrency()->getId();
        }
        
        $stCurrency->set($currencyId);

        stEventDispatcher::getInstance($context)->notify(new sfEvent($this, 'stLanguageFilter.changeCurrency', array('currency' => $stCurrency)));

        stBasketListener::refreshBasket();
    }
}