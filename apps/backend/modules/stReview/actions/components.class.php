<?php
/** 
 * SOTESHOP/stReview 
 * 
 * Ten plik należy do aplikacji stReview opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stReview
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 1153 2009-10-07 08:24:35Z pawel $
 */

/** 
 * stReview components
 *
 * @author Paweł Byszewski <pawel.byszewski@sote.pl>, Krzysztof Bebło <krzysztof.beblo@sote.pl>  
 *
 * @package     stReview
 * @subpackage  actions
 */
class stReviewComponents extends autostReviewComponents
{

    /** 
     * Wyciąga dane zarejestrowanego klienta
     */
    public function executeSfGuardUserIdList()
    {
        $c = new Criteria();
        $c->add(UserDataPeer::SF_GUARD_USER_ID, $this->review->getSfGuardUserId());
        $this->user_data = UserDataPeer::doSelectOne($c);
    }
    
    /** 
     * Wyciąga dane admina
     */
    public function executeAdminName()
    {
        $c = new Criteria();
        $c->add(UserDataPeer::SF_GUARD_USER_ID, $this->review->getSfGuardUserId());
        $this->user_data = UserDataPeer::doSelectOne($c);
    }
    

    public function executeReviewStatus()
    {
        if ($this->order_product->getOrder()->isAllegroOrder())
        {
            return sfView::NONE;
        }
    
    
        $c = new Criteria();
        $c->add(ReviewPeer::ORDER_ID, $this->order_product->getOrderId());
        $c->add(ReviewPeer::PRODUCT_ID, $this->order_product->getProductId());
        $this->reviewed_product = ReviewPeer::doSelectOne($c);
        
        
       
    }
    
    public function executeReviewListStatus()
    {
        
        
        if ($this->order->isAllegroOrder())
        {
            return sfView::NONE;
        }
        
        $config = stConfig::getInstance('stReview');        
        
        if($this->order->getOrderProducts()){
            if ($config -> get("send_type") == 1){
                 $price = null;
                foreach ($this->order->getOrderProducts() as $order_product) {
                
                    if($order_product->getPrice() > $price){
                        $price = $order_product->getPrice();
                        $product = $order_product;
                    }            
                 }
            }elseif($config -> get("send_type") == 2){
                $i = 0;
                foreach ($this->order->getOrderProducts() as $order_product) {        
                    if($i==0){
                        $product = $order_product;
                        $i++;
                    }                    
                }
            }
            $this->order_product = $product;
        }else{
            
            $this->order_product = null;
        }            
            
            $c = new Criteria();
            $c->add(ReviewPeer::ORDER_ID, $this->order->getId());
            if($this->order->getOrderProducts()){
            $c->add(ReviewPeer::PRODUCT_ID, $product->getProductId());
            }
            $this->reviewed_product = ReviewPeer::doSelectOne($c);
                 

    
    }

    public function executeLinkToAddReview()
    {            
        $c = new Criteria();
        $c->add(ProductPeer::ID, $this->product_id);            
        $product = ProductPeer::doSelectOne($c);
        
        $hash_code = md5($product->getCreatedAt().$this->product_id);            
        
        $this->product = $product;     
        $this->hash_code = $hash_code;
    }

}
?>