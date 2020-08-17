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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stReviewListener.class.php 11819 2011-03-25 08:06:52Z bartek $
 */

/** 
 * Podpięcie pod stProduct modułu stReview
 *
 * @author Paweł Byszewski <pawel.byszewski@sote.pl>  
 *
 * @package     stReview
 * @subpackage  libs
 */
class stReviewListener
{    
    /** 
     * Podpięcie linku do recenzji produktów w panelu klienta
     *
     * @param       sfEvent     $event
     */
    public static function postExecuteShow(sfEvent $event)
    {
        if(!stTheme::is_responsive()){
        
        $action = $event->getSubject();
        
        $config = stConfig::getInstance(sfContext::getInstance(), array(
        'product_views' => stConfig::STRING, 'price_view' => stConfig::STRING),
        'stProduct'
        );
        $config->load();
        
        $show_review=$config->get('show_review');

        $c = new Criteria();
        $c->add(ReviewPeer::PRODUCT_ID, $action->product->getId());
        $c->add(ReviewPeer::ACTIVE, 1);
        $criterion = $c->getNewCriterion(ReviewPeer::AGREEMENT, 1);
        $criterion->addOr($c->getNewCriterion(ReviewPeer::USER_IP, $action->getRequest()->getHttpHeader ('addr','remote')));
        $c->add($criterion);
        $c->add(ReviewPeer::DESCRIPTION, "", Criteria::NOT_IN);
     
        if ($show_review==1 && ReviewPeer::doSelectOne($c))
        {
            $action->productDescription->addTab('Recenzje', 'stReview', 'listReviews', array('id' => $action->product->getId()));
        }
        }
    }
    
     /** 
      * Podpięcie linku do recenzji zamówień w panelu klienta
      *
      * @param       sfEvent     $event
      */
     public static function postExecuteUserPanelMenu(sfEvent $event)
    {
       // $action = $event->getSubject();
        
       // $action->panel_navigator->addTab('Recenzje', 'stReview', 'listUserOrderReviews', null, 'listUserOrderReviews');
    }
    
    /** 
     * Podpięcie zdarzenia dla generatora produktu
     *
     * @param       sfEvent     $event
     */
    public static function generate(sfEvent $event)
    {
        // możemy wywoływać podaną metodę wielokrotnie co powoduje dołączenie kolejnych plików
            $event->getSubject()->attachAdminGeneratorFile('stReview', 'stProduct.yml');

    }
    
    /** 
     * Lista recenzji dla danego produktu
     *
     * @param       sfEvent     $event
     */
    public static function postExecuteReviewList(sfEvent $event)
    {
        $action = $event->getSubject();
        
        $action->pager->getCriteria()->add(ReviewPeer::PRODUCT_ID, $action->forward_parameters['product_id']);
        
        $action->pager->init();    
        
    }
    
    /** 
     * Dodawanie recenzji do produktu
     *
     * @param       sfEvent     $event
     */
    public static function preSaveProductReview(sfEvent $event)
    {
        $action = $event->getSubject();
        
        $product_id = $action->forward_parameters['product_id'];
        
        $review = $event['modelInstance'];
        
        $review->setProductId($product_id);
    }
    
    public static function postExecuteOrderSave(sfEvent $event) {
        
        $order = $event -> getSubject();
        
        if (!$order->isAllegroOrder())
        {

        if ($order->isColumnModified(OrderPeer::ORDER_STATUS_ID)) {

        $i18n = sfContext::getInstance() -> getI18n();

        $config = stConfig::getInstance('stReview');

        if($config -> get("auto_send")){                        

            $c = new Criteria();
            $c -> add(sfGuardUserPeer::ID, $order -> getSfGuardUserId());
            $sf_guard_user = sfGuardUserPeer::doSelectOne($c);
    
            $products = $order -> getOrderProducts();
            

            if ($config -> get("order_status_type") == $order -> getOrderStatusId()) {
                
                if ($config -> get("send_type") == 1){
                    $price = 0;
                    foreach ($products as $order_product){                        
                        if($order_product->getPrice() > $price){
                            $price = $order_product->getPrice();
                            $product = $order_product;
                        }                    
                    }
                }elseif($config -> get("send_type") == 2){
                    $product = $products[0];
                }
                
                if($product->getSendReview()==""){
                
                    $product->setSendReview(date("Y-m-d H:i:s"));
                    $product->save();
                    
                    stReview::sendMail($sf_guard_user, $product);
                }   
            }                       
        }

        }

        }

    }
}
?>