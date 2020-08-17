<?php
/**
 * SOTESHOP/stBase
 *
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBase
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stActions.class.php 16774 2012-01-18 11:44:27Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa Akcji. Zastępienie akcji sfActions w modułach.
 *
 * @package     stBase
 * @subpackage  libs
 */
class stActions extends sfActions
{
    /**
     *
     * Lista aktualizacji elementów DOM HTML
     * 
     * @var array
     */
    protected $responseCalls = array();

    /**
     * Instancja obiektu event dispatcher
     * @var stEventDispatcher
     */
    protected $dispatcher = null;

    protected $sessionExpired = null;

    /**
     * Przekazanie instancji obiektu sfEventDispatcher do stActions
     *
     * @param        string      $context
     */
    public function initialize($context)
    {
        $this->dispatcher = $context->getController()->getDispatcher();

        $ret = parent::initialize($context);
        
        return $ret;
    }

    public function getTheme()
    {
        return $this->getController()->getTheme();
    }

    /**
     * Zwraca instancje obiektu sfEventDispatcher
     *
     * @return   sfEventDispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * Zadanie wykonywane przed akcją.
     */
    public function preExecute()
    {
        $request = $this->getRequest();
        
        if (SF_APP == 'backend' && !$request->isXmlHttpRequest() && stCommunication::blockSite() && !in_array($this->getModuleName().'/'.$this->getActionName(), array('stBackend/license', 'sfGuardAuth/signout', 'stLanguageBackend/changeLanguage')))
        {            
            return $this->forward('stBackend', 'license');
        }

        if (SF_APP == 'frontend')
        {
            if ($request->getMethod() != sfRequest::POST && !$request->isXmlHttpRequest() && stSecurity::hasSSL())
            {            
                $ssl = stSecurity::getSSL();

                if ($ssl == 'order' && $request->isSecure() && !in_array($this->getModuleName(), array('stOrder', 'stBasket', 'stUserData', 'stUser', 'stPayment', 'stEserviceFrontend', 'stCurrencyFrontend', 'stPaczkomatyFrontend')))
                {
                    return $this->redirect(str_replace('https://', 'http://', $request->getUri()));
                }
                elseif ($ssl == 'shop' && !$request->isSecure())
                {
                    return $this->redirect(str_replace('http://', 'https://', $request->getUri()), 301);
                } 
            }


            if (!$request->isXmlHttpRequest() && $this->clearProducer())
            {
                stProducer::clearSelectedProducerId();
            } 
        }

        $this->getContext()->getI18N()->setCurrentCatalogue($this->getModuleName());

        $this->dispatcher->notify(new sfEvent($this, 'stActions.preExecute'), array('moduleName' => $this->getModuleName()));
        $this->dispatcher->notify(new sfEvent($this, 'stActions.preExecute' . ucfirst($this->getActionName()), array('moduleName' => $this->getModuleName())));
        $this->dispatcher->notify(new sfEvent($this, $this->getActionClassName() . '.preExecute' . ucfirst($this->getActionName())));

        if (SF_APP == 'frontend' && $this->getUser()->isAuthenticated())
        {
            $pc = stPartialCache::getInstance($this->getContext());
            $pc->setCacheOption('stProduct', '_new', 'enabled', false);
            $pc->setCacheOption('stProduct', '_productGroup', 'enabled', false);
        }

        parent::preExecute();
    }

    /**
     * Sesja wygasła?
     *
     * @return boolean Zwraca true w przypadku gdy sesja wygasła
     */
    public function hasSessionExpired()
    {
        if (null === $this->sessionExpired)
        {
            $sessionCheck = $this->getRequest()->getCookie('session_check');

            $currentSessionCheck = $this->getUser()->getAttribute('session_check');

            $this->sessionExpired = $sessionCheck && $sessionCheck != $currentSessionCheck || !$sessionCheck;

            if ($this->sessionExpired)
            {
                $this->generateSessionCheck();
            }
        }

        return $this->sessionExpired;
    }

