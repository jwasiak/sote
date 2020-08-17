<?php
/**
 * SOTESHOP/stProduct 
 * 
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stFastCache
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 1031 2009-05-07 13:03:25Z krzysiek $
 */

/**
 * Komponenty stProduct
 *
 * @author Piotr Hałas <piotr.halas@sote.pl>
 *
 * @package     stFastCache
 * @subpackage  actions
 */
class stFastCacheComponents extends autoStFastCacheComponents
{
    public function executeFastCachePb()
    {
        $this->steps = stFastCacheSEO::getSteps();

        $parameters = array('class' => 'stFastCacheSEO',
                            'method' => 'step',
                            'steps' => $this->steps,
                            );

        $resume_file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'fastcache'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'fast_cache_running';
        $this->resume = 0;
        if (file_exists($resume_file ))
        {
            $data = sfYaml::load($resume_file);
            $this->resume = @$data['step'];
        }

        $this->getUser()->getAttributeHolder()->remove('stFastCacheSEO', 'soteshop/stProgressBarPlugin');
        $this->getUser()->setAttribute('stFastCacheSEO', $parameters, 'soteshop/stProgressBarPlugin');

        $timer =  new sfTimer();
        $timer->startTimer();
        $b = new sfWebBrowser(array(), null, array('ssl_verify' => false, 'ssl_verify_host' => false));
        $b->get("http://".sfContext::getInstance()->getRequest()->getHost().'/');
        $this->elapsed = $timer->addTime();
    }
    
    public function executeFastCachePriority()
    {
    	$product_count = ProductPeer::doCount(new Criteria());
    	
        $I18n = $this->getContext()->getI18N();
    	
	$this->priority = array('1 '    =>$I18n->__('Dla każdej strony').' '.($product_count<=1000?$I18n->__('(zalecana)'):''),
                                '0.50'  =>$I18n->__('Bardzo duża').' '.($product_count>1000 && $product_count<2000?$I18n->__('(zalecana)'):''),
                                '0.20'  =>$I18n->__('Duża').' '.($product_count>2001 && $product_count<5000?$I18n->__('(zalecana)'):''),
                                '0.10'  =>$I18n->__('Średnia').' '.($product_count>5000?$I18n->__('(zalecana)'):''));
    }
}
?>
