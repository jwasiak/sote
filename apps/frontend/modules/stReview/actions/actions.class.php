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
 * @version     $Id: actions.class.php 14911 2011-09-01 08:57:13Z bartek $
 */

/**
 * stReview actions.
 *
 * @author Paweł Byszewski <pawel.byszewski@sote.pl>, Krzysztof Beblo <krzysztof.beblo@sote.pl>
 *
 * @package     stReview
 * @subpackage  actions
 */
class stReviewActions extends stActions
{
    /**
     * Dodaje recenzję
     */
    public function executeAdd()
    {
        if (!$this->getUser()->isAuthenticated())
        {
            $this->redirect('stUser/loginUser');
        }

        $this->smarty = new stSmarty($this->getModuleName());

        $this->order_id = $this->getRequestParameter('order_id');
        $this->order = OrderPeer::retrieveByIdAndHashCode($this->order_id, $this->getRequestParameter('hash_code'));
        $this->forward404Unless($this->order, 'Operacja niedozwolona - brak zamówienia o podanym numerze i ciągu hash');

        if ($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'))
        {
            $this->user=$this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
        }

        $this->review_order = array('mark' => '', 'description' => '');

        if ($this->getRequest()->getMethod() == sfRequest::POST){

            if ($this->hasRequestParameter('review'))
            {
                $this->review_order = $this->getRequestParameter('review');
            }
        }

        $c = new Criteria();
        $c->addJoin(OrderProductPeer::PRODUCT_ID, sprintf('%s AND %s = %s', ReviewPeer::PRODUCT_ID, ReviewPeer::ORDER_ID, $this->order_id), Criteria::LEFT_JOIN);
        $c->add(ReviewPeer::ID, null, Criteria::ISNULL);
        $c->add(OrderProductPeer::ORDER_ID, $this->order_id);
        $c->addGroupByColumn(OrderProductPeer::PRODUCT_ID);
        $this->review_products = OrderProductPeer::doSelect($c);
        $review_products = $this->review_products;

        $e = new Criteria();
        $e->add(ReviewPeer::ORDER_ID, $this->order_id);
        $e->add(ReviewPeer::SF_GUARD_USER_ID, $this->user);
        $e->add(ReviewPeer::AGREEMENT, 1, Criteria::NOT_EQUAL);
        $e->addOr(ReviewPeer::AGREEMENT, null, Criteria::ISNULL);
        $this->reviewed_products_without_agreement = ReviewPeer::doSelect($e);
        $reviewed_products_without_agreement = $this->reviewed_products_without_agreement;

        $d = new Criteria();
        $d->add(ReviewPeer::ORDER_ID, $this->order_id);
        $d->add(ReviewPeer::SF_GUARD_USER_ID, $this->user);
        $d->add(ReviewPeer::AGREEMENT, 1);
        $this->reviewed_products = ReviewPeer::doSelect($d);
        $reviewed_products = $this->reviewed_products;

        $c= new Criteria();
        $c->add(ReviewOrderPeer::ORDER_ID, $this->order_id);
        $c->add(ReviewOrderPeer::SF_GUARD_USER_ID, $this->user);
        $transaction = ReviewOrderPeer::doSelectOne($c);

        if ($transaction)
        {
            $this->reviewed_order = true;
            $this->transaction = $transaction;
            if (!$transaction->getAgreement())
            {
                $this->transaction = $transaction;
                $this->agreement = false;
            }
            else
            {
                $this->agreement = true;
            }
        }
        else
        {
            $this->agreement = false;
            $this->transaction = false;
            $this->reviewed_order = false;
        }
    }

    /**
     * Pokazuje listę recenzji produktów
     */
    public function executeListReviews()
    {

        if(!$this->getRequest()->isXmlHttpRequest() && $this->getController()->getRenderMode() != sfView::RENDER_VAR){  

        $this->getResponse()->setStatusCode(404);

        $this->getResponse()->setHttpHeader('Status', '404 Not Found');

        return $this->forward('stErrorFrontend', 'error404');
        }

        $this->smarty = new stSmarty($this->getModuleName());
        if ($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'))
        {
            $this->user=$this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
        }
        $this->setLayout(false);
        
        $this->product_id=$this->getRequestParameter('id');
        
        $c = new Criteria();
        $c->add(ReviewPeer::PRODUCT_ID, $this->getRequestParameter('id'));                                
        $c->add(ReviewPeer::IS_PIN_REVIEW, 0);                      
        $c->addDescendingOrderByColumn('created_at');        
        $this->reviews = ReviewPeer::doSelect($c);
        
        // echo "<pre>";
        // print_r($this->reviews);
        // echo "</pre>";
        
        if($this->getTheme()->getVersion()<8){
            
        $c = new Criteria();
        $c->add(ReviewPeer::PRODUCT_ID, $this->getRequestParameter('id'));                
        $c->add(ReviewPeer::IS_PIN_REVIEW, 0, Criteria::GREATER_THAN);                      
        $c->addDescendingOrderByColumn('pin_review');        
        $this->pin_reviews = ReviewPeer::doSelect($c);
        
        }
        
        // echo "<pre>";
        // print_r($this->pin_reviews);
        // echo "</pre>";        
        // die();
        
        $this->user_ip = $this->getRequest()->getHttpHeader ('addr','remote');
        $this->culture = $this->getUser()->getCulture();
    }


    /**
     * Zapisuje recenzję transakcji do bazy
     */
    public function executeSend()
    {

        $this->smarty = new stSmarty($this->getModuleName());
        $this->order_id = $this->getRequestParameter('order_id');
        $this->order = OrderPeer::retrieveByIdAndHashCode($this->order_id, $this->getRequestParameter('hash_code'));
        $this->forward404Unless($this->order, 'Operacja niedozwolona - brak zamówienia o podanym numerze i ciągu hash');
        $this->order_number = $this->order->getNumber();

        if ($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'))
        {
            $this->user=$this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
        }

        /**
         * Zapisuje recenzje transakcji
         */
        if ($this->getRequestParameter('transaction_id'))
        {
            if ($this->getRequestParameter('agreement')==true)
            {
                $review_order = ReviewOrderPeer::retrieveByPK($this->getRequestParameter('transaction_id'));
                $review_order->setAgreement(true);
                $review_order->save();
                $this->redirect('stReview/add?order_id='.$this->order_id.'&hash_code='.$this->order->getHashCode());
            }
            else
            {
                $this->redirect('stReview/add?order_id='.$this->order_id.'&hash_code='.$this->order->getHashCode());
            }
        }
        else
        {

            if ($this->getRequestParameter('description')!='')
            {
                $this->review_order = new ReviewOrder();
                $review_order = $this->getRequestParameter('review');
                $this->review_order->setOrderId($this->order_id);
                $this->review_order->setOrderNumber($this->order_number);
                $this->review_order->setSfGuardUserId($this->user);
                $this->review_order->setAgreement($this->getRequestParameter('agreement'));
                $this->review_order->setMark($this->getRequestParameter('mark'));
                $this->review_order->setDescription($this->getRequestParameter('description'));
                $this->review_order->save();

                $this->redirect('stReview/add?order_id='.$this->order_id.'&hash_code='.$this->order->getHashCode());
            }
            else
            {
                $this->redirect('stReview/add?order_id='.$this->order_id.'&hash_code='.$this->order->getHashCode());
            }
        }
    }

    /**
     * Zapisuje recenzje produktów
     */
    public function executeSaveProduct()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->order_id = $this->getRequestParameter('order_id');
        $this->order = OrderPeer::retrieveByIdAndHashCode($this->order_id, $this->getRequestParameter('hash_code'));
        $this->forward404Unless($this->order, 'Operacja niedozwolona - brak zamówienia o podanym numerze i ciągu hash');
        $this->order_number = $this->order->getNumber();

        if ($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'))
        {
        $this->user=$this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
        }
        //zapisuje recenzje produktow z zamowienia
        foreach ($this->getRequestParameter('review_product') as $id => $product)
        {
            if ($product['description']  && $product['score'] != 0)
            {
                $this->review = new Review;
                $this->review->setProductId($product['id']);
                $this->review->setSfGuardUserId($this->user);
                $this->review->setOrderId($this->order_id);
                $this->review->setOrderNumber($this->order_number);
                $this->review->setDescription($product['description']);
                $this->review->setAgreement($product['agreement']);
                $this->review->setScore($product['score']);
                $this->review->save();
            }
        }
        $this->redirect('stReview/add?order_id='.$this->order_id.'&hash_code='.$this->order->getHashCode());
    }

    /**
     * Obsługa błędu przy zapisywaniu recenzji produktu
     *
     */
    public function handleErrorSaveProduct()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->setTemplate('add');
        $this->executeAdd();
        return sfView::SUCCESS ;
    }

    /**
     * Walidacja zapisywania recenzji produktu
     *
     */
    public function validateSaveProduct()
    {
        $error_exists = false;

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $review_products = $this->getRequestParameter('review_product');

            foreach ($review_products as $id => $review_product)
            {
                if (empty($review_product['score']) && !empty($review_product['description']))
                {
                    $this->getRequest()->setError('review_product{'.$id.'}{score}', 'Brak oceny produktu');

                    $error_exists = true;
                }

                if (!empty($review_product['score']) && empty($review_product['description']))
                {
                    $this->getRequest()->setError('review_product{'.$id.'}{description}', 'Brak recenzji produktu');

                    $error_exists = true;
                }
            }
        }

        return !$error_exists;

    }

    /**
     * Zapisuje publikacje, jeśli wcześniej nie była ustawiona
     */
    public function executeSaveProductWithoutAgreement()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->order_id = $this->getRequestParameter('order_id');
        $this->order = OrderPeer::retrieveByIdAndHashCode($this->order_id, $this->getRequestParameter('hash_code'));
        $this->forward404Unless($this->order, 'Operacja niedozwolona - brak zamówienia o podanym numerze i ciągu hash');

        if ($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'))
        {
            $this->user=$this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
        }

        /**
         * Zapisuje recenzje produktow z zamowienia
         */
        foreach ($this->getRequestParameter('$order_product_reviewed_without_agreement_id[id]') as $product)
        {
            if ($this->getRequestParameter('agreement')==true)
            {
                    $review = ReviewPeer::retrieveByPK($product);
                    $review->setAgreement(true);
                    $review->save();
            }
        }
        $this->redirect('stReview/add?order_id='.$this->order_id.'&hash_code='.$this->order->getHashCode());
    }

    /**
     * Wyświetla listę recenzji zamówien klienta
     */
    public function executeListUserOrderReviews()
    {
        $this->smarty = new stSmarty($this->getModuleName());

        $this->forwardif($this->getUser()->isAnonymous(), 'stUser', 'loginUser');

        $c = new Criteria();

        $c->add(ReviewOrderPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());

        $this->pager = new sfPropelPager('ReviewOrder', 20);

        $this->pager->setPeerMethod('doSelectJoinAll');

        $this->pager->setCriteria($c);

        $this->pager->setPage($this->getRequestParameter('page'));

        $this->pager->init();

        $user_id = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
        $this->order_id = $this->getRequestParameter('order_id');
        $this->order = OrderPeer::retrieveByPK($this->order_id);

        $d = new Criteria();
        $d->add(ReviewOrderPeer::SF_GUARD_USER_ID, $user_id);
        $this->reviews_order = ReviewOrderPeer::doSelect($d);
    }

//     /**
//      * Wyświetla listę recenzji produktów klienta
//      */
//     public function executeListUserProductReviews()
//     {
//        $this->smarty = new stSmarty($this->getModuleName());
//
//        $this->forwardif($this->getUser()->isAnonymous(), 'stUser', 'loginUser');
//
//        $c = new Criteria();
//
//        $c->add(ReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());
//
//        $this->pager = new sfPropelPager('Review', 20);
//
//        $this->pager->setPeerMethod('doSelectJoinAll');
//
//        $this->pager->setCriteria($c);
//
//        $this->pager->setPage($this->getRequestParameter('page'));
//
//        $this->pager->init();
//
//        $user_id = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
//
//        $user_id = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
//        $this->order_id = $this->getRequestParameter('order_id');
//        $this->order = OrderPeer::retrieveByPK($this->order_id);
//
//        $d = new Criteria();
//        $d->add(ReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());
//        $this->reviews = ReviewPeer::doSelect($d);
//    }

    public function executeShowAddOverlay()
    {     

        if(!$this->getRequest()->isXmlHttpRequest()){  

        $this->getResponse()->setStatusCode(404);

        $this->getResponse()->setHttpHeader('Status', '404 Not Found');

        return $this->forward('stErrorFrontend', 'error404');
     }

        stFastCacheController::disable();

        $this->smarty = new stSmarty($this->getModuleName());

        $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
        
        $this->review_config = stConfig::getInstance($this->getContext(), 'stReview');
        
        $this->review_config->setCulture(sfContext::getInstance()->getUser()->getCulture());

        $this->product_id = $this->getRequestParameter('product_id');   
        
        $this->product = ProductPeer::retrieveByPK($this->getRequestParameter('product_id'));
        
        $product_hash_code = md5($this->product->getCreatedAt().$this->product->getId());
        
        $c = new Criteria();
        $c->add(OrderPeer::HASH_CODE, $this->getRequestParameter('hash_code'));
        $order = OrderPeer::doSelectOne($c);

        if($order){
            $this->hash_code = $this->getRequestParameter('hash_code');
            $this->order = $order;
        }elseif($product_hash_code==$this->getRequestParameter('hash_code')){
            $this->hash_code = $product_hash_code;
            $this->no_captcha = 1;
        }

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {

                $review = $this->getRequestParameter('review');
                $this->review = new Review;
                $this->review->setProductId($this->getRequestParameter('product_id'));
                $this->review->setSfGuardUserId($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
                $this->review->setDescription(stXssSafe::clean($review['description']));
                $this->review->setActive(1);
                $this->review->setAdminActive(1);
                $this->review->setUsername($review['username']);
                $this->review->setUserIp($this->getRequest()->getHttpHeader ('addr','remote'));
                $this->review->setScore($review['star']);
                $this->review->setLanguage($this->getUser()->getCulture());
                if($order){
                    $this->review->setOrderId($order->getId());
                }
                $this->review->save();
                stFastCacheManager::clearCache();
                
                $this->close = true;
        }

        $this->my_star_raiting = $this->getRequestParameter('value');

        $c = new Criteria();
        $c->add(ReviewPeer::PRODUCT_ID, $this->getRequestParameter('product_id'));
        $c->addDescendingOrderByColumn('admin_active');
        $reviews = ReviewPeer::doSelect($c);

        $scores=0;
        $i=0;
        $ii=0;
        foreach ($reviews as $review)
        {
            $scores += $review->getScore();
            if($review->getScore()>0){
                $ii++;        
            }
            
            $i++;
        }

        $this->scores = round($scores/$ii, 1);
        $this->count_review = $i;
        $this->star_raiting = round(round($scores/$ii, 1));

        $this->is_authenticated = $this->getUser()->isAuthenticated();
    }

    public function validateShowAddOverlay()
    {
        $error_exists = false;
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {

        $i18n = $this->getContext()->getI18N();

        $validator = new stCaptchaGDValidator();

        $validator->initialize($this->getContext(), array('captcha_error' => 'Wprowadzono zły numer.'));


        $captcha = $this->getRequestParameter('captcha');
        $hash_code = $this->getRequestParameter('hash_code');
        
        
        if($this->getRequestParameter('privacy')!=1  && !$this->getUser()->isAuthenticated() && $hash_code=="")
        {
                $this->getRequest()->setError('error_privacy', 1);
                $error_exists = true;
        }else{
            if (!$validator->execute($captcha, $error) && !$this->getUser()->isAuthenticated() && $hash_code=="")
            {
                $this->getRequest()->setError('captcha', $error);
                $error_exists = true;
            }
        }
               

        }
        return !$error_exists;
    }

     /**
     * Uchwyt do walidatora tworzenia konta.
     *
     * @return   string
     */
    public function handleErrorShowAddOverlay()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        $this->review_config = stConfig::getInstance($this->getContext(), 'stReview');        
        $this->review_config->setCulture(sfContext::getInstance()->getUser()->getCulture());

        $this->my_star_raiting = $this->getRequestParameter('review[star]');
        $this->product_id = $this->getRequestParameter('product_id');
        $this->product = ProductPeer::retrieveByPK($this->getRequestParameter('product_id'));
        $this->hash_code = $this->getRequestParameter('hash_code');

        $this->is_authenticated = $this->getUser()->isAuthenticated();

        $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
        return sfView::SUCCESS;
    }



}