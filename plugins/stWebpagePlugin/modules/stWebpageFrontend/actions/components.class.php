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
 * @version     $Id: components.class.php 14301 2011-07-26 10:59:10Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/**
 * Akcje komponentu webpage
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>
 *
 * @package     stWebpagePlugin
 * @subpackage  actions
 */
class stWebpageFrontendComponents extends sfComponents
{
    protected static $firstCall = true;

    protected static $linkIncludeOnce = true;
    
    /**
     * Wyświetlenie grup stron www
     */
    public function executeGroupWebpage()
    {

        $this->smarty = new stSmarty('stWebpageFrontend');

        if ($this->id || $this->group_page)
        {
            if ($this->group_page=='HEADER' && $this->getController()->getTheme()->getVersion() <= 2)
            {
                return sfView::NONE;
            }

            if($this->group_page=='HEADER' || isset($this->in_line))
            {

                if (!self::$firstCall) 
                {
                    return sfView::NONE;
                }

                self::$firstCall = false;

            }

            $c = new Criteria();
            if($this->id)
            {
                $c->add(WebpageGroupPeer::ID,$this->id);
            }
            else
            {
                $c1 = $c->getNewCriterion(WebpageGroupPeer::GROUP_PAGE,$this->group_page);

                if($this->group_page=='HEADER')
                {
                    $c2 = $c->getNewCriterion(WebpageGroupPeer::SHOW_HEADER,1);
                    $c1->addOr($c2);
                }
                elseif($this->group_page=='FOOTER')
                {
                    $c2 = $c->getNewCriterion(WebpageGroupPeer::SHOW_FOOTER,1);
                    $c1->addOr($c2);
                }
                $c->add($c1);
            }
            
            $c->addJoin(WebpageGroupHasWebpagePeer::WEBPAGE_ID, WebpagePeer::ID);
            $c->addJoin(WebpageGroupHasWebpagePeer::WEBPAGE_GROUP_ID, WebpageGroupPeer::ID);
            $c->add(WebpagePeer::ACTIVE,1);
            $c->addAscendingOrderByColumn('RANK');
            stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stWebpageFrontendComponents.preWebpageQuery',array('criteria'=>$c)));
            $this->webpages = WebpagePeer::doSelect($c);

            if (!empty($this->webpages))
            {
                $this->webpage_group_relations=WebpageGroupHasWebpagePeer::doSelectJoinAll($c);
                $this->webpage_group=$this->webpage_group_relations[0]->getWebpageGroup()->getName();
                $this->id = $this->id;
            }



        }

    }

    /**
     * Wyświetlenie stopki
     */
    public function executeFooterWebpage()
    {
        $this->smarty = new stSmarty('stWebpageFrontend');
        $c = new Criteria();
        $c ->add(WebpageGroupPeer::SHOW_FOOTER, 1);
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stWebpageFrontendComponents.preFooterQuery',array('criteria'=>$c)));
        $this->webpages_groups = WebpageGroupPeer::doSelect($c);
    }

    /**
     * Wyświetlenie nagłówka
     */
    public function executeHeaderWebpage()
    {

        $this->smarty = new stSmarty('stWebpageFrontend');
        $c = new Criteria();
        $c ->add(WebpageGroupPeer::SHOW_HEADER, 1);
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stWebpageFrontendComponents.preHeaderQuery',array('criteria'=>$c)));
        $this->webpages_group = WebpageGroupPeer::doSelectOne($c);
    }

    public function executeLink()
    {
        $smarty = new stSmarty('stWebpageFrontend');
        $smarty->assign('url', $this->getController()->genUrl('@webpage?action=ajax&state='.$this->state));
        $smarty->assign('label', __($this->label));
        $smarty->assign('id', strtolower(str_replace('_', '-', $this->state)));
        $smarty->assign('include_once', self::$linkIncludeOnce);
        self::$linkIncludeOnce = false;
        return $smarty;
    }

    public function executeLinkterms()
    {
        $smarty = new stSmarty('stWebpageFrontend');
        $smarty->assign('url', $this->getController()->genUrl('@webpage?action=ajax&state='.$this->state));
        $smarty->assign('label', __($this->label));
        $smarty->assign('id', strtolower(str_replace('_', '-', $this->state)));
        $smarty->assign('include_once', self::$linkIncludeOnce);
        self::$linkIncludeOnce = false;
        return $smarty;
    }
}
