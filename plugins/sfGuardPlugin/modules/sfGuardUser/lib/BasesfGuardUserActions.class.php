<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: BasesfGuardUserActions.class.php 4 2008-09-24 08:40:58Z marek $
 */
class BasesfGuardUserActions extends autosfGuardUserActions
{
    public function validateEdit()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$this->getRequestParameter('id'))
        {
            if ($this->getRequestParameter('sf_guard_user[password]') == '')
            {
                $this->getRequest()->setError('sf_guard_user{password}', ('Proszę podać hasło'));

                return false;
            }
        }

        return true;
    }

    public function executeDelete() {
        if (sfGuardUserPeer::doCount(new Criteria())>1) {
            parent::executeDelete();
        } else {
            $this->getRequest()->setError('delete', 'Nie można usunąć ostatniego użytkownika');
        }
        return $this->forward('sfGuardUser','list');
    }

  public function executeList()
  {
    $this->processSort();

    $this->processFilters();

    $this->filters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/sf_guard_user/filters');

    // pager
    $this->pager = new sfPropelPager('sfGuardUser', 20);
    $c = new Criteria();
    $this->addSortCriteria($c);
    $this->addFiltersCriteria($c);
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->init();
    if (count($this->pager->getResults())>1) { $this->setFlash('enable_delete',true);} else {$this->setFlash('enable_delete',false);}
  }
    
}
