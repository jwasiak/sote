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
 * @version     $Id: actions.class.php 1153 2009-10-07 08:24:35Z pawel $
 */

/** 
 * stReview actions
 *
 * @author Paweł Byszewski <pawel.byszewski@sote.pl>, Krzysztof Bebło <krzysztof.beblo@sote.pl>  
 *
 * @package     stReview
 * @subpackage  actions
 */
class stReviewActions extends autostReviewActions
{
    /** 
     * Filtr po kolumnie klient
     * Szukanie po imieniu i nazwisku, ale również po mail'u jeśli zawarta jest '@' w wyszukiwaniu
     *
     * @param      Criteria    $c
     */
    protected function addFiltersCriteria($c)
    {
        parent::addFiltersCriteria($c);
        if (isset($this->filters['filter_client']) && !empty($this->filters['filter_client']))
        {
            if (strpos($this->filters['filter_client'], '@') !== false)
            {
                $c->add(sfGuardUserPeer::USERNAME, '%' . $this->filters['filter_client'] . '%', Criteria::LIKE);
            }
            else
            {
                $client = explode(" ", $this->filters['filter_client']);

                $c->addJoin(UserDataPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID);
               
                $c->add(UserDataPeer::IS_BILLING, true);

                $c->add(UserDataPeer::NAME, '%' . $client[0] . '%', Criteria::LIKE);

                if (isset($client[1]) && !empty($client[1]))
                {
                    $c->add(UserDataPeer::SURNAME, '%' . $client[1] . '%', Criteria::LIKE);
                }
            }

        }
    }

    /** 
     * Filtr po kolumnie wyświetlania recenzji
     *
     * @param      Criteria    $criteria
     * @param        string      $status
     * @return   bool
     */
    protected function filterCriteriaByActive($criteria, $status)
    {
        if (!$status)
        {
            $criterion = $criteria->getNewCriterion(ReviewPeer::ACTIVE, false);
            $criterion->addOr($criteria->getNewCriterion(ReviewPeer::AGREEMENT, false));
            $criteria->add($criterion);
        }
        else
        {
            $criteria->add(ReviewPeer::ACTIVE, true);
            $criteria->add(ReviewPeer::AGREEMENT, true);
        }

        return true;
    }

    public function executeReviewAccept()
    {
        $request = $this->getRequest();

        if ($request->getMethod() == sfRequest::POST)
        
        {
    
            $id = $request->getParameter('id');

            $review = ReviewPeer::retrieveByPK($id);

            if ($review) 
            
            {

                $review->setAgreement(true);

                $review->save();

            }         

            return sfView::HEADER_ONLY;
    
        }
   
    }

    public function executeReviewSkip()
    {
        $request = $this->getRequest();

        if ($request->getMethod() == sfRequest::POST)
        
        {
    
            $id = $request->getParameter('id');

            $review = ReviewPeer::retrieveByPK($id);

            if ($review) 
            
            {

                $review->setSkipped(true);

                $review->save();

            }         

            return sfView::HEADER_ONLY;
    
        }
   
    }
    
    public function executeSendReviewRequest()
    {        
        $order_product = OrderProductPeer::retrieveByPK($this->getRequestParameter('order_product_id'));
        $order_product->setSendReview(date("Y-m-d H:i:s"));
        $order_product->save();
        
        stReview::sendMail($order_product->getOrder()->getSfGuardUser(), $order_product);
        $this->redirect('stOrder/edit?id='.$order_product->getOrderId());
    }
    
