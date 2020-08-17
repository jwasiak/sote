<?php
/**
 * SOTESHOP/smContactFormFrontendPlugin
 *
 * Ten plik należy do aplikacji stInvoicePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     smContactFormFrontendPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 2285 2009-07-23 12:50:05Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Klasa smContactFormFrontendActions.
 *
 * @package     smProductOnFirstPagePlugin
 * @subpackage  actions
 */


class stAvailabilityFrontendActions extends sfActions
{
 
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
        
        $this->st_product_options = $this->getRequestParameter('st_product_options');

        $c = new Criteria();
        $c->add(ProductPeer::ID, $this->product_id);
        $products = ProductPeer::doSelectWithI18n($c);


        foreach ($products as $prod):

           $product = $prod;

        endforeach;


        $options = ProductOptionsValuePeer::retrieveByPKs($this->st_product_options);

        foreach ($options as $option)
        {
           $option_name .= $option->getValue()." ";
        }

        $this->option_name = $option_name;

        if($this->getRequest()->getMethod() == sfRequest::POST)
        {
          $question = $this->getRequestParameter('question');

          $this->sendMail($product, $question, $this->getRequestParameter('option_name'));

          $this->close = true;
        }

        $this->product = $product;

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

        $this->option_name = $this->getRequestParameter('option_name');

        $c = new Criteria();
        $c->add(ProductPeer::ID, $this->product_id);
        
        $this->product = ProductPeer::doSelectOne($c);


        $this->is_authenticated = $this->getUser()->isAuthenticated();

        $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');

        $this->updateFromRequestShowAddOverlay();

        return sfView::SUCCESS;
    }

    protected function updateFromRequestShowAddOverlay()
    {
        $i18n = $this->getContext()->getI18N();

        $question['username'] = $this->getRequestParameter('question[username]', $this->getUser()->isAuthenticated() ? $this->getUser()->getUsername() : false);

        $question['description'] = $this->getRequestParameter('question[description]', $this->getRequestParameter('question[description]')=="" ? $i18n->__('Proszę o przesłanie informacji o ponownej dostępności produktu w ofercie.') : false);

        $question['email'] = $this->getRequestParameter('question[email]');

        $this->question = $question;
    }

      /**
    * Obsługuje wysyłanie mail'i
    */
    function sendMail($product, $question, $option_name)
    {

        $this->smarty = new stSmarty($this->getModuleName());

        $mail_error = $this->MailWithQuestionToUser($product, $question, $option_name);

        return $mail_error;
    }

    /**
    * Wysyła mail z zamówieniem do administratora
    */
    function mailWithQuestionToUser($product, $question, $option_name)
    {
        $this->smarty = new stSmarty($this->getModuleName());

        $i18n = sfContext::getInstance()->getI18N();

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

        $base_question = new Questions();
        $base_question->setQuestionStatus(QuestionStatusPeer::retrieveDefaultNewStatus(new Criteria(), $con = null));
        $base_question->setType("depository");
        $base_question->setEmail($question['username']);
        $base_question->setItemId($product->getId());
        $base_question->setItemName($product->getName());
        $base_question->setText($product->getName()." ".$option_name." - ".$question['description']);
        $base_question->save();

        $this->mail_subject=$i18n->__('Zapytanie o dostępność produktu').': '.$this->product_name." ".$option_name;

        $mailHtmlHead = stMailer::getHtmlMailDescription(1);

        $mailHtmlFoot = stMailer::getHtmlMailDescription(2);

        $htmlMailMessage = stMailTemplate::render('_html', array(
            'from' => stXssSafe::clean($question['username']),
            'product_id' => stXssSafe::clean($product->getId()),
            'product_code' => $this->product->getCode(),
            'product_name' => $this->product->getName()." ".$option_name,
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

        $plainMailMessage = stMailTemplate::render('_plain', array(
            'from' => stXssSafe::clean($question['username']),
            'product_id' => stXssSafe::clean($product->getId()),
            'product_code' => $this->product->getCode(),
            'product_name' => $this->product->getName()." ".$option_name,
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
