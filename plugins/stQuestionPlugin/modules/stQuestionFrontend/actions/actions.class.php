<?php
/** 
 * SOTESHOP/stQuestionPlugin 
 * 
 * Ten plik należy do aplikacji stQuestionPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stQuestionPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 13803 2011-06-27 08:06:47Z bartek $
 * @author      Paweł Byszewski <pawel.byszewski@sote.pl>
 */

/** 
 * Akcje z stPluginQuestionFrontendActions.class.php
 *
 * @package     stQuestionPlugin
 * @subpackage  actions
 */
//require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'stPluginQuestionFrontendActions.class.php';

/** 
 * stQuestionFrontend actions.
 *
 * @package     stQuestionPlugin
 * @subpackage  actions
 */
class stQuestionFrontendActions extends stActions 
{
    public function executeAsk()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        $this->error = $this->getRequest()->hasErrors();
        $this->type = $this->getRequestParameter('type');
        $this->product_id = $this->getRequestParameter('product_id');
        $config = stConfig::getInstance(sfContext::getInstance(), array(
        'ask_price_user_login' => stConfig::BOOL ,
        'ask_depository_user_login' => stConfig::BOOL),
        'stQuestionBackend'
        );
        $config->load(); 
        $this->login_required = false;
        
        if ($config->get('ask_price_user_login')==1 and $this->type=='price')
        {
            $this->login_required = true;
        }
        else 
        {
            $this->login_required = false;
        }
        
        if ($config->get('ask_depository_user_login')==1 and $this->type=='depository')
        {
            $this->login_required = true;
        }
        else 
        {
            $this->login_required = false;
        }
        
