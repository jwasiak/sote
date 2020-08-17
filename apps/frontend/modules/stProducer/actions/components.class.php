<?php
/**
 * SOTESHOP/stProducer 
 * 
 * Ten plik należy do aplikacji stProducer opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProducer
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 978 2009-05-05 11:11:36Z krzysiek $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>  
 */

/**
 * Klasa stProducerComponents
 *
 * @package     stProducer
 * @subpackage  actions
 */
class stProducerComponents extends sfComponents
{

    /**
     * Lista wszystkich producentów
     *
     */
    public function executeList()
    {
        $this->smarty = new stSmarty('stProducer');
        
        $config = stConfig::getInstance(sfContext::getInstance(), 'stProducer');
        
        if (!$config->get('show_select_above_category'))
        {
           return sfView::NONE;
        }  
                     
        $producers = ProducerPeer::doSelectActiveArrayCached($this->getUser()->getCulture());

        if (!$producers)
        {
           return sfView::NONE;         
        }

        $this->producers = array();

        foreach ($producers as $id => $producer)
        {
            $this->producers[$id] = $producer['name'];
        }
        
        $this->selected = stProducer::getSelectedProducerId();
    }

    /**
     * Filtrowanie kategorii po producentach
     * @deprecated 
     */
    public function executeCategoryFilter()
    {
        $this->smarty = new stSmarty('stProducer');
        
        $config = stConfig::getInstance(sfContext::getInstance(), 'stProducer');
    
        $this->show_filter_in_category = $config->get('show_filter_in_category');    
        
        $this->producers = ProductHasCategoryPeer::retrieveProducersByCategory($this->category_id);

        $this->chosen_producer = $this->getUser()->getAttribute('producer_filter', null, 'soteshop/stProduct');

        // disable Fast Cache for this session if currency is different that default
        stFastCacheController::disable();
       
    }

    public function executeInfo()
    {
        $this->smarty = new stSmarty('stProducer');
    }

    public static function getProducerOptions()
    {
        $producers = array();

        foreach (ProducerPeer::doSelectActiveArrayCached(sfContext::getInstance()->getUser()->getCulture()) as $id => $producer)
        {
            $producers[$id] = $producer['name'];
        }
        
        return $producers;       
    }
}