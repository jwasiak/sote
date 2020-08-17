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
 * @version     $Id: stPropelPager.class.php 1031 2009-10-05 08:52:41Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Przeciążenie klasy sfPropelPager - Umożliwienie stronnicowania obiektów typu sfPropelCustomJoinObjectProxy zwracanych przez sfPropelCustomJoinHelper
 *
 * @package     stBase
 * @subpackage  libs
 */
class stPropelPager extends sfPropelPager
{
    protected $results = null;

    protected $cntResults = null;

    public function getClassPeer()
    {
        if (is_string($this->getClass()))
        {
            return parent::getClassPeer();
        }

        return $this->getClass();
    }

    public function init()
    {
        $this->cntResults = null;

        $this->results = null;

        $hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
        $maxRecordLimit = $this->getMaxRecordLimit();

        $cForCount = clone $this->getCriteria();
        $cForCount->setOffset(0);
        $cForCount->setLimit(0);

        if (!is_array($this->getPeerCountMethod()))
        {
           if ($cForCount->getGroupByColumns())
           {
              $cForCount->setDistinct();
              $cForCount->clearGroupByColumns();  
           }         

           // require the model class (because autoloading can crash under some conditions)
           if (is_string($this->getClassPeer()))
           {
               if (!$classPath = sfCore::getClassPath($this->getClassPeer()))
               {
                   throw new sfException(sprintf('Unable to find path for class "%s".', $this->getClassPeer()));
               }
               require_once($classPath);
           }

           $count = call_user_func(array($this->getClassPeer(), $this->getPeerCountMethod()), $cForCount);
        }
        else
        {
           $count = call_user_func($this->getPeerCountMethod(), $cForCount);
        }

        $this->setNbResults($hasMaxRecordLimit ? min($count, $maxRecordLimit) : $count);

        $c = $this->getCriteria();
        $c->setOffset(0);
        $c->setLimit(0);

        if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
        {
            $this->setLastPage(0);
        }
        else
        {
            $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));

            $offset = ($this->getPage() - 1) * $this->getMaxPerPage();
            $c->setOffset($offset);

            if ($hasMaxRecordLimit)
            {
                $maxRecordLimit = $maxRecordLimit - $offset;
                if ($maxRecordLimit > $this->getMaxPerPage())
                {
                    $c->setLimit($this->getMaxPerPage());
                }
                else
                {
                    $c->setLimit($maxRecordLimit);
                }
            }
            else
            {
                $c->setLimit($this->getMaxPerPage());
            }
        }
    }

    public function getResults()
    {
        if (is_null($this->results))
        {
            $this->results = parent::getResults();
        }

        return $this->results;
    }

    public function getCntResults()
    {
        if (is_null($this->cntResults))
        {
            $results = $this->getResults();

            $this->cntResults = count($results);
        }

        return $this->cntResults;
    }
}
?>
