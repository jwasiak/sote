<?php
/**
 * 
 */

class stInvoicePdf {
    
    protected $pdf = null;
    
    protected $invoice = null;
        
    protected $showBorder = 0;
    
    public static $PDF_MARGIN_TOP = 5;
    
    public static $PDF_MARGIN_LEFT = 5;
    
    public static $PDF_MARGIN_RIGHT = 5;
    
    protected $download = "D";
    
    public function __construct($invoiceId) {
        /**
         * inicjalizacja klasy stInvoicePdf
         */
        $this->pdf = new stCustomTCPDF();

        $c = new Criteria();
        $c->add(InvoicePeer::ID, $invoiceId);        
        $this->invoice = InvoicePeer::doSelectOne($c);

        //tryb developerski
        if (SF_DEBUG) $this->showBorder=1;
        
        $this->configure();
    }

    public function getInvoice()
    {
        return $this->invoice;
    }
    
    protected function configure() {
        $this->pdf->SetFont("dejavusans", "", 11);
        $this->pdf->SetMargins(stInvoicePdf::$PDF_MARGIN_LEFT, stInvoicePdf::$PDF_MARGIN_TOP, stInvoicePdf::$PDF_MARGIN_RIGHT);
        $this->pdf->AddPage();
    }
    
    public function forceDownload($download = false) {
        $this->download = $download?"D":"I";
    }
    
