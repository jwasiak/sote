<?php
/** 
 * SOTESHOP/stOrder 
 * 
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stOrder
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 16489 2011-12-16 08:53:47Z bartek $
 */

/** 
 * SOTESHOP/stOrder
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOrder
 * @subpackage  actions
 */
class stOrderComponents extends autostOrderComponents
{
    public function executeOrderStatusType()
    {
        $this->select_options = array();
        
        $i18n = $this->getContext()->getI18N();
        
        foreach (OrderStatusPeer::getTypes() as $type => $label)
        {
            $this->select_options[$type] = $i18n->__($label, array(), 'stOrder');
        }
    }

    public function executePayment()
    {        
        $this->payments = $this->order->getOrderHasPaymentsJoinPayment();

        $c = new Criteria();
        
        $c->add(PaymentTypePeer::ACTIVE,1);
        
        $activePayments = PaymentTypePeer::doSelectWithI18n($c);

         foreach ($activePayments as $activePayment)
        {
            if (!$activePayment->checkPaymentConfiguration()) continue;
            
            $activePaymentType[$activePayment->getId()] = $activePayment->getName();

            
        }

        $this->paymentsType = $activePaymentType;

    }

    public function executeProforma()
    {
        $this->order_id = $this->order->getId();

        $c = new Criteria();
        $c->add(InvoicePeer::ORDER_ID , $this->order->getId());
        $c->add(InvoicePeer::IS_PROFORMA, 1);
        $invoice = InvoicePeer::doSelectOne($c);
        $ifirmaConfig = stConfig::getInstance(sfContext::getInstance(), 'stInvoiceBackend');
        $this->ifirma_enabled = $ifirmaConfig->get('ifirma_enabled');

        if($invoice)
        {
            $this->invoice_id = $invoice->getId();
        }
        else
        {
            $this->type = "none";
        }
    }

    public function executeInvoice()
    {
        $this->order_id = $this->order->getId();
        $c = new Criteria();
        $c->add(InvoicePeer::ORDER_ID , $this->order->getId());
        $criterion = $c->getNewCriterion(InvoicePeer::IS_REQUEST, 1);
        $criterion->addOr($c->getNewCriterion(InvoicePeer::IS_CONFIRM, 1));
        $c->add($criterion);
        $invoice = InvoicePeer::doSelectOne($c);
        $ifirmaConfig = stConfig::getInstance(sfContext::getInstance(), 'stInvoiceBackend');
        $this->ifirma_enabled = $ifirmaConfig->get('ifirma_enabled');


        if($invoice)
        {
            $this->invoice_id = $invoice->getId();

            if($invoice->getIsRequest()==1)
            {
                $this->type = "request";
            }

            if($invoice->getIsConfirm()==1)
            {
                $this->type = "confirm";
            }
        }
        else
        {
            $c = new Criteria();
            $c->add(InvoicePeer::ORDER_ID , $this->order->getId());
            $c->add(InvoicePeer::IS_PROFORMA, 1);
            $invoice = InvoicePeer::doSelectOne($c);

            if ($invoice)
            {
               $this->invoice_id = $invoice->getId();
               $this->type = "proforma";
            }
            else
            {
               $this->type = 'none';
            }
        }
    }

    public function executePointsStatus()
    {
        $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
        $this->config_points->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        
        $this->points_status = 0;
        if(stPoints::isPointsAssigned($this->order)==true){
            $this->points_status = 1;    
         }
        
         $this->points_earn =  stPoints::getOrderTotalPointsEarn($this->order);
        
        $this->order_id = $this->order->getId();
    }
    
    public function executePointsSpend()
    {
        $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
        $this->config_points->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        $this->points_value = stPoints::getOrderTotalPointsValue($this->order);
    }
    
    public function executePointsEarn()
    {
        $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
        $this->config_points->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        $this->points_earn = stPoints::getOrderTotalPointsEarn($this->order);
    }
    
    
    public function executeProductLastOrderWidget()
    {
      $backendMainConfig = stConfig::getInstance($this->getContext(), 'stBackendMain');

       if($this->getRequestParameter('date_type'))
       {
           $date_type = $this->getRequestParameter('date_type');
           $backendMainConfig->set('date_type', $date_type);
           $backendMainConfig->save();
       }
       else
       {
           $date_type = $backendMainConfig->get('date_type');
       }

       if($date_type=="day")
       {
           $from_date = date('Y-m-d H:i:s', time() - 86400);
       }
       elseif($date_type=="week")
       {
           $from_date = date('Y-m-d H:i:s', time() - 604800);

       }elseif($date_type=="month")
       {
           $from_date = date('Y-m-d H:i:s', time() - 2419200);

       }elseif($date_type=="lastlog")
       {
           $c = new Criteria();
           $c->add(sfGuardUserPeer::ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
           $user = sfGuardUserPeer::doSelectOne($c);

           $from_date = $this->getUser()->getLastLogin();
       }
           $to_date = date('Y-m-d H:i:s');

        $this->date_type = $date_type;
        $this->from_date = $from_date;
        $this->to_date = $to_date;

        //produkty
        $c = new Criteria();
        $criterion = $c->getNewCriterion(OrderProductPeer::CREATED_AT , $from_date, Criteria::GREATER_EQUAL  );
        $criterion->addAnd($c->getNewCriterion(OrderProductPeer::CREATED_AT , $to_date, Criteria::LESS_EQUAL ));
        $c->add($criterion);
        $c->addDescendingOrderByColumn(OrderProductPeer::CREATED_AT);
        $c->setLimit(100);
        $orderProducts = OrderProductPeer::doSelectJoinProduct($c);

        $this->orderProducts = $orderProducts;
    }

}
