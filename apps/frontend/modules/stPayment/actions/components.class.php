<?php
/** 
 * SOTESHOP/stPayment 
 * 
 * Ten plik należy do aplikacji stPayment opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stPayment
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 13721 2011-06-20 14:13:12Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>,
 */

/** 
 * Klasa stPaymentComponents
 *
 * @package     stPayment
 * @subpackage  actions
 */
class stPaymentComponents extends sfComponents
{
    /** 
     * Wyświetlenie listy płatności
     */
    public function executeSelectPaymentType()
    {
        $this->smarty = new stSmarty('stPayment');
        $c = new Criteria();
        $c->add(PaymentTypePeer::ACTIVE, 1);
        $this->paymentTypes = PaymentTypePeer::doSelect($c);
        
        $paymentTypes = $this->paymentTypes;
        foreach ($paymentTypes as $key => $paymentType)
        {
            if(class_exists($paymentType->getModuleName()))
            {
                $moduleName = $paymentType->getModuleName();
                $obj = new $moduleName;
                if(method_exists($obj, 'checkPaymentConfiguration'))
                {
                    if (!$obj->checkPaymentConfiguration())
                    {
                        unset($this->paymentTypes[$key]);
                    }
                }
            }
        }
        
        $this->hasPaymentType = false;
        if (count($this->paymentTypes) > 0)
        {
            $this->hasPaymentType = true;
        }
        
        $this->checked = 0;
        
        $paymentType = stPayment::getInstance($this->getContext());
        if(is_object($paymentType->get())) $this->checked = $paymentType->get()->getId();
    }

    /** 
     * Pokazanie płatności w podsumowaniu zamówienia
     */
    public function executeShowPayment()
    {
        $this->smarty = new stSmarty('stPayment');
        
        $this->paymentType = null;
        $this->paymentTypeName = null;

        if (!isset($this->order))
        {
            $this->order = OrderPeer::retrieveByIdAndHashCode($this->getRequestParameter('id'), $this->getRequestParameter('hash_code'));
        } 
        
        if (null === $this->order)
        {
            return sfView::NONE;
        }

        $payment = $this->order->getOrderPayment();
        
        if (!$payment)
        {
           return sfView::NONE;
        }

        

        $this->paymentType = $payment->getPaymentType()->getModuleName();
        $this->paymentTypeName = $payment->getPaymentType()->getName();
        
        if(!$this->getController()->componentExists($this->paymentType.'Frontend', 'showPayment'))
        {
            return sfView::NONE;
        }
    }

    public function executeProcessPayment()
    {
        $payment = $this->order->getOrderPayment();

        if(!$this->order->showPayment() || !$this->getController()->actionExists($payment->getPaymentType()->getModuleName().'Frontend', 'processPayment'))
        {
            return sfView::NONE;
        }  

        sfLoader::loadHelpers(array('Helper', 'stUrl'));

        $this->smarty = new stSmarty('stPayment');
        $this->smarty->assign('api', $payment->getPaymentType()->getApiInstance());
        $this->smarty->assign('action', st_url_for($payment->getPaymentType()->getModuleName().'Frontend/processPayment?id='.$this->order->getId().'&hash='.$this->order->getHashCode()));
    }
    
    /**
     * Pokazywanie informacji na karcie produktu
     */
    public function executeShowInfoInProduct()
    {
        if ($this->product && !$this->product->isPriceVisible())
        {
            return sfView::NONE;
        }
        
    	$this->smarty = new stSmarty('stPayment');
    	$this->smarty->assign('santander', stSantander::isActive());
        $this->smarty->assign('lukas', stLukas::isActive());
    }
}