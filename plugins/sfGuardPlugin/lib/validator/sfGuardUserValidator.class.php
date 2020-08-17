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
 * @version    SVN: $Id: sfGuardUserValidator.class.php 4820 2009-02-10 10:47:45Z bartek $
 */
class sfGuardUserValidator extends sfValidator
{
  public function initialize($context, $parameters = null)
  {
    // initialize parent
    parent::initialize($context);

    // set defaults
    $this->getParameterHolder()->set('license_error', 'Wystąpił problem z licencją.');
    $this->getParameterHolder()->set('license_day_error', 'Licencja straciła ważność');
    $this->getParameterHolder()->set('username_error', 'Username or password is not valid.');
    $this->getParameterHolder()->set('password_field', 'password');
    $this->getParameterHolder()->set('remember_field', 'remember');
    

    $this->getParameterHolder()->add($parameters);

    return true;
  }

  public function execute(&$value, &$error)
  {
    $password_field = $this->getParameterHolder()->get('password_field');
    $password = $this->getContext()->getRequest()->getParameter($password_field);

    $remember = false;
    $remember_field = $this->getParameterHolder()->get('remember_field');
    $remember = $this->getContext()->getRequest()->getParameter($remember_field);

    $this->config = stConfig::getInstance($this->getContext(), "stRegister");
       
    $register = $this->config->load();
    
    if(empty($register['license']))
    {
        $error = $this->getParameterHolder()->get('license_error');
        
        return false;
    }
    else 
    {
        $stLicense = new stLicense($register['license']);
        
        if(!$stLicense->check())
        {
            $error = $this->getParameterHolder()->get('license_error');
            
            return false;
        }
        
        if($stLicense->checkLicenseDate()==0)
        {
            $error = $this->getParameterHolder()->get('license_day_error');
            
            return false;
        }    
    }
     
    
    
    $username = $value;

    $user = sfGuardUserPeer::retrieveByUsername($username);

    // user exists?
    if ($user)
    {
      // password is ok?
      if ($user->checkPassword($password) && $user->hasGroup('admin'))
      {
        $this->getContext()->getUser()->signIn($user, $remember);
        
       

        return true;
      }
    }
    
    $error = $this->getParameterHolder()->get('username_error');

    return false;
  }
  
  
  
}
