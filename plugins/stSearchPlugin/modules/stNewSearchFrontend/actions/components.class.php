<?php

class stNewSearchFrontendComponents extends sfComponents {

    public function executeList() {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
        $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());
    }

}
