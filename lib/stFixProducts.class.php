<?php
class stFixProducts {

    public $msg = '';

    public $title = "Wylicz poprawne ceny brutto <br/>";

    public function fixProducts($step) {
        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(20);
        $products = ProductPeer::doSelect($c);
        $con = Propel::getConnection('propel');
        $this->msg = "";
        foreach ($products as $product) 
        {
                $product->setName($product->getName());
                $product->setDescription($product->getDescription());
                $product->setShortDescription($product->getShortDescription());
                $product->save();              
                
        }
        return ($step+count($products));
    }


    public function getMessage() 
    {
        return $this->msg;
    }

    public function getTitle(){
        return $this->title;
    }

    public static function countProducts()
    {
        $c = new Criteria();
        return ProductPeer::doCount($c);
    }
    
    public function close()
    {
         $i18n = sfContext::getInstance()->getI18N();
         $url = sfContext::getInstance()->getController()->genUrl('stProduct/list', true);
         $this->msg = '<br /><a href=".$url.">'.$i18n->__('Przejdź do listy produktów').'</a>';
    }
}
?>