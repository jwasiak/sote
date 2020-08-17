<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
/** 
 * SOTESHOP/stUser 
 * 
 * Ten plik należy do aplikacji stUser opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stUser
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: loginUserValidator.class.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 *
 * @author Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 *
 *
 * @package     stUser
 * @subpackage  libs
 */
class stLoginUserValidator extends sfValidator
{
  public function initialize($context, $parameters = null)
  {
    // initialize parent
    parent::initialize($context);

    // set defaults
    $this->getParameterHolder()->set('username_error', 'Zły login lub hasło.');
    $this->getParameterHolder()->set('password_error', 'Zły login lub hasło.');
    $this->getParameterHolder()->set('password_field', 'password');
    $this->getParameterHolder()->set('remember_field', 'remember');
    $this->getParameterHolder()->set('permision_error', 'Nie masz odpowiednich uprawnień');
       
    
    $this->getParameterHolder()->add($parameters);

    return true;
  }

  public function execute(&$value, &$error)
  {
    $username = $value;
    $password = $this->getContext()->getRequest()->getParameter('user[password]');

    if($password=="anonymous")
    {
        $error = $this->getParameterHolder()->get('password_error');
        return false;
    }
        
    $c = new Criteria();
    $c->add(sfGuardUserPeer::USERNAME , $username);
    $user = sfGuardUserPeer::doSelectOne($c);
    
    if(!$user)
    {
        $error = $this->getParameterHolder()->get('username_error');
        return false;
    }
    
           
    $c = new Criteria();
    $c->add(sfGuardUserGroupPeer::USER_ID  , $user->getId());
    $c->add(sfGuardUserGroupPeer::GROUP_ID , 2);
    $group = sfGuardUserGroupPeer::doSelectOne($c);
    
    if(!$group)
    {
        $error = $this->getParameterHolder()->get('permision_error');
        return false;
    }

    
    if ($this->getContext()->getUser()->loginUser($username, $password))
    {
        return true;
    }
       
    $error = $this->getParameterHolder()->get('username_error');

    return false;
  }
}
