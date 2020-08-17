<?php
/**
 * 
 */

class stOrderPrintPdf {
    
    protected $pdf = null;
    
    protected $order = null;
        
    protected $showBorder = 0;
    
    public static $PDF_MARGIN_TOP = 35;
    
    public static $PDF_MARGIN_LEFT = 15;
    
    public static $PDF_MARGIN_RIGHT = 15;
    
    protected $download = true;
    
    public function __construct($order) {
        /**
         * inicjalizacja klasy stInvoicePdf
         */
        $this->pdf = new stCustomTCPDF();
        $this->order = is_object($order) ? $order : OrderPeer::retrieveByPK($order);

        //tryb developerski
        if (SF_DEBUG) $this->showBorder=1;
        
        $this->configure();
    }
    
    protected function configure() {
        $this->pdf->SetFont("dejavusans", "", 10);
        $this->pdf->SetMargins(stOrderPrintPdf::$PDF_MARGIN_LEFT, stOrderPrintPdf::$PDF_MARGIN_TOP, stOrderPrintPdf::$PDF_MARGIN_RIGHT);

    }
    
    public function forceDownload($download = false) {
        $this->download = $download;
    }

    public function output()
    {
        return $this->pdf->Output(null, 'S');
    }
    
    public function renderOrder($output = true, Order $order = null) {
        
        if (null !== $order)
        {
            $this->order = $order;
        }

        $this->pdf->AddPage();
        
        $config = stConfig::getInstance(sfContext::getInstance(), 'stShopInfoBackend');
        
        $config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
        
        
        $this->pdf->startPageGroup(); 
        
        $c = new Criteria();
        $c->add(InvoicePeer::ORDER_ID , $this->order->getId());        
        $criterion = $c->getNewCriterion(InvoicePeer::IS_REQUEST, 1);
        $criterion->addOr($c->getNewCriterion(InvoicePeer::IS_CONFIRM, 1));
        $c->add($criterion);
        $invoice = InvoicePeer::doSelectOne($c);
        
        if($invoice){
            if($invoice->getIsRequest()==1 || $invoice->getIsConfirm()==1)
            {
                $invoice_type = "request";
            }
        }else{
            $invoice_type = "none";
        }
              
        $config_points -> setCulture($this->order->getClientCulture());
        
        $total_points_value = 0;
        $this->order_for_points = 0;
        foreach ($this->order->getOrderProducts() as $product){
            if($product->getProductForPoints()){
                $total_points_value += $product->getPointsValue() * $product->getQuantity();
                $this->order_for_points = 1;    
            }
        }  

        $user = sfContext::getInstance()->getUser();

        $culture = $user->getCulture();

        $user->setCulture($this->order->getClientCulture());
        
        if ($user->getCulture() == 'zh') $user->setCulture('en_US');

        sfLoader:: loadHelpers('stPayment');
        
        if ($this->order->getOrderPayment())
        {
            $payment_amount = st_payment_amount($this->order->getOrderPayment());
        }
          
        $this->orderInfoHTML = st_get_partial('stOrderPrintPdf/order_info', array('order' => $this->order, 'config_points'=>$config_points, 'total_points_value'=>$total_points_value));
        $this->orderItemsHTML = st_get_partial('stOrderPrintPdf/order_items', array('order' => $this->order, 'config_points'=>$config_points, 'order_for_points'=>$this->order_for_points));
        $billingAddressHTML = st_get_partial('stOrderPrintPdf/user_data', array('user_data' => $this->order->getOrderUserDataBilling()));
        $deliveryAddressHTML = st_get_partial('stOrderPrintPdf/user_data', array('user_data' => $this->order->getOrderUserDataDelivery()));
        $deliveryHTML = st_get_partial('stOrderPrintPdf/order_delivery', array('order' => $this->order));
        
        if ($this->order->getOrderPayment())
        {
            $paymentHTML = st_get_partial('stOrderPrintPdf/order_payment', array('order' => $this->order, 'payment_amount' => $payment_amount));
        }
        else
        {
            $paymentHTML = "";
        }


        $this->orderDataHTML = st_get_partial('stOrderPrintPdf/order_data', array('order' => $this->order, 'config'=>$config, 'invoice' => $invoice_type));
        $this->orderDescriptionHTML = st_get_partial('stOrderPrintPdf/order_description', array('order' => $this->order));
        
        
        //$this->pdf->SetDrawColor(255, 255, 255);
        $this->pdf->SetDrawColor(120, 120, 120);
        $this->pdf->SetLineWidth(0.2); 

        $current_y_pos = 15;
        
                
        $this->pdf->writeHTMLCell(100,0,0,$current_y_pos, $this->orderDataHTML,$this->showBorder,1,0);
        $new_y_pos = $this->pdf->getY();
       
        $current_y_pos = $this->pdf->getY();
        $this->pdf->writeHTMLCell(90,0,0,$current_y_pos, $billingAddressHTML,$this->showBorder,1,0); 
        $new_y_pos = $this->pdf->getY();

        $this->pdf->writeHTMLCell(0,0,105,$current_y_pos, $deliveryAddressHTML,$this->showBorder,1,0); 
        if ($new_y_pos < $this->pdf->getY()) $new_y_pos = $this->pdf->getY();
        $current_y_pos = $new_y_pos;
                       
        $this->pdf->writeHTMLCell(180,0,0,$current_y_pos, $this->orderItemsHTML,$this->showBorder,1,0);
        
        if ($new_y_pos < $this->pdf->getY()) $new_y_pos = $this->pdf->getY();
        $current_y_pos = $new_y_pos;
        
        if($this->pdf->getY()>240){
            $this->pdf->AddPage();
            $this->pdf->setPage($this->pdf->getPage());  
            $current_y_pos = 10;    
            $new_y_pos  = 10;   
        }
        
        $this->pdf->writeHTMLCell(180,0,0,$current_y_pos, $deliveryHTML, $this->showBorder,1,0);
        
        if ($new_y_pos < $this->pdf->getY()) $new_y_pos = $this->pdf->getY();
        $current_y_pos = $new_y_pos;
        
        $this->pdf->writeHTMLCell(180,0,0,$current_y_pos, $paymentHTML, $this->showBorder,1,0);
        
        if ($new_y_pos < $this->pdf->getY()) $new_y_pos = $this->pdf->getY();
        $current_y_pos = $new_y_pos;
        
        $this->pdf->writeHTMLCell(180,0,0,$current_y_pos, $this->orderDescriptionHTML, $this->showBorder,1,0);
        
        if ($new_y_pos < $this->pdf->getY()) $new_y_pos = $this->pdf->getY();
        $current_y_pos = $new_y_pos;
        
        $this->pdf->writeHTMLCell(180,0,0,$current_y_pos, $this->orderInfoHTML, $this->showBorder,1,0);
        
        $user->setCulture($culture);

        if ($output)
        {
            return $this->output();
        }
    }
}