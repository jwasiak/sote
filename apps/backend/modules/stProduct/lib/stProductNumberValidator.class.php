<?php
class stProductNumberValidator extends sfNumberValidator
{
    public function execute(&$value, &$error)
    {
        if (!parent::execute($value, $error))
        {
             return false;   
        }
        
        $vat = $this->getContext()->getRequest()->getParameter('product[vat]');
        
        $tax = TaxPeer::retrieveByPK($vat);

        $netto = stCurrency::extractNettoFromBrutto($value, $tax->getVat());

        $brutto = stCurrency::calculateBruttoFromNetto($netto, $tax->getVat());

        $config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');   
  
        if ($config->get('price_type') == 'brutto' && $value != $brutto)
        {            
            $field_name = $this->getParameter('field_name', 'product[price]');
            
            preg_match("/([^\[]+)\[([^\]]+)\]/", $field_name, $matches);    
            
            $field = $matches[1];
            
            $name = $matches[2];
            
            $fields = $this->getContext()->getRequest()->getParameter($field);
            
            $fields[$name] = $brutto;
                        
            $this->getContext()->getRequest()->setParameter($field, $fields);

            $error = 'Podana kwota brutto została skorygowana, kliknij "Zapisz" aby zatwierdzić zmiany';
            
            return false;
        }
        
        return true; 
    }
}