    /**
     *  Zadanie wykonywane po akcji.
     */
    public function postExecute()
    {
        $this->dispatcher->notify(new sfEvent($this, 'stActions.postExecute'), array('moduleName' => $this->getModuleName()));
        $this->dispatcher->notify(new sfEvent($this, 'stActions.postExecute' . ucfirst($this->getActionName()), array('moduleName' => $this->getModuleName())));
        $this->dispatcher->notify(new sfEvent($this, $this->getActionClassName() . '.postExecute' . ucfirst($this->getActionName())));

        if (SF_APP == 'frontend' && null !== $this->getUser()->getParameter('selected', null, 'soteshop/stCategory'))
        {
            $pc = stPartialCache::getInstance($this->getContext());
            $pc->setCacheOption('stProduct', '_new', 'enabled', false);
            $pc->setCacheOption('stProduct', '_productGroup', 'enabled', false);
        }        

        parent::postExecute();

        if (SF_APP == 'frontend')
        {
            $theme_config = $this->getTheme()->getTheme()->getThemeConfigCached();

            $layouts = $theme_config->getConfigParameter('layouts');

            $action = $this->getModuleName().'/'.$this->getActionName();

            if ($layouts && isset($layouts['actions'][$action]) && $layouts['actions'][$action])
            {
                $this->getTheme()->setLayoutName($layouts['actions'][$action]);
            }
            else 
            {
                $config = $theme_config->getDefaultConfig();

                if (isset($config['layouts'][$action]))
                {                    
                    $this->getTheme()->setLayoutName($config['layouts'][$action]);
                }
            }

            if (!$this->getRequest()->isXmlHttpRequest() && (!$this->getRequest()->getCookie('session_check') || $this->getRequest()->getCookie('session_check') === '1'))
            {
                $this->generateSessionCheck();
            }
        }



        if (SF_APP == 'frontend' && (stConfig::getInstance('stPositioningBackend')->get('noindex') || $this->getRequest()->isXmlHttpRequest() || $this->isNoIndexUrl()))
        {            
            $this->getResponse()->setHttpHeader('X-Robots-Tag', 'noindex');
            $this->getResponse()->addMeta('robots', 'noindex,nofollow');
        }
    }

    public function generateSessionCheck()
    {
        $id = uniqid();
        $this->getUser()->setAttribute('session_check', $id);
        $this->getResponse()->setCookie('session_check', $id);
    }

    /**
     * Sprawdza czy link jest blokowany przed indeksowaniem przez roboty
     * 
     * @return bool
     */
    protected function isNoIndexUrl()
    {
        $urls = array(
            '/user',
            '/basket',
            '/search',
            '/recommend_shop',
            '/currency',
            '/productsCompare',
            '/product_options',
            '/stNavigationFrontend',
            '/product/list/group_id',
            '/producer',
            '/navigation',
            '/invoice',
            '/discount',
            '/order',
            '/orderPdf',
            '/invoicePdf',
            '/stAvailabilityFrontend/showAddOverlay',
            '/stQuestionFrontend/showAddOverlay',
        );

        $urls = $this->dispatcher->filter(new sfEvent($this, 'stActions.filterNoIndexUrl'), $urls)->getReturnValue();

        $uri = $this->getRequest()->getUri();

        $parsedUrl = parse_url($uri);

        $shopUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . (SF_ENVIRONMENT == 'dev' ? $this->getRequest()->getScriptName() : '');

        $config = stConfig::getInstance('stPositioningBackend');

        if ($config->get('noindex_urls'))
        {
            $noIndexUrls = str_replace(array("\r", $shopUrl), '', $config->get('noindex_urls'));

            $noIndexUrls = preg_quote($noIndexUrls);
 
            $urls = array_merge($urls, array_filter(explode("\n", $noIndexUrls), function($value) {
                $value = trim($value);
                return !empty($value);
            }));
        }

        $shopUrl = preg_quote($shopUrl);

        $pattern = '@^(' . $shopUrl . implode("|" . $shopUrl, $urls) . ')@';

        return preg_match($pattern, $uri) > 0;
    }

    /**
     * Zwraca nazwe klasy dla aplikacji
     *
     * @return   string
     */
    protected function getActionClassName()
    {
        return (SF_APP == 'backend' ? 'auto' : '') . get_class($this);
    }

    /**
     *
     * Metoda pomocniczna dla ajaxUpdateElement
     *
     * @param <type> $html
     * @return <type>
     */
    protected function responseEscapeHtml($html)
    {
        $html = self::escapeHtml($html);

        return str_replace(array('//<![CDATA[', '//]]>'), array('', ''), $html);
    }

