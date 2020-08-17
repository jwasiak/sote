<?php
/**
 * SOTESHOP/stPartnerPlugin
 *
 * Ten plik należy do aplikacji stPartnerPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPartnerPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Komponent stPartnerFrontendComponents
 *
 * @package     stPartnerPlugin
 * @subpackage  actions
 */
class stPartnerFrontendComponents extends sfComponents
{

    public function executePartnerTextInfo()
    {
        $this->partner_text = TextPeer::retrieveBySystemName('stPartnerInfo');
    }

    public function executePartnerDataForm()
    {
        $partnerData = new Partner();
        $partnerData->setCountriesId(36);

        $c = new Criteria();
        $c->add(UserDataPeer::SF_GUARD_USER_ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
        $c->add(UserDataPeer::IS_DEFAULT , 1);
        $c->add(UserDataPeer::IS_BILLING , 1);
        if ($userDataBillingDefault = UserDataPeer::doSelectOne($c))
        {
            $partnerData->setSfGuardUserId($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            $partnerData->setCompany($userDataBillingDefault->getCompany());
            $partnerData->setName($userDataBillingDefault->getName());
            $partnerData->setSurname($userDataBillingDefault->getSurname());
            $partnerData->setStreet($userDataBillingDefault->getStreet());
            $partnerData->setHouse($userDataBillingDefault->getHouse());
            $partnerData->setFlat($userDataBillingDefault->getFlat());
            $partnerData->setCode($userDataBillingDefault->getCode());
            $partnerData->setTown($userDataBillingDefault->getTown());
            $partnerData->setCountries($userDataBillingDefault->getCountries());
            $partnerData->setPhone($userDataBillingDefault->getPhone());
            $partnerData->setVatNumber($userDataBillingDefault->getVatNumber());

            $partnerDataFromRequest = $this->getRequestParameter('partner_data');

            if (isset($partnerDataFromRequest['name']))
            {
                $partnerData->setName($partnerDataFromRequest['name']);
            }

            if (isset($partnerDataFromRequest['surname']))
            {
                $partnerData->setSurname($partnerDataFromRequest['surname']);
            }

            if (isset($partnerDataFromRequest['street']))
            {
                $partnerData->setStreet($partnerDataFromRequest['street']);
            }

            if (isset($partnerDataFromRequest['house']))
            {
                $partnerData->setHouse($partnerDataFromRequest['house']);
            }

            if (isset($partnerDataFromRequest['flat']))
            {
                $partnerData->setFlat($partnerDataFromRequest['flat']);
            }

            if (isset($partnerDataFromRequest['code']))
            {
                $partnerData->setCode($partnerDataFromRequest['code']);
            }

            if (isset($partnerDataFromRequest['town']))
            {
                $partnerData->setTown($partnerDataFromRequest['town']);
            }

            if (isset($partnerDataFromRequest['country']))
            {
                $partnerData->setCountriesId($partnerDataFromRequest['country']);
            }

            if (isset($partnerDataFromRequest['phone']))
            {
                $partnerData->setPhone($partnerDataFromRequest['phone']);
            }

            if (isset($partnerDataFromRequest['company']))
            {
                $partnerData->setCompany($partnerDataFromRequest['company']);
            }

            if (isset($partnerDataFromRequest['vatNumber']))
            {
                $partnerData->setVatNumber($partnerDataFromRequest['vatNumber']);
            }
        }

        $this->partnerData = $partnerData;

    }

    Public function executePartnerDataInfo()
    {
         $c = new Criteria();
         $c->add(PartnerPeer::SF_GUARD_USER_ID , $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
         $partnerData = PartnerPeer::doSelectOne($c);
         $this->partner_data = $partnerData;


         $data1 = $partnerData->getCreatedAt();
         $data2 = date("Y-m-d H:i:s");

         $this->provisionAll = $this->partnerProvision($partnerData->getId(), $data1, $data2);

         $this->provisionNotPayed = $this->partnerProvision($partnerData->getId(), $data1, $data2, '0');

         $this->provisionPayed = $this->partnerProvision($partnerData->getId(), $data1, $data2, '1');

    }

    Public function executePartnerWaiting()
    {

    }

    Public function executePartnerOrder()
    {
         if($this->hasRequestParameter('data1'))
         {
            $data1 = $this->getRequestParameter('data1');

            if(empty($data1))
            {
                $data1 = "";
                $data2 = "";
            }
         }
         else
         {
            $data1 = date("Y-m-")."01 00:00:00";
         }

         if($this->hasRequestParameter('data2'))
         {
            $data2 = $this->getRequestParameter('data2');

            if(empty($data2))
            {
                $data1 = "";
                $data2 = "";
            }
         }
         else
         {
            $data2 = date("Y-m-d H:i:s");
         }

         $this->data1 = $data1;
         $this->data2 = $data2;

         if($this->hasRequestParameter('status'))
         {
            $status = $this->getRequestParameter('status');

            if($status=='off')
            {
                $this->checked1 = true;
                $this->checked2 = false;
                $this->checked3 = false;
            }
            if($status=='0')
            {
                $this->checked1 = false;
                $this->checked2 = false;
                $this->checked3 = true;
            }
            if($status=='1')
            {
                $this->checked1 = false;
                $this->checked2 = true;
                $this->checked3 = false;
            }
         }
         else
         {
            $this->checked1 = true;
            $this->checked2 = false;
            $this->checked3 = false;
            $status = "off";
         }


         $c = new Criteria();
         $c->add(PartnerPeer::SF_GUARD_USER_ID , $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
         $partnerData = PartnerPeer::doSelectOne($c);

         $provision = $this->partnerProvision($partnerData->getId(), $data1, $data2, $status);
         $orders = $this->partnerOrder($partnerData->getId(), $data1, $data2, $status);

         $this->provision = $provision;
         $this->orders = $orders;
    }

    public function partnerProvision($partner_id, $data1, $data2, $payed="off")
    {
        $c = new Criteria();
        $c->add(OrderPeer::PARTNER_ID , $partner_id);

        if($payed!="off")
        {
            $c->add(OrderPeer::PROVISION_PAYED , $payed);
        }

        // $data1 <= CREATED_AT <= $data2

        if($data1!="" || $data2!="")
        {
            $c1 = $c->getNewCriterion(OrderPeer::CREATED_AT, $data1, Criteria::GREATER_EQUAL);

            $c1->addAnd($c->getNewCriterion(OrderPeer::CREATED_AT, $data2, Criteria::LESS_EQUAL));

            $c->add($c1);
        }

        $c->addJoin(OrderStatusPeer::ID, OrderPeer::ORDER_STATUS_ID);

        $c->add(OrderStatusPeer::TYPE, 'ST_COMPLETE');

        $orders = OrderPeer::doSelect($c);



        $provision = 0;

        foreach ($orders as $order)
        {

            $provision = $provision + $order->getProvisionValue();
        }

        return $provision;
    }

    public function partnerOrder($partner_id, $data1, $data2, $payed="off" )
    {
        $c = new Criteria();
        $c->add(OrderPeer::PARTNER_ID , $partner_id);

        if($payed!="off")
        {
            $c->add(OrderPeer::PROVISION_PAYED , $payed);
        }
        // $data1 <= CREATED_AT <= $data2

        if($data1!="" || $data2!="")
        {
            $c1 = $c->getNewCriterion(OrderPeer::CREATED_AT, $data1, Criteria::GREATER_EQUAL);

            $c1->addAnd($c->getNewCriterion(OrderPeer::CREATED_AT, $data2, Criteria::LESS_EQUAL));

            $c->add($c1);
        }

        $c->addJoin(OrderStatusPeer::ID, OrderPeer::ORDER_STATUS_ID);

        $c->add(OrderStatusPeer::TYPE, 'ST_COMPLETE');

        $orders = OrderPeer::doSelect($c);

        return $orders;
    }

    Public function executePartnerNoActive()
    {

    }

    Public function executePartnerHash()
    {

         $c = new Criteria();
         $c->add(PartnerPeer::SF_GUARD_USER_ID , $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
         $partnerData = PartnerPeer::doSelectOne($c);

         $c = new Criteria();
         $c->add(PartnerHashPeer::PARTNER_ID , $partnerData->getId());
         $partnerHash = PartnerHashPeer::doSelectOne($c);
         $this->partner_hash = $partnerHash;
    }

    /**
     * Sprawdzanie czy istenieje hash w linku do sklepu/produktu/itp
     *
     * @author Michal Prochowski <michal.prochowski@sote.pl>
     */
    public function executeCheckHash()
    {
       $config = stConfig::getInstance($this->getContext(), 'stPartnerBackend');

       if($config->get('is_active')==1)
       {

        if($this->hasRequestParameter('partnerHash'))
        {
            $this->hash = $this->getRequestParameter('partnerHash');
            $this->getUser()->setAttribute('partnerHash', $this->hash);
            sfContext::getInstance()->getResponse()->setCookie('st_partner', $this->hash, time()+60*60*24*$config->get('cookie_day_expire'), '/');
        }
        else
        {
           if($this->getRequest()->getCookie('st_partner'))
           {
               $this->hash = $this->getRequest()->getCookie('st_partner');
               $this->getUser()->setAttribute('partnerHash', $this->hash);
           }

           if($this->getUser()->hasAttribute('partnerHash'))
           {
               $this->hash = $this->getUser()->getAttribute('partnerHash');
           }
        }
      }

    }
}