        if($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'))
        {
            $this->user = $this->getUserEmail($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
        } else {
            $this->user = false;
        }
    }
    public function executeSend()
    {
        
        $this->smarty = new stSmarty($this->getModuleName());

        $i18n = sfContext::getInstance()->getI18N();
        
        $this->product_id = $this->getRequestParameter('question[product_id]');
        
        $this->product = ProductPeer::retrieveByPK($this->product_id);
        
        if ($this->product)
        {
            $this->product_code = $this->product->getCode();
            $this->product_name = $this->product->getName();
            $this->product_producer = $this->product->getProducer();
            $this->product_category = $this->product->getCategory();
            $this->friendly_url = $this->product->getFriendlyUrl();
        } else {
            $this->redirect('question/questionNotFound');
        }
        
        $this->error = $this->getRequest()->hasErrors();
        $this->type = $this->getRequestParameter('type');
        $this->question = $this->getRequestParameter('question');
        $base_question = new Questions();
        $base_question->setQuestionStatus(QuestionStatusPeer::retrieveDefaultNewStatus(new Criteria(), $con = null));
        $base_question->setType($this->getRequestParameter('type'));
        $base_question->setEmail($this->question['email']);
        $base_question->setItemId($this->question['product_id']);
        $base_question->setItemName($this->product_name);
        $base_question->setText($this->question['text']);
        $base_question->save();
        
        $this->id = $base_question->getId();
        
        if ($this->type=='depository')
        {
            $this->mail_subject=$i18n->__('Zapytanie o dostępność produktu').': '.$this->product_name.' ('.$i18n->__('zapytanie nr').' '.$this->id.')';
            $this->about=$i18n->__('dostępności');
        } 
        
        if ($this->type=='price') 
        {
            $this->mail_subject=$i18n->__('Zapytanie o cenę produktu').': '.$this->product_name.' ('.$i18n->__('zapytanie nr').' '.$this->id.')';
            $this->about=$i18n->__('cenie');
        }
        
        $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');
        
        $mailHtmlHead = stMailer::getHtmlMailDescription(1);
                
        $mailHtmlFoot = stMailer::getHtmlMailDescription(2);
                    
        $htmlMailMessage = stMailTemplate::render('_html', array(
            'from' => stXssSafe::clean($this->question['email']),
            'product_id' => stXssSafe::clean($this->question['product_id']),
            'product_code' => $this->product->getCode(),
            'product_name' => $this->product->getName(),
            'friendly_url' => $this->product->getFriendlyUrl(),
            'product_producer' => $this->product->getProducer(),
            'product_category' => $this->product->getCategory(),
            'product' => $this->product,
            'text' => stXssSafe::clean($this->question['text']),
            'id' => $this->id,
            'about' => $this->about,
            'head' => $mailHtmlHead,
            'foot' => $mailHtmlFoot,
            'mail_config' => $mail_config,
            'smarty' => $this->smarty
            
        ));
        
        $plainMailMessage = stMailTemplate::render('_plain', array(
            'from' => stXssSafe::clean($this->question['email']),
            'product_id' => stXssSafe::clean($this->question['product_id']),
            'product_code' => $this->product->getCode(),
            'product_name' => $this->product->getName(),
            'friendly_url' => $this->product->getFriendlyUrl(),
            'product_producer' => $this->product->getProducer(),
            'product_category' => $this->product->getCategory(),
            'product' => $this->product,
            'text' => stXssSafe::clean($this->question['text']),
            'id' => $this->id,
            'about' => $this->about,
            'head' => $mailHtmlHead,
            'foot' => $mailHtmlFoot,
            'smarty' => $this->smarty
        ));

        $mail = stMailer::getInstance();
        $mail->setSubject($this->mail_subject)->setHtmlMessage($htmlMailMessage)->setPlainMessage($plainMailMessage)->sendToMerchant();
    }
    public function handleErrorSend()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        $this->product_id = $this->getRequestParameter('question[product_id]');
        $this->error = $this->getRequest()->hasErrors();
        $this->type = $this->getRequestParameter('type');
        $config = stConfig::getInstance(sfContext::getInstance(), array(
        'ask_price_user_login' => stConfig::BOOL ,
        'ask_depository_user_login' => stConfig::BOOL),
        'stQuestionBackend'
        );
        $config->load(); 
        $this->login_required = false;
        $user = new sfBasicSecurityUser();
        
        if ($config->get('ask_price_user_login')==1 and $this->type=='price')
        {
            if($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'))
            {
                $this->user = $this->getUserEmail($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
                $this->login_required = true;
            }
            else 
            {
                $this->login_required = false;
            }
        }
        if ($config->get('ask_depository_user_login')==1 and $this->type=='depository')
        {
            if($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'))
            {
                $this->user = $this->getUserEmail($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
                $this->login_required = true;
            }
            else 
            {
                $this->login_required = false;
            }
        }
    }
    
    public function getUserEmail($user_id)
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        $c = new Criteria();
        $c->add(sfGuardUserPeer::ID, $user_id);
        $user = sfGuardUserPeer::doSelectOne($c);
        return $user;
    }
    
    public function executeQuestionNotFound()
    {
        $this->smarty = new stSmarty($this->getModuleName());
    }

    public function executeShowAddOverlay()
    {

        if(!$this->getRequest()->isXmlHttpRequest()){  

        $this->getResponse()->setStatusCode(404);

        $this->getResponse()->setHttpHeader('Status', '404 Not Found');

        return $this->forward('stErrorFrontend', 'error404');  
        }

        $this->smarty = new stSmarty($this->getModuleName());

        $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');

        $this->product_id = $this->getRequestParameter('product_id');
        $this->question_type = $this->getRequestParameter('question_type');

        $c = new Criteria();
        $c->add(ProductPeer::ID, $this->product_id);
        $product = ProductPeer::doSelectOne($c);

         
        if($this->getRequest()->getMethod() == sfRequest::POST)
        {
          $question = $this->getRequestParameter('question');
          $type = $this->getRequestParameter('question_type');

          $this->sendMail($product, $question, $type);
          $this->close = true;
        }

        $this->is_authenticated = $this->getUser()->isAuthenticated();
        
        $this->updateFromRequestShowAddOverlay();
    }

    public function validateShowAddOverlay()
    {
 
        $error_exists = false;
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {

            if($this->getRequestParameter('question[privacy]')!=1 && !$this->getUser()->isAuthenticated())
            {
                $this->getRequest()->setError('error_privacy', 1);
                $error_exists = true;
            }
            else 
            {

                $i18n = $this->getContext()->getI18N();
        
                $validator = new stCaptchaGDValidator();
        
                $validator->initialize($this->getContext(), array('captcha_error' => 'Wprowadzono zły numer.'));
        
        
                $captcha = $this->getRequestParameter('captcha');
        
                if (!$validator->execute($captcha, $error) && !$this->getUser()->isAuthenticated())
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

        $this->product_id = $this->getRequestParameter('product_id');

        $this->question_type = $this->getRequestParameter('question_type');

        $this->is_authenticated = $this->getUser()->isAuthenticated();

        $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
        
        $this->updateFromRequestShowAddOverlay();
        
        return sfView::SUCCESS;
    }
    
    protected function updateFromRequestShowAddOverlay()
    {
        $question['username'] = $this->getRequestParameter('question[username]', $this->getUser()->isAuthenticated() ? $this->getUser()->getUsername() : false);

        $question['description'] = $this->getRequestParameter('question[description]');
        
        $question['email'] = $this->getRequestParameter('question[email]');

        $this->question = $question;       
    }

     /**
    * Obsługuje wysyłanie mail'i
    */
    function SendMail($product, $question, $type)
    {
        $this->smarty = new stSmarty($this->getModuleName());

        $mail_error = $this->MailWithQuestionToUser($product, $question, $type);

        return $mail_error;
    }

    /**
    * Wysyła mail z zamówieniem do administratora
    */
    function mailWithQuestionToUser($product, $question, $type)
    {
        $this->smarty = new stSmarty($this->getModuleName());

        $i18n = sfContext::getInstance()->getI18N();


        $base_question = new Questions();
        $base_question->setQuestionStatus(QuestionStatusPeer::retrieveDefaultNewStatus(new Criteria(), $con = null));
        $base_question->setType($type);
        $base_question->setEmail($question['username']);
        $base_question->setItemId($product->getId());
        $base_question->setItemName($product->getName());
        $base_question->setText($question['description']);
        $base_question->save();

        $this->id = $base_question->getId();


        $this->product = $product;

        if ($this->product)
        {
            $this->product_code = $this->product->getCode();
            $this->product_name = $this->product->getName();
            $this->product_producer = $this->product->getProducer();
            $this->product_category = $this->product->getCategory();
            $this->friendly_url = $this->product->getFriendlyUrl();
        } else {
            $this->redirect('question/questionNotFound');
        }




        if ($type=='depository')
        {
            $this->mail_subject=$i18n->__('Zapytanie o dostępność produktu').': '.$this->product_name.' ('.$i18n->__('zapytanie nr').' '.$this->id.')';
            $this->about=$i18n->__('dostępności');
            $inner_mail_subject = $i18n->__('Zapytanie o dostępność produktu');
        }

        if ($type=='price')
        {
            $this->mail_subject=$i18n->__('Zapytanie o cenę produktu').': '.$this->product_name.' ('.$i18n->__('zapytanie nr').' '.$this->id.')';
            $this->about=$i18n->__('cenie');
            $inner_mail_subject = $i18n->__('Zapytanie o cenę produktu');
        }
        
        $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');

        $mailHtmlHead = stMailer::getHtmlMailDescription("header");
                
        $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");

        $htmlMailMessage = stMailTemplate::render('_html', array(
            'from' => stXssSafe::clean($question['username']),
            'product_id' => stXssSafe::clean($product->getId()),
            'product_code' => $this->product->getCode(),
            'product_name' => $this->product->getName(),
            'friendly_url' => $this->product->getFriendlyUrl(),
            'product_producer' => $this->product->getProducer(),
            'product_category' => $this->product->getCategory(),
            'product' => $this->product,
            'text' => stXssSafe::clean($question['description']),
            'id' => $this->id,
            'about' => $this->about,
            'head' => $mailHtmlHead,
            'foot' => $mailHtmlFoot,
            'mail_config' => $mail_config,
            'mail_subject'=>$inner_mail_subject,
            'smarty' => $this->smarty
        ));

        $plainMailMessage = stMailTemplate::render('_plain', array(
            'from' => stXssSafe::clean($question['username']),
            'product_id' => stXssSafe::clean($product->getId()),
            'product_code' => $this->product->getCode(),
            'product_name' => $this->product->getName(),
            'friendly_url' => $this->product->getFriendlyUrl(),
            'product_producer' => $this->product->getProducer(),
            'product_category' => $this->product->getCategory(),
            'product' => $this->product,
            'text' => stXssSafe::clean($question['description']),
            'id' => $this->id,
            'about' => $this->about,
            'head' => $mailHtmlHead,
            'foot' => $mailHtmlFoot,
            'smarty' => $this->smarty
        ));

        $mail = stMailer::getInstance();
        $mail->setSubject($this->mail_subject)->setHtmlMessage($htmlMailMessage)->setPlainMessage($plainMailMessage)->setReplyTo($question['username'])->sendToMerchant();

    }

}