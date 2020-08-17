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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPluginQuestionBackendActions.class.php 15943 2011-11-04 08:42:08Z bartek $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/**
 * stQuestionBackend actions.
 *
 * @package     stQuestionPlugin
 * @subpackage  libs
 */
class stPluginQuestionBackendActions extends autostQuestionBackendActions
{
    public function executeSaveAndSend()
    {
        return $this->forward('stQuestionBackend', 'saveQuestions');
    }

    public function saveQuestions($question)
    {

      if($question->getEmail() && $this->hasRequestParameter('save_and_save'))
      {

          $this->sendMail($question);
          $question->setQuestionStatus(QuestionStatusPeer::retriveDefaultCompleteStatus());
      }
        
      parent::saveQuestions($question);
    }

    public function sendMail($question)
    {

        $context = sfContext::getInstance();
        
        stPluginHelper::addRouting('stQuestionLang', '/:lang/:url.html', 'stProduct', 'showFrontend', 'backend', array(), array('lang' => '[a-z]{2,2}'));

        stPluginHelper::addRouting('stQuestion', '/:url.html', 'stProduct', 'showFrontend', 'backend');
        
        $this->product = ProductPeer::retrieveByPK($question->getItemId());

        if ($this->product)
        {
            $this->product_name = $this->product;
            $this->product_code = $this->product->getCode();
            $this->product_producer = $this->product->getProducer();
            $this->product_category = $this->product->getCategory();
            $this->friendly_url = $this->product->getFriendlyUrl();
        } else {
            $this->product_name = $question->getItemName();
        }
        
        $c = new Criteria();
        
        $c->add(sfGuardUserPeer::USERNAME, $question->getEmail());
        $c->addJoin(sfGuardUserPeer::ID,UserDataPeer::SF_GUARD_USER_ID);
        $c->add(UserDataPeer::IS_BILLING,1);
        $c->add(UserDataPeer::IS_DEFAULT,1);
        $user = UserDataPeer::doSelectOne($c);
        
        if ($user)
        {
            if ($user->getName() && $user->getSurname())
            {
                $this->username = $user->getName().' '.$user->getSurname();
            } else {
                $this->username = $question->getEmail();    
            }
            
        } else {
            $this->username = $question->getEmail();
        }
        
        if ($question->getType()=='depository')
        {
            $this->mail_subject=$context->getI18N()->__('Odpowiedź na pytanie o dostępnosc produktu:').' '.$this->product_name;
        } 
        
        if ($question->getType()=='price') 
        {
            $this->mail_subject=$context->getI18N()->__('Odpowiedź na pytanie o cenę produktu:').' '.$this->product_name;
        }
        
        $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');
        
        $mailUserHtmlHead = stMailer::getHtmlMailDescription("top_question_answer");                
        $mailUserHtmlFoot = stMailer::getHtmlMailDescription("bottom_question_answer");

        $mailHtmlHead = stMailer::getHtmlMailDescription("header");                
        $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");

        $sendHtmlMailMessage = stMailTemplate::render('sendHtml', array(
        'question' => $question, 
        'product_name' => $this->product_name,
        'product_code' => $this->product_code,
        'product_producer' => $this->product_producer,
        'product_category' => $this->product_category,
        'friendly_url' => $this->friendly_url,
        'user' => $this->username,
        'product' => $this->product,
        'head' => $mailHtmlHead,
        'foot' => $mailHtmlFoot,
        'user_head' => $mailUserHtmlHead,
        'user_foot' => $mailUserHtmlFoot,
        'mail_config' => $mail_config,
        'mail_subject'=>$this->mail_subject,
        ));

        $sendPlainMailMessage = stMailTemplate::render('sendPlain', array(
        'question' => $question, 
        'product_name' => $this->product_name,
        'product_code' => $this->product_code,
        'product_producer' => $this->product_producer,
        'product_category' => $this->product_category,
        'friendly_url' => $this->friendly_url,
        'user' => $this->username,
        'product' => $this->product,
        'head' => $mailHtmlHead,
        'foot' => $mailHtmlFoot
        ));

        $mail = stMailer::getInstance();
        return $mail->setSubject($this->mail_subject)->setHtmlMessage($sendHtmlMailMessage)->setPlainMessage($sendPlainMailMessage)->setTo($question->getEmail())->sendToClient();
    }

    /**
     * Zapisywanie pokazywania zapytania przy dosteponosci
     *
     */
    protected function updateConfigFromRequest()
    {
        parent::updateConfigFromRequest();

        $config = $this->getRequestParameter('config');

        $this->config->set('depository_value', $config['depository_value']);
    }

    /**
    * Filtr po statusie zapytania
    *
    * @param      Criteria    $c
    */
    protected function addFiltersCriteria($c)
    {
        parent::addFiltersCriteria($c);

        if (isset($this->filters['filter_question_status']) && !empty($this->filters['filter_question_status']))
        {
            $c->add(QuestionsPeer::QUESTION_STATUS_ID, $this->filters['filter_question_status']);
        }
        
        if (isset($this->filters['item_name']) && !empty($this->filters['item_name']))
        {
            $c->add(QuestionsPeer::ITEM_NAME, '%'.$this->filters['item_name'].'%', Criteria::LIKE);
        }        
    }
}