    public function renderInvoice($culture_url = false, $hash_code = false) {
        
        $this->pdf->startPageGroup(); 
        
        $user = sfContext::getInstance()->getUser();
        $culture = $user->getCulture();
        
        if (SF_APP == 'backend' && $culture_url!=false)
        {   
            $user->setCulture($culture_url);
            $culture_print = $culture_url;
        }else{
            $culture_print = $culture;    
        }
        
        $config = stConfig::getInstance(sfContext::getInstance(), 'stInvoiceBackend');
        
        $sellerInfoHTML = st_get_component('stInvoicePdf', 'sellerInfo', array('invoice' => $this->invoice));
        $dateInfoHTML = st_get_component('stInvoicePdf', 'dateInfo', array('invoice' => $this->invoice));
        $sellerAddressHTML = st_get_component('stInvoicePdf', 'sellerAddress', array('invoice' => $this->invoice));
        $buyerAddressHTML = st_get_component('stInvoicePdf', 'buyerAddress', array('invoice' => $this->invoice));
        
        
        if($this->invoice->getIsProforma() != 1)
        {
            $invoiceNumberHTML = st_get_component('stInvoicePdf', 'invoiceNumber', array('invoice' => $this->invoice, 'invoiceType' => '1'));
        }
        else 
        {
            $invoiceNumberHTML = st_get_component('stInvoicePdf', 'invoiceNumber', array('invoice' => $this->invoice, 'invoiceType' => '3'));
        }
        
        
        $invoiceItemsHTML = st_get_component('stInvoicePdf', 'invoiceItems', array('invoice' => $this->invoice, 'config' => $config));
        $invoiceTaxSummaryHTML = st_get_component('stInvoicePdf', 'invoiceTaxSummary', array('invoice' => $this->invoice));
        $invoiceSummaryHTML = st_get_component('stInvoicePdf', 'invoiceSummary', array('invoice' => $this->invoice, 'culture' => $culture_print));
        $sellerSignHTML = st_get_component('stInvoicePdf', 'sellerSign', array('invoice' => $this->invoice));
        $buyerSignHTML = st_get_component('stInvoicePdf', 'buyerSign', array('invoice' => $this->invoice));      
        
        
        //$this->pdf->SetDrawColor(255, 255, 255);
        $this->pdf->SetDrawColor(120, 120, 120);
        $this->pdf->SetLineWidth(0.2); 
        
        $current_y_pos = stInvoicePdf::$PDF_MARGIN_TOP;
        $this->pdf->writeHTMLCell(100,0,0,$current_y_pos, $sellerInfoHTML,$this->showBorder,1,0);
        $new_y_pos = $this->pdf->getY();

        $this->pdf->writeHTMLCell(0,0,105,$current_y_pos, $dateInfoHTML,$this->showBorder,1,0); 
        if ($new_y_pos < $this->pdf->getY()) $new_y_pos = $this->pdf->getY();
        $current_y_pos = $new_y_pos;

        $this->pdf->writeHTMLCell(100,0,0,$current_y_pos, $sellerAddressHTML,$this->showBorder,1,0); 
        $new_y_pos = $this->pdf->getY();
        
        $this->pdf->writeHTMLCell(0,0,105,$current_y_pos, $buyerAddressHTML,$this->showBorder,1,0); 
        if ($new_y_pos < $this->pdf->getY()) $new_y_pos = $this->pdf->getY();
        $current_y_pos = $new_y_pos;
        
        $this->pdf->writeHTMLCell(0,0,0,$current_y_pos, $invoiceNumberHTML,$this->showBorder,1,0);
        $this->pdf->writeHTMLCell(0,0,0,0, $invoiceItemsHTML,$this->showBorder,1,0);
        $this->pdf->writeHTMLCell(0,0,70,0, $invoiceTaxSummaryHTML,$this->showBorder,1,0);
        $this->pdf->writeHTMLCell(0,0,0,0, $invoiceSummaryHTML,$this->showBorder,1,0);
        
        $current_y_pos = $this->pdf->getY();
        $this->pdf->writeHTMLCell(100,0,0,$current_y_pos, $sellerSignHTML,$this->showBorder,1,0);
        $this->pdf->writeHTMLCell(0,0,105,$current_y_pos, $buyerSignHTML,$this->showBorder,1,0);
        
             
        if($this->invoice->getIsProforma() != 1)
        {
            $invoiceNumberHTML = st_get_component('stInvoicePdf', 'invoiceNumber', array('invoice'=>$this->invoice, 'invoiceType'=>'2'));
                
            $this->pdf->AddPage(); 
            
           
            //$this->pdf->SetDrawColor(255, 255, 255);
            $this->pdf->SetDrawColor(120, 120, 120);
            $this->pdf->SetLineWidth(0.2); 
            
            $current_y_pos = stInvoicePdf::$PDF_MARGIN_TOP;
            $this->pdf->writeHTMLCell(100,0,0,$current_y_pos, $sellerInfoHTML,$this->showBorder,1,0);
            $new_y_pos = $this->pdf->getY();

            $this->pdf->writeHTMLCell(0,0,105,$current_y_pos, $dateInfoHTML,$this->showBorder,1,0); 
            if ($new_y_pos < $this->pdf->getY()) $new_y_pos = $this->pdf->getY();
            $current_y_pos = $new_y_pos;

            $this->pdf->writeHTMLCell(100,0,0,$current_y_pos, $sellerAddressHTML,$this->showBorder,1,0); 
            $new_y_pos = $this->pdf->getY();
            
            $this->pdf->writeHTMLCell(0,0,105,$current_y_pos, $buyerAddressHTML,$this->showBorder,1,0); 
            if ($new_y_pos < $this->pdf->getY()) $new_y_pos = $this->pdf->getY();
            $current_y_pos = $new_y_pos;
            
            $this->pdf->writeHTMLCell(0,0,0,$current_y_pos, $invoiceNumberHTML,$this->showBorder,1,0);
            $this->pdf->writeHTMLCell(0,0,0,0, $invoiceItemsHTML,$this->showBorder,1,0);
            $this->pdf->writeHTMLCell(0,0,70,0, $invoiceTaxSummaryHTML,$this->showBorder,1,0);
            $this->pdf->writeHTMLCell(0,0,0,0, $invoiceSummaryHTML,$this->showBorder,1,0);
            
            $current_y_pos = $this->pdf->getY();
            $this->pdf->writeHTMLCell(100,0,0,$current_y_pos, $sellerSignHTML,$this->showBorder,1,0);
            $this->pdf->writeHTMLCell(0,0,105,$current_y_pos, $buyerSignHTML,$this->showBorder,1,0);
        }  

        $result = $this->pdf->Output(null, 'S');    

        if($culture_url!=false){
            $user->setCulture($culture);    
        }   

        return $result;     
    }
}