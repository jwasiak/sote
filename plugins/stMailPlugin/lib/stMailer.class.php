<?php

/**
 * SOTESHOP/stMailPlugin
 *
 * Ten plik należy do aplikacji stMailPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stMailPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stMailer.class.php 12274 2011-04-18 11:54:02Z michal $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa stMailer
 *
 * @package     stMailPlugin
 * @subpackage  libs
 */
class stMailer extends stMail
{

	protected $merchantAddress = '';
    protected $account = null;
    protected $accountInitialized = null;

	/**
	 * Pobiera instancję
	 *
	 * @return   stMailer
	 */
	public static function getInstance($class = null)
	{
		if (null === $class)
		{
			$class = __CLASS__;
		}

		return parent::getInstance($class);
	}
    
    public function setAccount($email)
    {
        $this->account = $email;

        $this->accountInitialized = null;
        
        return $this;
    }

    public function setMerchantAddress($address = '') {

        $this->merchantAddress = $address ;
    }
    
    public function initializeAccount()
    {
        if (null === $this->accountInitialized)
        {
            $c = new Criteria();
            
            if ($this->account)
            {
                $c->add(MailAccountPeer::EMAIL, $this->account);
            }
            else 
            {
                $c->add(MailAccountPeer::IS_DEFAULT, true);
            }

            stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stMailPlugin.beforeInitialize', array('mailCriteria'=>$c)));            
            
            $c->setLimit(1);
    
            $mail_accounts = MailAccountPeer::doSelectJoinMailSmtpProfile($c);
    
            if ($mail_accounts)
            {
                $mail_account = $mail_accounts[0]; 

                if (!$this->merchantAddress)
                {
                    $this->merchantAddress = $mail_account->getEmail();
                }
        
                if ($mail_account->getName())
                {
                    $sender = array($mail_account->getEmail() => $mail_account->getName());
                }
                else
                {
                    $sender = $mail_account->getEmail();
                }
        
                $this->setSmtpConnection($sender, $mail_account->getMailSmtpProfile()->getHost(), $mail_account->getMailSmtpProfile()->getPort(), $mail_account->getUsername(), $mail_account->getPassword(), $mail_account->getMailSmtpProfile()->getEncType()); 
                   
                $this->accountInitialized = true;                   
            }         
            else
            {
                $this->accountInitialized = false;
            }
        }

        return $this->accountInitialized;      
    }
    
    public function send(&$failed_recipients = null)
    {
        if (!$this->initializeAccount())
        {
            return false;
        }
        
        return parent::send($failed_recipients);
    }
	/**
	 * Wysyła e-mail do klienta
	 *
	 * @return   bool
	 */
	public function sendToClient()
	{
		return $this->send();
	}

	/**
	 * Wysyła e-mail na konto główne sklepu
	 *
	 * @return   bool
	 */
	public function sendToMerchant()
	{
	    $this->initializeAccount();
		return $this->merchantAddress ? $this->setTo($this->merchantAddress)->send() : false;
	}

	/**
	 * Zawartośći opisów maila Html
	 *
	 * @return   string
	 */
	public static function getHtmlMailDescription($system_name)
	{
		$c = new Criteria();
		$c->add(MailDescriptionPeer::IS_ACTIVE, 1);
		$c->add(MailDescriptionPeer::SYSTEM_NAME, $system_name);
		$mailDescription = MailDescriptionPeer::doSelectOne($c);


		if (!$mailDescription)
		{
			$content = "";
			return $content;
		}
		else
		{
			if (SF_APP == 'backend') $mailDescription->setCulture(sfContext::getInstance()->getUser()->getCulture());
			$content = $mailDescription->getDescription();
			return $content;
		}
	}

	/**
	 * Zawartośći opisów maila 
	 *
	 * @return   string
	 */
	public static function getPlainMailDescription($system_name)
	{
		$c = new Criteria();
		$c->add(MailDescriptionPeer::IS_ACTIVE, 1);
		$c->add(MailDescriptionPeer::SYSTEM_NAME, $system_name);
		$mailDescription = MailDescriptionPeer::doSelectOne($c);


		if (!$mailDescription)
		{
			$content = "";
			return $content;
		}
		else
		{
			if (SF_APP == 'backend') $mailDescription->setCulture(sfContext::getInstance()->getUser()->getCulture());
			$content = $mailDescription->getDescription();
			return $content;
		}
	}
}
