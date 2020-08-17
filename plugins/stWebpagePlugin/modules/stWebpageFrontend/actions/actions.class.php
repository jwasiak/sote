<?php
/**
 * SOTESHOP/stWebpagePlugin
 *
 * Ten plik należy do aplikacji stWebpagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWebpagePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 1505 2009-10-14 15:56:57Z marcin $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/**
 * Akcje webpage.
 *
 * @author Krzysztof Beblo <krzysztof.beblo@sote.pl>
 *
 * @package     stWebpagePlugin
 * @subpackage  actions
 */
class stWebpageFrontendActions extends stActions
{
/**
 * Pokazuje stronę www
 */
    public function executeIndex()
    {
        $this->smarty = new stSmarty($this->getModuleName());

        if (!$this->process301Redirects())
        {
            $this->getUser()->setParameter('status-404', true);

            return $this->forward('stWebpageFrontend', 'list');
        }

        if (!$this->processFriendlyUrl())
        {
            $this->getUser()->setParameter('status-404', true);

            return $this->forward('stWebpageFrontend', 'list');
        }

        sfLoader::loadHelpers(array('Helper', 'stUrl'));

        $this->getResponse()->setCanonicalLink(st_url_for('stWebpageFrontend/index?url='.$this->webpage->getFriendlyUrl(), true, null, stLanguage::getInstance($this->getContext())->getDomain()));

    }

    public function executeAjax()
    {
        $state = $this->getRequestParameter('state', 'SHIPPING');

        $webpage = WebpagePeer::retrieveByState($state); 
        
        if(!$this->getRequest()->isXmlHttpRequest()){  

            $this->getResponse()->setStatusCode(404);

            $this->getResponse()->setHttpHeader('Status', '404 Not Found');

            return $this->forward('stErrorFrontend', 'error404');
        }

        if (null === $webpage)
        {
            return sfView::NONE;
        }

        $this->smarty = new stSmarty($this->getModuleName());
        $this->smarty->assign('webpage', $webpage);
        $this->setLayout(false);
    }

    /**
     * Lista wszystkich stron www
     */
    public function executeList()
    {
        if ($this->getUser()->hasParameter('status-404'))
        {
            $this->getResponse()->setStatusCode(404);

            $this->getResponse()->setHttpHeader('Status', '404 Not Found');
        }
        
        $this->smarty = new stSmarty($this->getModuleName());

        $c = new Criteria();

        $c->add(WebpagePeer::ACTIVE, 1);
        
        $this->webpages = WebpagePeer::doSelect($c);
    }

    protected function process301Redirects()
    {
        if ($this->hasRequestParameter('webpage_id'))
        {
            sfLoader::loadHelpers(array('Helper','stUrl'));

            $webpage_id = $this->getRequestParameter('webpage_id');

            $webpage = WebpagePeer::retrieveByPK($webpage_id);

            if (is_null($webpage))
            {
                return false;
            }

            $webpage->setCulture($this->getUser()->getCulture());

            return $this->redirect(st_url_for('stWebpageFrontend/index?url='.$webpage->getFriendlyUrl(), true), 301);
        }

        return true;
    }

    protected function processFriendlyUrl()
    {
        if ($this->getRequest()->hasParameter('url'))
        {
            $url = $this->getRequest()->getParameter('url');

            $this->webpage = WebpagePeer::retrieveByUrl($url);

            if ($this->webpage && $this->webpage->getActive())
            {
                $this->getUser()->setParameter('selected', $this->webpage, 'soteshop/stWebpage');

                $this->webpage->setCulture($this->getUser()->getCulture());

                if ($url != $this->webpage->getFriendlyUrl())
                {
                    sfLoader::loadHelpers(array('Helper','stUrl'));

                    $r = sfRouting::getInstance();

                    list(,$redirect) = $this->getController()->convertUrlStringToParameters($r->getCurrentInternalUri());

                    $redirect['url'] = $this->webpage->getFriendlyUrl();

                    $this->redirect(st_url_for($redirect, true) , 301);
                }
            }
            else
            {
                return false;
            }
        }

        return true;
    }
}