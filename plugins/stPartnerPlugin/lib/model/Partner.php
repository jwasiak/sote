<?php

/**
 * Subclass for representing a row from the 'st_partner' table.
 *
 * 
 *
 * @package plugins.stPartnerPlugin.lib.model
 */ 
class Partner extends BasePartner
{
    
    public function getLastLogin()
    {
   
        return $this->getPartnerUser()->getLastLogin();
    }
    
    public function getPartnerName()
    {
        $user = $this->getsfGuardUser();

        return $user ? $user->getUsername() : null;
    }

    public function getPartnerUser()
    {
        $user = $this->getsfGuardUser();

        if (is_null($user))
        {
            $user = new sfGuardUser();

            $this->setsfGuardUser($user);
        }
            
        return $user;
    }
          
    public function setPartnerName($v)
    {
        $this->getPartnerUser()->setUsername($v);
    }

    public function getPartnerPassword()
    {
        return '';
    }

    public function setPartnerPassword($v)
    {
        $this->getPartnerUser()->setPassword($v);
    }

    public function setPartnerConfirmPassword()
    {
        
    }
    
    public function getPartnerConfirmPassword()
    {
        
    }   
    
    public function save($con = null)
    {
        $is_new = $this->getsfGuardUser()->isNew();
        
        parent::save($con);
        
        if ($is_new)
        {
        $this->getsfGuardUser()->addGroupByName('user');
        }       
    }

}
