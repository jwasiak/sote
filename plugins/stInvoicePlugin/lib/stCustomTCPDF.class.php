<?php

class stCustomTCPDF extends sfTCPDF {
    
    public function Header() {
        
    }
    
    public function Footer() {
        $this->setY(-10);
        $this->SetFont("dejavusans", "",8);
        
    }
    
} 