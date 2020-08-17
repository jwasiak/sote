<?php

class stReportBackendActions extends stActions {

    public function executeProduct() {
        $context = $this->getContext();
        $this->config = stConfig::getInstance($context);
        $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        
        $currency_config = stConfig::getInstance($this->getContext(), 'stCurrencyPlugin');        
        $this->default_currency = $currency_config->get('default_currency');
        
        $this->getRequestParameter('id');        
        
        $c = new Criteria();
        $c->add(ProductPeer::ID, $this->getRequestParameter('id'));         
        $product = ProductPeer::doSelectOne($c);
        
        if($product){
            
            $this->product = $product;
            
            $filters = $this->getFilters();
            
            $this->from_date = $filters['from_date'];
            $this->to_date =  $filters['to_date'];
            
            $this->getUser()->setAttribute("filters", $filters, 'soteshop/stReportPlugin');
            
            $result = stReport::getProductValue($filters, $product);
            
            $this->result = $result;   

            $this->filters = $filters;  

            $this->periods = $this->getPeriods(); 

            $this->labels = $this->getLabels();      
            
        }else{
            return sfView::NONE;
        }
        
    }

    protected function getFilters()
    {
        $filters = $this->getRequestParameter('filters', $this->getDefaultFilters()); 

        if ($this->getRequest()->hasParameter('filters') && isset($filters['from_date']))
        {
            $filters['from_date'] = date("Y-m-d", sfI18N::getTimestampForCulture($filters['from_date'], $this->getUser()->getCulture()))." 00:00:00";
        }

        if ($this->getRequest()->hasParameter('filters') && isset($filters['to_date']))
        {
            $filters['to_date'] = date("Y-m-d", sfI18N::getTimestampForCulture($filters['to_date'], $this->getUser()->getCulture()))." 23:59:59";
        }

        if (isset($filters['period']) && $filters['period'] !== "")
        {
            $filters['from_date'] = $filters['period']." 00:00:00";
            $filters['to_date'] = date("Y-m-d H:i:s", time());

            unset($filters['period']);
        }

        if (isset($filters['expand_date']) && $filters['expand_date'] !== "")
        {
            $filters['from_date'] = date("Y-m-d", strtotime($filters['expand_date']))." 00:00:00";
            // throw new Exception($filters['from_date']);
            
            $filters['to_date'] = date("Y-m-t", strtotime($filters['from_date']))." 23:59:59";

            unset($filters['expand_date']);
        }

        return $filters;        
    }

    protected function getDefaultFilters()
    {
        return array('from_date' => date("Y-m-d", time() - 60*60*24*31)." 00:00:00", 'to_date' => date("Y-m-d")." 23:59:59");      
    }

    public function getPeriods()
    {
        $i18n = $this->getContext()->getI18N();

        return array(
            date("Y-m-d", time() - 60*60*24*31) => $i18n->__('Ostatni miesiąc'),
            date("Y-m-d", strtotime('-1 year')) => $i18n->__('Ostatni rok'),
        );
    }

    public function validateProduct()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {      
            $filters = $this->getFilters();

            if ($filters && isset($filters['from_date']) && isset($filters['to_date']))
            {
                $from_date = $filters['from_date'];
                $to_date = $filters['to_date'];
                         
                if ($from_date > $to_date)
                {
                    $this->getRequest()->setError('report{date}', $this->getContext()->getI18N()->__('Data początkowa była późniejsza niż końcowa.'));
                    return false;
                }  

                $datetime1 = date_create($from_date);
                $datetime2 = date_create($to_date);
                $interval = date_diff($datetime1, $datetime2);

                if ($interval->days > 396)
                {
                    $this->getRequest()->setError('report{date}', $this->getContext()->getI18N()->__('Za duży przedział czasowy. Maksymalny zakres wynosi 1 rok.'));
                    return false;
                }
            }
        }
        
        return true;
    }

    protected function getLabels()
    {
        return array(
            'report{date}' => $this->getContext()->getI18N()->__('Okres sprzedaży'),
        );
    }
    
        
    public function handleErrorProduct()
    {
        $context = $this->getContext();
        $this->config = stConfig::getInstance($context);
        $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        
        $currency_config = stConfig::getInstance($this->getContext(), 'stCurrencyPlugin');        
        $this->default_currency = $currency_config->get('default_currency');
        
        $this->getRequestParameter('id');        
        
        $c = new Criteria();
        $c->add(ProductPeer::ID, $this->getRequestParameter('id'));         
        $product = ProductPeer::doSelectOne($c);
        
        if($product){
            
            $this->product = $product;
                        
            $filters = $this->getFilters();

            $this->from_date = $filters['from_date'];
            $this->to_date =  $filters['to_date'];
            
            $this->filters = $filters;

            $this->periods = $this->getPeriods(); 

            $filters = $this->getUser()->getAttribute("filters", $this->getDefaultFilters(), 'soteshop/stReportPlugin');
            
            $result = stReport::getProductValue($filters, $product);
            
            $this->result = $result;      

            $this->labels = $this->getLabels();           
            
        }else{
            return sfView::NONE;
        }
                        
        return sfView::SUCCESS;
    }

}