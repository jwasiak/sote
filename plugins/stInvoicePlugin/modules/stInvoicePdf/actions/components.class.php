<?php
/**
 * SOTESHOP/stInvoicePlugin
 *
 * Ten plik należy do aplikacji stInvoicePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stInvoicePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 2285 2009-07-23 12:50:05Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Komponent stInvoiceFrontendComponents
 *
 * @package     stInvoicePlugin
 * @subpackage  actions
 */
class stInvoicePdfComponents extends sfComponents
{
    public function executeSellerInfo() 
    {  
    }

    public function executeDateInfo()
    {
        $this->config = stConfig::getInstance('stInvoiceBackend');
        
        
        $description = $this->invoice->getCompanyDescription();
        
        $test = substr($description,3);
        
        $this->invoice->setCompanyDescription($test);
    }
    
    public function executeSellerAddress() 
    {                
        $c = new Criteria();
        $c->add(InvoiceUserSellerPeer::ID  , $this->invoice->getInvoiceUserSellerId());        
        $InvoiceUserSeller = InvoiceUserSellerPeer::doSelectOne($c);
        
        $this->InvoiceUserSeller = $InvoiceUserSeller;
    }
    
    public function executeBuyerAddress() 
    {
        
        $c = new Criteria();
        $c->add(InvoiceUserCustomerPeer::ID  , $this->invoice->getInvoiceUserCustomerId());        
        $InvoiceUserCustomer = InvoiceUserCustomerPeer::doSelectOne($c);
        
        $this->InvoiceUserCustomer = $InvoiceUserCustomer;
    }

    public function executeInvoiceNumber() 
    {
        $this->config = stConfig::getInstance('stInvoiceBackend');        
    }
    
    public function executeInvoiceItems() 
    {
        $this->config = stConfig::getInstance('stInvoiceBackend');
           
        $invoiceProducts = $this->invoice->getInvoiceProducts();
        
        foreach ($invoiceProducts as $product)
        {    
            $tax = stTax::getById($product->getVatId());
            
            $product->setVat($tax);
        }
        
        $this->invoiceProducts = $invoiceProducts;
        
    }

    public function executeInvoiceTaxSummary() 
    {        
        $tax = stTax::get();
        
        $i=0;

        $taxProducts = array();


        $totals = array();

        foreach ($this->invoice->getInvoiceProducts() as $product)
        {
            if (!isset($totals[$product->getVatId()]))
            {
                $totals[$product->getVatId()] = $product->getOptTotalPriceBrutto();
            } 
            else
            {
                $totals[$product->getVatId()] += $product->getOptTotalPriceBrutto();
            }
        }

        foreach ($tax as $vat)
        {
            $i++; 
            
            $price_brutto_bufor = isset($totals[$vat->getId()]) ?  $totals[$vat->getId()] : 0;
            
            if($price_brutto_bufor)
            {
                $taxProducts[$i]['vat_id'] = $vat->getId();
                $taxProducts[$i]['vat_name'] = $vat->getVatName();
                $taxProducts[$i]['vat'] = $vat->getVat();
                $taxProducts[$i]['is_default'] = $vat->getIsDefault();
                $taxProducts[$i]['total_netto'] = stPrice::extract($price_brutto_bufor, $vat->getVat());
                $taxProducts[$i]['total_ammount_vat'] = $price_brutto_bufor - stPrice::extract($price_brutto_bufor, $vat->getVat());
                $taxProducts[$i]['total_brutto'] = $price_brutto_bufor;
            }
        }
        
        $this->taxProducts = $taxProducts;
    }
    
    public function executeInvoiceSummary() 
    {    
        if($this->invoice->getInvoiceCurrency())
        {
            $shortcut = $this->invoice->getInvoiceCurrency()->getShortcut();
            
        }else{
            
            $shortcut = "PLN";
        }
        
        $this->status = $this->invoice->getStatus();
        $this->shortcut = $shortcut;
        $this->culture = $this->culture;
        
        $this->paid_amount = $this->status->getPaidAmount() > 0 && !$this->status->getOptPaymentStatus() ? $this->status->getPaidAmount() : $this->invoice->getTotalAmount();
        
        if ($this->paid_amount > $this->invoice->getTotalAmount())
        {
            $this->paid_amount = $this->invoice->getTotalAmount();
        }

        $this->unpaid_amount = $this->invoice->getTotalAmount() - $this->paid_amount;
    }
    
    public function executeSellerSign() 
    {
    }

    public function executeBuyerSign() 
    {
    }
    
    public function  executeDownloadInvoice()
    {
        $ifirmaConfig = stConfig::getInstance(sfContext::getInstance(), 'stInvoiceBackend');
        $this->ifirma_enabled = $ifirmaConfig->get('ifirma_enabled');

        $id = $this->getRequestParameter('id');
        
        $this->invoiceDefault = stConfig::getInstance($this->getContext(), 'stInvoiceBackend');

        $invoiceDefault = $this->invoiceDefault->load();
        $this->order = OrderPeer::retrieveByPk($id);        
        if($invoiceDefault['proforma_on']==1)
        {
            $this->showProforma = 1;
        }else 
        {
            $this->showProforma = 0;
        }
        
        
        $c = new Criteria();
        $c->add(InvoicePeer::ORDER_ID, $id);
        $c->add(InvoicePeer::IS_PROFORMA, 1);
        $invoice = InvoicePeer::doSelectOne($c);
        
        if($invoice){
            $this->number = $invoice->getId();    
        }else{
            $this->number = false;
        }
    }
    
    public function  executeOrderInvoice()
    {
        
        $this->invoiceDefault = stConfig::getInstance($this->getContext(), 'stInvoiceBackend');

        $invoiceDefault = $this->invoiceDefault->load();
        
        if($invoiceDefault['proforma_on']==1)
        {
            $this->showProforma = 1;
        }else 
        {
            $this->showProforma = 0;
        }
        
        $c = new Criteria();
        $c->add(InvoicePeer::ORDER_ID, $this->order->getId());        
        $c->add(InvoicePeer::IS_PROFORMA, 1);
        $invoiceProforma = InvoicePeer::doSelectOne($c);
        
        
        $c = new Criteria();
        $c->add(InvoicePeer::ORDER_ID, $this->order->getId());        
        $c->add(InvoicePeer::IS_CONFIRM, 1);
        $invoiceConfirm = InvoicePeer::doSelectOne($c);

        $ifirmaConfig = stConfig::getInstance(sfContext::getInstance(), 'stInvoiceBackend');
        $this->ifirma_enabled = $ifirmaConfig->get('ifirma_enabled');
        
        if($invoiceProforma)
        {
            $this->invoiceNumberProforma = $invoiceProforma->getId();    
        }
        
        if($invoiceConfirm)
        {
            $this->invoiceNumber = $invoiceConfirm->getId();    
        }
        
    }
    
    public function isProforma($id)
    {
        $c = new Criteria();
        $c->add(InvoicePeer::ID, $id);        
        $invoice = InvoicePeer::doSelectOne($c);
        
        if($invoice->getIsProforma()==1)
        {
            return true;
        }
        else 
        {
            return false;
        }
        
        
        
    }
    
}
