<?php
/** 
 * SOTESHOP/stUser 
 * 
 * Ten plik należy do aplikacji stUser opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stUser
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/** 
 * Klasa przechowuje metody komponentu użytkownika.
 *
 * @author Bartosz Alejski <bartosz.alejski@sote.pl>
 *
 * @package     stUser
 * @subpackage  actions
 */
class stUserComponents extends sfComponents
{
    /** 
     * Zwraca aktualnego użytkownika
     *
     * @return   stUser
     */
    public function getUser()
    {
        return parent::getUser();
    }
    /** 
     * Wywołanie komponentu sprawdzającego status zalogowania użytkowniak
     */
    public function executeLoginStatus()
    {
        
        $this->smarty = new stSmarty('stUser');
        
        $this->is_authenticated = false;
        
        if($this->getUser()->isAuthenticated())
        {
        
            $content = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
            if ($content)
            {
                $c = new Criteria();
                $c->add(sfGuardUserPeer::ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
                $user = sfGuardUserPeer::doSelectOne($c);
    
                if(is_object($user))
                {
                    $this->is_authenticated = true;
                    
                    $login = $user->getUsername();
                    
                    $login_username = explode("@", $login);
                    
                    $this->username = $login_username[0];
                    
                    $password = $user->getPassword();
                    
                    $config_points = stConfig::getInstance('stPointsBackend');
                    $config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());
                    
                    $this->points_value =  stPoints::getLoginStatusPoints();
                    $this->points_show = $config_points->get('points_show_in_login_status');
                    $this->points_shortcut = $config_points->get('points_shortcut', null, true);
                    $this->points_system_is_active = stPoints::isPointsSystemActive(); 

    
                    if($this->getUser()->checkPassword("anonymous"))
                    {
                        $this->account_type = "annonymous";
                    }
                    else
                    {
                        $this->account_type = "full";
                    }
                    
                    if($user->getExternalAccount())
                    {
                       $this->externalAccount = $user->getExternalAccount();
                       $this->account_type = "external";
                    }
                }
            }
        
        }
        
    }

    public function executeBasketLoginForm()
    {
         $this->smarty = new stSmarty('stUser');
		 
         $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');
         $this->login_google_on = $user_config->get('google_auth_on');
         
		 if ($this->getRequest()->getMethod() == sfRequest::POST && $this->hasRequestParameter('submit_login'))
         {
			$this->login_show_error = 1;
         }
    }

}