    public function executeConfig() {
        $context = $this->getContext();
        $this->config = stConfig::getInstance($context);
        $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));  
        
        $this -> select_options = array();
        
        $c = new Criteria();
        $orderStatus = OrderStatusPeer::doSelect($c);
        

        foreach ($orderStatus as $status) {
            $this->select_options[$status->getId()] = $status->getOptName();
        }

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            
            $updateConfig = $this->getRequestParameter('config');
            
            $this->config->set('auto_send', $updateConfig['auto_send']);
            $this->config->set('description', $updateConfig['description'], true);
            $this->config->set('order_status_type', $updateConfig['order_status_type']);
            $this->config->set('send_type', $updateConfig['send_type']);

            $this->config->save(true);
            stTheme::clearSmartyCache();
            stFastCacheManager::clearCache();

            $this->setFlash('notice', $context->getI18n()->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
            $this->redirect('stReview/config?culture='.$this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        }
    }

    public function validateConfig() {
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
         
        }
        return true;
    }
    
  protected function updateReviewFromRequest()
  {      
      
    $review = $this->getRequestParameter('review');

    if (isset($review['created_at']))
    {
      if ($review['created_at'])
      {
        try
        {
          $dateFormat = new sfDateFormat($this->getUser()->getCulture());
                              if (!is_array($review['created_at']))
          {
            $value = $dateFormat->format($review['created_at'], 'I', $dateFormat->getInputPattern('g'));
          }
          else
          {
            $value_array = $review['created_at'];
            $value = $value_array['year'].'-'.$value_array['month'].'-'.$value_array['day'].(isset($value_array['hour']) ? ' '.$value_array['hour'].':'.$value_array['minute'].(isset($value_array['second']) ? ':'.$value_array['second'] : '') : '');
          }
          $this->review->setCreatedAt($value);
        }
        catch (sfException $e)
        {
          // not a date
        }
      }
      else
      {
        $this->review->setCreatedAt(null);
      }
    }
    if (isset($review['language']))
    {
      if (method_exists($this->review, 'setLanguage'))
      {
        $this->review->setLanguage($review['language']);
      }
    }
    if (isset($review['product_link']))
    {
      if (method_exists($this->review, 'setProductLink'))
      {
        $this->review->setProductLink($review['product_link']);
      }
    }
    $this->review->setAgreement(isset($review['agreement']) ? $review['agreement'] : 0);
    $this->review->setIsPinReview(isset($review['is_pin_review']) ? $review['is_pin_review'] : 0);
    
    
    
    if(isset($review['is_pin_review']) && !$this->review->getPinReview()){
        
        $c = new Criteria();
        $c->add(ReviewPeer::PIN_REVIEW, $this->review->getPinReview(), Criteria::GREATER_THAN);
        $c->add(ReviewPeer::PRODUCT_ID, $this->review->getProductId());
        $c->addDescendingOrderByColumn(ReviewPeer::PIN_REVIEW);
        $max_review = ReviewPeer::doSelectOne($c);
        
        if($max_review){                    
            $this->review->setPinReview($max_review->getPinReview()+1);        
        }else{
            $this->review->setPinReview(1);    
        }        
    }
        
    if(!isset($review['is_pin_review'])){
        $this->review->setPinReview(0);
    }
    
    
    
    $this->review->setUserReviewVerified(isset($review['user_review_verified']) ? $review['user_review_verified'] : 0);
    if (isset($review['score']))
    {
      if (method_exists($this->review, 'setScore'))
      {
        $this->review->setScore($review['score']);
      }
    }
    if (isset($review['description']))
    {
      $this->review->setDescription($review['description']);
    }
    if (isset($review['admin_name']))
    {
      if (method_exists($this->review, 'setAdminName'))
      {
        $this->review->setAdminName($review['admin_name']);
      }
    }
            
      if ($this->getRequest()->getFileSize('review[user_picture]'))
      {
         $currentFile = sfConfig::get('sf_upload_dir') . $this->review->getUserPicture(); 
          
         $fileName = md5($this->getRequest()->getFileName('review[user_picture]') . time() . rand(0, 99999));
         $ext = $this->getRequest()->getFileExtension('review[user_picture]');
         if (is_file($currentFile))
         {
            unlink($currentFile);
         }                 
         $this->review->setUserPicture("/review_picture/" . $this->getRequestParameter('culture', stLanguage::getOptLanguage()) . '/' . $fileName . $ext);
                
         $this->getRequest()->moveFile('review[user_picture]', sfConfig::get('sf_upload_dir') . $this->review->getUserPicture());
      }                
     
    if (isset($review['user_facebook']))
    {
      $this->review->setUserFacebook($review['user_facebook']);
    }
    if (isset($review['user_instagram']))
    {
      $this->review->setUserInstagram($review['user_instagram']);
    }
    if (isset($review['user_youtube']))
    {
      $this->review->setUserYoutube($review['user_youtube']);
    }
    if (isset($review['user_twitter']))
    {
      $this->review->setUserTwitter($review['user_twitter']);
    }
    $this->getDispatcher()->notify(new sfEvent($this, 'autoStReviewActions.postUpdateFromRequest', array('modelInstance' => $this->review, 'requestParameters' => $review)));
  }  


   public function executeDeleteImage()
   {
        $request = $this->getRequest();       
                           
        $id = $request->getParameter('id');

        $review = ReviewPeer::retrieveByPK($id);

        if ($review){
            $review->setUserPicture(null);
            $review->save();
        }           
            
        stFastCacheManager::clearCache();
        foreach (glob(sfConfig::get('sf_root_dir').'/cache/smarty_c/*') as $file)
        {unlink($file);}
        
        $this->setFlash('notice', 'Zdjęcie zostało usunięte');
        $this->redirect('stReview/edit?id='.$id);            
       
    }
    
}