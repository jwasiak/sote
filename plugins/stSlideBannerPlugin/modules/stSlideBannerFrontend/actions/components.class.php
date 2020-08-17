<?php
/**
 * SOTESHOP/stSlideBannerPlugin
 *
 * Ten plik należy do aplikacji stSearchPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stSlideBanner
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 3428 2010-02-10 11:48:32Z piotr $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Klasa stSearchFrontendComponents
 *
 * @package     stSlideBanerPlugin
 * @subpackage  actions
 */
class stSlideBannerFrontendComponents extends sfComponents
{
    /**
     * Komponent banera
     */
    public function executeShow()
    {
        $config = stConfig::getInstance('stSlideBannerBackend');

        if (!$config->get("banner_on"))
        {
            return sfView::NONE;
        }
        
        $c = new Criteria();

        if($config->get('ignore_language') != 1)
        {
            $c->add(SlideBannerPeer::OPT_CULTURE, $this->getUser()->getCulture());
        }
        
        
        if($config->get('group_field_on') == 1)
        {
             if (isset($this->group)){
                $c->add(SlideBannerPeer::GROUP_NAME, $this->group);    
             }else{
                $criterion = $c->getNewCriterion(SlideBannerPeer::GROUP_NAME, "");
                $criterion->addOr($c->getNewCriterion(SlideBannerPeer::GROUP_NAME, null));
                $c->add($criterion); 
             }     
                                
        }else{                        
            if (isset($this->group)){
                return sfView::NONE;
                // $c->add(SlideBannerPeer::GROUP_NAME, $this->group, Criteria::NOT_EQUAL);    
             }            
        }
                
        $c->add(SlideBannerPeer::IS_ACTIVE , 1);
        
        
        if(sfContext::getInstance()->getController()->getTheme()->getVersion() >= 7){
            
            $criterion = $c->getNewCriterion(SlideBannerPeer::BANNER_TYPE, 0);
            $criterion->addOr($c->getNewCriterion(SlideBannerPeer::BANNER_TYPE, 2));
            $c->add($criterion);    
                
        }else{
            $criterion = $c->getNewCriterion(SlideBannerPeer::BANNER_TYPE, 0);
            $criterion->addOr($c->getNewCriterion(SlideBannerPeer::BANNER_TYPE, 1));
            $c->add($criterion);
        }
        
        
        
        $c->addAscendingOrderByColumn('RANK');
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stSlideBannerComponents.preBannerQuery', array('criteria' => $c)));
        $banners = SlideBannerPeer::doSelect($c);

        if (!$banners)
        {
             return sfView::NONE;
        }

        $slide = stConfig::getInstance('stAsset')->get('slide');
        
        $this->smarty = new stSmarty('stSlideBannerFrontend');
        $this->smarty->assign('banners', $banners);
        $this->smarty->assign('banner_width', 'auto');
        $this->smarty->assign('banner_height', $slide['thumb']['height'].'px');
        $this->smarty->assign('banner_on' , 1);
        $this->smarty->assign('count', count($banners));
        $this->smarty->assign('group_name', trim($this->group));
        
        $this->config = $config;
    }
}