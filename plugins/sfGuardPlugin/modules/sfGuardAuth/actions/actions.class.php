<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/../lib/BasesfGuardAuthActions.class.php');

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 3409 2008-12-16 13:01:21Z bartek $
 */
class sfGuardAuthActions extends BasesfGuardAuthActions
{
  public function executeSignin()
  {                
    $stWebRequest = new stWebRequest();
    $httpUserAgent = $stWebRequest->getHttpUserAgent();    
    
    if(strpos($httpUserAgent, "MSIE 7.0") !== false || strpos($httpUserAgent, "MSIE 6.0") !== false)
    {
          $this->redirect('stIe/index');
    }    
      
    $c = new Criteria();
    $c->add(sfGuardUserPeer::IS_ACTIVE, 1);
    $c->add(sfGuardUserPeer::IS_SUPER_ADMIN , 1);
    $user = sfGuardUserPeer::doSelectOne($c);
    
    if(!$user)
    {
        $this->redirect('stRegister/index'); 
    }
    
      
    $user = $this->getUser();
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      $referer = $user->getAttribute('referer', $this->getRequest()->getReferer());
      $user->getAttributeHolder()->remove('referer');

      $signin_url = sfConfig::get('app_sf_guard_plugin_success_signin_url', $referer);

      $this->redirect('' != $signin_url ? $signin_url : '@homepage');
    }
    elseif ($user->isAuthenticated())
    {
      $this->redirect('@homepage');
    }
    else
    {
      $is_iframe = strpos($this->getRequest()->getUri(), 'gadget_id=') !== false;

      if ($is_iframe) {
        return $this->renderText("<script>window.parent.location='".$this->getController()->genUrl('@homepage')."'</script>");
      }

      if ($this->getRequest()->isXmlHttpRequest())
      {
        $this->getResponse()->setStatusCode(401);

        return sfView::HEADER_ONLY;
      }

      if (!$user->hasAttribute('referer'))
      {
        $user->setAttribute('referer', $this->getRequest()->getUri());
      }

      if ($this->getModuleName() != ($module = sfConfig::get('sf_login_module')))
      {
        return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
      }
    }
  }
  
  public function executeSecure()
  {   
      $layout = $this->getRequestParameter('layout'); 

      if ($layout)
      {
         $this->setLayout($layout);
      }

      parent::executeSecure();
  }
}
