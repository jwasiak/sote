<?php 

class stAllegroPager extends sfPager
{
    public function __construct($page = 1, $maxPerPage = 20)
    {
        $this->setPage($page);
        $this->setMaxPerPage($maxPerPage);
    }

    public function setTotalCount($count)
    {
        $this->setNbResults($count);
        $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    }
    
    public function getOffset()
    {
        return ($this->getPage() - 1) * $this->getMaxPerPage();
    }

    public function init()
    {

    }

    public function getResults()
    {

    }
  
    protected function retrieveObject($offset)
    {

    }  
}