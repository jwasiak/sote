<?php

class stReview{

    /**
    * Obsługuje wysyłania mail'i
    */
   public static function getSendTime($date)
   {      
        //Convert to date
        $datestr=$date;//Your date
        $date=strtotime($datestr);//Converted to a PHP date (a second count)
        
        //Calculate difference
        $diff=time()-$date;//time returns current time in seconds
        $days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
        $hours=round(($diff-$days*60*60*24)/(60*60));

        if($days==0 && $hours==0){
            $remain =  __("Wysłano mniej niż godzinę temu");
        }elseif($days == 0 && $hours > 0){
            $remain =  __("Wysłano")." <b>".$hours."</b> ";
            if($hours==1){
                $remain.=__("godzinę temu");
            }else{
                $remain.=__("godzin temu");
            }
        }elseif($days > 0){
            $remain =  __("Wysłano")." <b>".$days."</b> ";
            if($days==1){
                $remain.=__("dzień temu");
            }else{
                $remain.=__("dni temu");
            }
        }
      return $remain;
   }

        
    /**
    * Obsługuje wysyłania mail'i
    */
   public static function sendMail($user, $order_product)
   {      
      $mail_error = stReview::mailWithRequestForReview($user, $order_product);
      return $mail_error;
   }

   /**
    * Wysyła mail z prośbą o recenzję
    */
   public static function mailWithRequestForReview($user, $order_product)
   {
      $config = stConfig::getInstance(sfContext::getInstance(), 'stReview');
      $config->setCulture($order_product->getOrder()->getClientCulture());   
            
      $product = $order_product->getProduct();
      $product->setCulture($order_product->getOrder()->getClientCulture());
      
      $culture = $order_product->getOrder()->getClientCulture();      
      sfContext::getInstance()->getUser()->setCulture($order_product->getOrder()->getClientCulture());
      
      $mail_config = stConfig::getInstance(sfContext::getInstance(), 'stMailAccountBackend');
       
       
      $sendRequestForReviewHtmlMailMessage = stMailTemplate::render('stReview/sendRequestForReviewHtml', array(
                  'user' => $user,
                  'order_product' => $order_product,
                  'product'=> $order_product->getProduct(),
                  'hash' => $order_product->getOrder()->getHashCode(),
                  'config' => $config,
                  'mail_config'=>$mail_config,
                  'user_head' => stMailer::getHtmlMailDescription("header"),
                  'user_foot' => stMailer::getHtmlMailDescription("footer"),
              ));

      $sendRequestForReviewMailMessage = stMailTemplate::render('stReview/sendRequestForReviewPlain', array(
                  'user' => $user,
                  'order_product' => $order_product,
                  'product'=> $order_product->getProduct(),
                  'hash' => $order_product->getOrder()->getHashCode(),
                  'config' => $config,
                  'user_head' => stMailer::getHtmlMailDescription("header"),
                  'user_foot' => stMailer::getHtmlMailDescription("footer"),
              ));

      $mail = stMailer::getInstance();
      $send = $mail->setSubject(sfContext::getInstance()->getRequest()->getHost()." - ".__('Twoja opinia o')." ".$order_product->getProduct()->getName())->setHtmlMessage($sendRequestForReviewHtmlMailMessage)->setPlainMessage($sendRequestForReviewPlainMailMessage)->setTo($order_product->getOrder()->getOptClientEmail())->sendToClient();
      sfContext::getInstance()->getUser()->setCulture($culture);
      
      return $send; 
      
   }

}
