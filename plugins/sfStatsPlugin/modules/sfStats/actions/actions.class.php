<?php

require_once(sfConfig::get('sf_plugins_dir'). '/sfStatsPlugin/modules/sfStats/lib/BasesfStatsActions.php');

class sfStatsActions extends BasesfStatsActions
{
    public function executeIndex()
    {
        parent::executeIndex();
        
        $config = stConfig::getInstance(sfContext::getInstance(), 'sfStats');
        
        $config->load();

        $this->graf = $config->get('graf');
        $this->statistics = $config->get('statistics');
        
        $this->graph = $config->get('graph');
    }
    
    public function prepareFilters()
    {
        parent::prepareFilters();
        $config = stConfig::getInstance(sfContext::getInstance(), array('from' => stConfig::STRING), 'sfStats');
        
        $config->load();
        
        $this->day = $config->get('from')=='day';
        $this->week = $config->get('from')=='week';
        $this->month = $config->get('from')=='month';
        $this->quarter = $config->get('from')=='quarter';
        $this->year = $config->get('from')=='year';
        
        if ($this->day) 
        {
            $this->from = 1;
        } elseif ($this->week) {
            $this->from = 7;
        } elseif ($this->month) {
            $this->from = 30;
        } elseif ($this->quarter) {
            $this->from = 91;
        } elseif ($this->year) {
            $this->from = 365;
        }
        
          // from defaults
        if (!isset($this->filters['period']['from']) ||
            $this->filters['period']['from'] === ''  ||
            @strtotime($this->filters['period']['from']) === false)
            {
              $this->filters['period']['from'] = time() - sfConfig::get('app_sfStats_default_days', $this->from) * 24 * 60 * 60;
            }
    }
    
    
    public function executeConfig()
    {
        $i18n = $this->getContext()->getI18N();
        $this->config = stConfig::getInstance($this->getContext());

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->setFromRequest('st_stats');
            $this->config->save();
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
        }
    }
}