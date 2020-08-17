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
 * @version     $Id: components.class.php 13445 2011-06-03 13:37:14Z bartek $
 */

/**
 * stReview components.
 *
 * @author Paweł Byszewski <pawel.byszewski@sote.pl>, Krzysztof Beblo <krzysztof.beblo@sote.pl>
 *
 * @package     stReview
 * @subpackage  actions
 */
class stReviewComponents extends sfComponents
{

   /**
    * Wyswietla link do recenzji
    */
   public function executeAddReview()
   {
      $this->smarty = new stSmarty('stReview');

      $c = new Criteria();
      $c->add(ReviewOrderPeer::ORDER_ID, $this->order->getId());
      $this->review_order = ReviewOrderPeer::doSelect($c);

      $d = new Criteria();
      $d->add(ReviewPeer::ORDER_ID, $this->order->getId());
      $d->add(ReviewPeer::AGREEMENT, null, Criteria::ISNOTNULL);
      $this->review = ReviewPeer::doSelect($d);
      $this->review_count = ReviewPeer::doCount($d);

      $e = new Criteria();
      $e->add(OrderProductPeer::ORDER_ID, $this->order->getId());
      $this->ordered = OrderProductPeer::doSelect($e);
      $this->ordered_count = OrderProductPeer::doCount($e);

      if ($this->review_count == $this->ordered_count)
      {
         $this->are_reviewed = 1;
      }
      else
      {
         $this->are_reviewed = 0;
      }
   }

   /**
    * Wyswietla link do recenzji
    */
   public function executeAddReviewList()
   {
      $this->smarty = new stSmarty('stReview');

      $c = new Criteria();
      $c->add(ReviewOrderPeer::ORDER_ID, $this->order->getId());
      $this->review_order = ReviewOrderPeer::doSelect($c);

      $d = new Criteria();
      $d->add(ReviewPeer::ORDER_ID, $this->order->getId());
      $d->add(ReviewPeer::AGREEMENT, null, Criteria::ISNOTNULL);
      $this->review = ReviewPeer::doSelect($d);
      $this->review_count = ReviewPeer::doCount($d);

      $e = new Criteria();
      $e->add(OrderProductPeer::ORDER_ID, $this->order->getId());
      $this->ordered = OrderProductPeer::doSelect($e);
      $this->ordered_count = OrderProductPeer::doCount($e);

      if ($this->review_count == $this->ordered_count)
      {
         $this->are_reviewed = 1;
      }
      else
      {
         $this->are_reviewed = 0;
      }
   }

   /**
    * Wyswietla liste produktow w zamowieniu
    */
   public function executeListProducts()
   {
      $this->smarty = new stSmarty('stReview');

      $this->product_id = $this->getRequestParameter('product_id');
      $this->product = ProductPeer::retrieveByPK($this->product_id);
      $this->order_id = $this->getRequestParameter('order_id');
      $this->order = OrderPeer::retrieveByPK($this->order_id);
   }

   /**
    * Wyświetla listę zrecenzjonowanych produktów
    */
   public function executeListProductsReviewed()
   {
      $this->smarty = new stSmarty('stReview');

      $this->product_id = $this->getRequestParameter('product_id');
      $this->product = ProductPeer::retrieveByPK($this->product_id);
      $this->order_id = $this->getRequestParameter('order_id');
      $this->order = OrderPeer::retrieveByPK($this->order_id);
   }

   /**
    * Wyświetla listę zrecenzjonowanych produktów, ale bez publikacji
    */
   public function executeListProductsReviewedWithoutAgreement()
   {
      $this->smarty = new stSmarty('stReview');

      $this->product_id = $this->getRequestParameter('product_id');
      $this->product = ProductPeer::retrieveByPK($this->product_id);
      $this->order_id = $this->getRequestParameter('order_id');
      $this->order = OrderPeer::retrieveByPK($this->order_id);
   }