    /**
     *
     * Aktualizuje dowolny element HTML o podanym selektorze
     *
     * @param string $selector ID selektor elementu html 
     * @param mixed $content Zawartośc jaka ma zostać wstawiona do elementu DOM HTML
     *
     * przykład:
     *
     * // Aktualizacja elementu o id 'st_basket_list' komponentem 'list' z modulu 'stBasket' z parametrem 'basket_id'
     * $this->updateElement('#st_basket_list', array('module' => 'stBasket', 'component' => 'list', 'params' => array('basket_id' => 1)));
     *
     * // Aktualizacja elementu o id 'st_basket_list' partialem 'list' z modulu 'stBasket' z parametrem 'basket_id'
     * $this->updateElement('#st_basket_list', array('module' => 'stBasket', 'partial' => 'list', 'params' => array('basket_id' => 1)));
     *
     * // Aktualizacja elementu o id 'st_basket_list' dowolna zawartością
     * $this->updateElement('#st_basket_list', '<div>Dowolna zawartość</div>');
     *
     */
    public function responseUpdateElement($selector, $content)
    {
        if (is_array($content))
        {
            $this->loadHelpers();

            $params = isset($content['params']) ? $content['params'] : array();

            if (isset($content['partial']))
            {
                $content = st_get_partial($content['module'] . '/' . $content['partial'], $params);
            }
            elseif (isset($content['component']))
            {
                $content = st_get_component($content['module'], $content['component'], $params);
            }
            else
            {
                throw new sfException('Wrong syntax see ' . __FILE__ . ' for examples of updateElement() calls');
            }
        }

        if ($selector[0] != '.' && $selector[0] != '#')
        {
            $selector = '#'.$selector;
        }
        
        $this->responseCalls[] = sprintf('jQuery(\'%1$s\').html("%2$s");', $selector, $this->responseEscapeHtml($content));
    }

    public function getRenderComponent($module, $component, $parameters = array())
    {
        $this->loadHelpers();

        return st_get_component($module, $component, $parameters);
    }

    public function getRenderPartial($partial, $parameters = array())
    {
        $this->loadHelpers();

        return st_get_partial($partial, $parameters);
    }    

    public function responseNotificationMessage($message, $options = array())
    {
        $defaults = array(
            'type' => 'information',
            'layout' => 'center',
            'animateOpen' => array('opacity' => 'show'),
            'animateClose' => array('opacity' => 'hide'),
            'speed' => 500,
            'timeout' => 4000
        );

        $options = array_merge($defaults, $options);

        $options['text'] = $this->responseEscapeHtml($message);

        $this->responseEvalJs("noty(".json_encode($options).")");
    }

    public function responseEvalJs($javascript)
    {
        $this->responseCalls[] = $javascript;
    }
    
    /**
     *
     * Zwraca aktualizacje elementów DOM HTML do odpowiedzi Ajax
     *
     * @return sfView::NONE
     */
    public function renderResponse()
    {
        $this->postExecute();

        if (!empty($this->responseCalls) && $this->getRequest()->isXmlHttpRequest())
        {
            $this->getResponse()->setContentType('application/javascript');

            return $this->renderText(implode(";\n", $this->responseCalls));
        }
    }

    /**
     *
     * Appends json to the response content
     *
     * This method accept the same parameters as json_encode
     *
     * @param mixed $value The value to be encoded to json response
     * @return sfView::NONE
     */
    public function renderJSON($value)
    {
       $this->getResponse()->setContentType('application/json');

       return $this->renderText(json_encode($value));
    }

    public static function escapeHtml($html)
    {
      return preg_replace('/\r\n|\n|\r/', '', addslashes($html));
    }

    protected function loadHelpers()
    {
        static $helpers_loaded = false;

        if (!$helpers_loaded)
        {
            sfLoader::loadHelpers(array('Helper', 'Partial', 'stPartial'));

            $helpers_loaded = true;
        }        
    }

    protected function clearProducer()
    {
        $action = $this->getModuleName().'/'.$this->getActionName();

        if ($action == 'stProduct/list' && $this->hasRequestParameter('query'))
        {
            return true;
        }

        return !in_array($action, array('stProduct/list', 'stBasket/addReferer', 'stProduct/show'));
    }
}