<?php
/*
 * @author  Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */
class appAdditionalDescFrontendActions extends stActions
{

    public function executeIndex()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->setLayout(false);
        
        $product = ProductPeer::getShowedProduct();
        if (!is_object($product))
            $product = ProductPeer::retrieveByPk($this->getRequestParameter('id'));      
        
       $this->description2 = $product->getDescription2();
        
    }

  
}