   /**
    * Wyświetla recenzje transakcji
    */
   public function executeTransactionReview()
   {
      $this->smarty = new stSmarty('stReview');

      $this->order_id = $this->getRequestParameter('order_id');
      $this->order = OrderPeer::retrieveByPK($this->order_id);
   }

   /**
    * Wyświetla link do recenzji
    */
   public function executeAdd()
   {
      $this->smarty = new stSmarty('stReview');

      $this->smarty = new stSmarty($this->getModuleName());
      $this->product_id = $this->getRequestParameter('product_id');
      $this->product = ProductPeer::retrieveByPK($this->product_id);
      $this->order_id = $this->getRequestParameter('order_id');
      $this->order = OrderPeer::retrieveByPK($this->order_id);
      $this->order_product_id = $this->getRequestParameter('order_product_id');
      $this->order_product = OrderProductPeer::retrieveByPK($this->order_product_id);

      if ($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'))
      {
         $this->user = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
      }

      $this->review_order = array('mark' => '', 'description' => '');

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {

         if ($this->hasRequestParameter('review'))
         {
            $this->review_order = $this->getRequestParameter('review');
         }
      }
   }

   public function executeShowStars()
   {
      $this->smarty = new stSmarty('stReview');

      if (!isset($this->product))
      {
         $this->product = ProductPeer::retrieveByPK($this->getRequestParameter('product_id', $this->getRequestParameter('id')));
      }

      $c = new Criteria();
      $c->add(ReviewPeer::PRODUCT_ID, $this->product->getId());
      $c->add(ReviewPeer::ACTIVE, 1);
      $c->addDescendingOrderByColumn('admin_active');
      $criterion = $c->getNewCriterion(ReviewPeer::AGREEMENT, 1);
      $criterion->addOr($c->getNewCriterion(ReviewPeer::USER_IP, $this->getRequest()->getHttpHeader('addr', 'remote')));
      $c->add($criterion);

      $reviews = ReviewPeer::doSelect($c);

      $scores = 0;
      $lockd_star = 0;
      $i = 0;
      $ii = 0;
      $empty_description = 0;
      foreach ($reviews as $review)
      {
         $scores += $review->getScore();
                  
        if($review->getScore()>0){
            $ii++;        
        }
            
         $i++;
         if ($review->getUserIp() == $this->getRequest()->getHttpHeader('addr', 'remote'))
         {
            $lockd_star = 1;
         }

         if ($review->getDescription() == "")
         {
            $empty_description++;
         }
      }

      if ($scores != 0)
      {
         $this->scores = round($scores / $ii, 1);
         $this->star_raiting = round(round($scores / $ii, 1));
      }
      else
      {
         $this->scores = 0;
         $this->star_raiting = 0;
      }

      $this->lockd_star = $lockd_star;

      $this->count_review = $i - $empty_description;
      
      $this->hash_code = "";
      $hash_code = $this->getRequestParameter('hash_code');
      $product_hash_code = md5($this->product->getCreatedAt().$this->product->getId());

      if($hash_code!=""){
        $c = new Criteria();
        $c->add(OrderPeer::HASH_CODE, $hash_code);
        $order = OrderPeer::doSelectOne($c);
           
        if($order){
            $this->show_review_popup = 1;
            $this->hash_code = $order->getHashCode();          
        }elseif($product_hash_code==$hash_code){          
            $this->show_review_popup = 1;
            $this->hash_code = $product_hash_code;
        }

      }
   }

    
   public function executeShowPinReview()
   {
        $this->smarty = new stSmarty('stReview');
       
        $c = new Criteria();
        $c->add(ReviewPeer::PRODUCT_ID, $this->getRequestParameter('id'));                                
        $c->add(ReviewPeer::IS_PIN_REVIEW, 1);                    
        $c->addDescendingOrderByColumn('pin_review');
        $this->reviews = ReviewPeer::doSelect($c);
        
        $this->culture = $this->getUser()->getCulture();
        
        // echo "<pre>";
        // print_r($this->reviews);
        // die();
   }

}