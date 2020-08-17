<?php

class Crypt {

    protected $progressbarMsg = '';

    protected static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function executeCryptAllUsers($step)
    {
        $c = new Criteria();

        $c->add(UserDataPeer::CRYPT, 0);
        $c->setLimit(1);
        $uncryptUsers = UserDataPeer::doSelect($c);

        if($uncryptUsers)
        {
            foreach ($uncryptUsers as $userData)
            {
                $userData->save(null,true);
            }
        }

        return $step + 1;
    }

    public function executeCryptAllOrderUsersBilling($step)
    {
        $c = new Criteria();

        $c->add(OrderUserDataBillingPeer::CRYPT, 0);
        $c->setLimit(1);
        $uncryptUsersBilling = OrderUserDataBillingPeer::doSelect($c);

        if($uncryptUsersBilling)
        {
            foreach ($uncryptUsersBilling as $userDataBilling)
            {
                $userDataBilling->save(null,true);
            }
        }
        return $step + 1;
    }

    public function executeCryptAllOrderUsersDelivery($step)
    {
        $c = new Criteria();

        $c->add(OrderUserDataDeliveryPeer::CRYPT, 0);
        $c->setLimit(1);
        $uncryptUsersDelivery = OrderUserDataDeliveryPeer::doSelect($c);

        if($uncryptUsersDelivery)
        {
            foreach ($uncryptUsersDelivery as $userDataDelivery)
            {
                $userDataDelivery->save(null,true);
            }
        }
        return $step + 1;
    }

    public function close() {
        $i18n = sfContext::getInstance()->getI18N();
        $this->progressbarMsg = $i18n->__('Zakończono powodzeniem.', null, 'stSecurityBackend');
    }

    public function getMessage() {
        return $this->progressbarMsg;
    }

    public static function getShopHash($license = null)
    {
        if($license != null)
        {
            return md5($license);
        }

        $config = stConfig::getInstance('stRegister');

        if($config->get('shop_hash') && $config->get('shop_hash')!="")
        {
            return $config->get('shop_hash');
        }

        return null;
    }


    public function Encrypt($string) 
    {        
        $key = Crypt::getShopHash();

        if (null === $key || !self::is_mcrypt())
        {
            return $string;
        }
                
        /* Open module, and create IV */
        $td = mcrypt_module_open('des', '','cfb', '');
        $key = substr($key, 0, mcrypt_enc_get_key_size($td));
        $iv_size = mcrypt_enc_get_iv_size($td);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM); 
        
        /* Initialize encryption handle */
        if (mcrypt_generic_init($td, $key, $iv) != -1) {

            /* Encrypt data */
            /**
             * Hack for warning error message that $string is empty.
             */
            if (empty($string))
                $c_t = @mcrypt_generic($td, $string);
            else 
                $c_t = mcrypt_generic($td, $string);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            $c_t = $iv.$c_t;
            
            return base64_encode($c_t);
        } //end if
    }

    public function Decrypt($string) 
    {
        $key = Crypt::getShopHash();

        if (null === $key || !self::is_mcrypt())
        {
            return $string;
        }
        
        $string = base64_decode($string);
                
        /* Open module, and create IV */
        $td = mcrypt_module_open('des', '','cfb', '');
        $key = substr($key, 0, mcrypt_enc_get_key_size($td));
        $iv_size = mcrypt_enc_get_iv_size($td);
        $iv = substr($string,0,$iv_size);
        $string = substr($string,$iv_size);
        /* Initialize encryption handle */
        if (mcrypt_generic_init($td, $key, $iv) != -1) {

            /* Encrypt data */
            $c_t = @mdecrypt_generic($td, $string);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            return $c_t;
        } //end if
    }
    
    public static function is_mcrypt() 
    {
        if(function_exists("mcrypt_module_open"))
        {
            return true;    
        }
        else 
        {
            return false;    
        }
    }
    
    public function executeCryptAllInvoiceCustomer($step)
    {
        $c = new Criteria();

        $c->add(InvoiceUserCustomerPeer::CRYPT, 0);
        $c->setLimit(1);
        $uncryptInvoiceUserCustomer = InvoiceUserCustomerPeer::doSelect($c);

        if($uncryptInvoiceUserCustomer)
        {
            foreach ($uncryptInvoiceUserCustomer as $invoiceUserCustomer)
            {
                $invoiceUserCustomer->save(null,true);
            }
        }
        return $step + 1;
    }

    public function executeCryptAllInvoiceSeller($step)
    {
        $c = new Criteria();

        $c->add(InvoiceUserSellerPeer::CRYPT, 0);
        $c->setLimit(1);
        $uncryptInvoiceUserSeller = InvoiceUserSellerPeer::doSelect($c);

        if($uncryptInvoiceUserSeller)
        {
            foreach ($uncryptInvoiceUserSeller as $invoiceUserSeller)
            {
                $invoiceUserSeller->save(null,true);
            }
        }
        return $step + 1;
    }
}