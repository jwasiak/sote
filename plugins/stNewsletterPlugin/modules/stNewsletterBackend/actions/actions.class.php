<?php

/**
 * SOTESHOP/stNewsletterPlugin
 *
 * Ten plik należy do aplikacji stNewsletterPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stNewsletterPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 13778 2011-06-21 12:01:22Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Klasa stNewsletterFrontendActions.
 *
 * @package     stNewsletterPlugin
 * @subpackage  actions
 */
class stNewsletterBackendActions extends autoStNewsletterBackendActions {

    protected function addNewsletterUserFiltersCriteria($c) {
        parent::addNewsletterUserFiltersCriteria($c);

        if (isset($this -> filters['group']) && $this -> filters['group']) {
            $c -> addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, NewsletterUserPeer::ID);

            $c -> add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, $this -> filters['group']);
        }
    }

    public function executeSaveAndSendConfirm() {
        $this -> forward('stNewsletterBackend', 'edit');
    }

    /**
     * Obsługuje wysyłanie mail'i
     */
    function SendMailConfirm($user, $group, $hash) {
        $mail_error = $this -> mailWithConfirmRegisterToUser($user, $group, $hash);
        return $mail_error;
    }

    /**
     * Wysyła mail z zamówieniem do administratora
     */
    protected function mailWithConfirmRegisterToUser($user, $group, $hash) {
        
        $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');
        
        $mailHead = stMailer::getHtmlMailDescription("header");

        $mailFoot = stMailer::getHtmlMailDescription("footer");
        
        $sendConfirmRegisterToUserHtmlMailMessage = stMailTemplate::render('confirmUserHtml', array('user' => $user, 'group' => $group, 'hash' => $hash, 'head' => $mailHead, 'foot' => $mailFoot,  'mail_config'=>$mail_config ));

        $sendConfirmRegisterToUserPlainMailMessage = stMailTemplate::render('confirmUserPlain', array('user' => $user, 'group' => $group, 'hash' => $hash, ));

        $mail = stMailer::getInstance();
        return $mail -> setSubject($this -> getContext() -> getI18N() -> __('Rejestracja na liście subskrypcji.')) -> setHtmlMessage($sendConfirmRegisterToUserHtmlMailMessage) -> setPlainMessage($sendConfirmRegisterToUserPlainMailMessage) -> setTo($user -> getEmail()) -> sendToClient();
    }

    public function executeNewsletterSend() {
        $newsletter = NewsletterMessagePeer::retrieveByPK($this -> getRequestParameter('id'));

        $this -> count = $newsletter -> countUsers(new Criteria());

        stNewsletterProgressBar::setParam('id', $newsletter -> getId());
    }

    public function executeSaveAndSend() {
        return $this -> forward('stNewsletterBackend', 'edit');
    }

    protected function savesfGuardUser($sf_guard_user) {
        if (!$sf_guard_user -> getId()) {
            $sf_guard_user -> addGroupByName('user');
            $sf_guard_user -> setHashCode(md5(microtime()));
        }

        parent::savesfGuardUser($sf_guard_user);
    }

    protected function saveNewsletterMessage($newsletter_message) {
        parent::saveNewsletterMessage($newsletter_message);

        $c = new Criteria();

        $c -> add(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_MESSAGE_ID, $newsletter_message -> getId());

        BasePeer::doDelete($c, Propel::getConnection());

        $newsletter_group = $this -> getRequestParameter('newsletter_message[newsletter_group]');

        foreach ($newsletter_group as $id) {
            $ng = new NewsletterMessageHasNewsletterGroup();

            $ng -> setNewsletterGroupId($id);

            $ng -> setNewsletterMessageId($newsletter_message -> getId());

            $ng -> save();
        }

        if ($this -> hasRequestParameter('save_and_send')) {
            return $this -> redirect('stNewsletterBackend/newsletterSend?id=' . $newsletter_message -> getId());
        }
    }

    protected function saveNewsletterUserNewsletterUser($newsletter_user) {
        parent::saveNewsletterUserNewsletterUser($newsletter_user);

        $newsletter_user -> setLanguage($this -> getRequestParameter('newsletter_user[language]'));
        $newsletter_user -> save();

        $c = new Criteria();

        $c -> add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $newsletter_user -> getId());

        BasePeer::doDelete($c, Propel::getConnection());

        $newsletter_group = $this -> getRequestParameter('newsletter_user[newsletter_group]');

        foreach ($newsletter_group as $id) {
            $ng = new NewsletterUserHasNewsletterGroup();

            $ng -> setNewsletterGroupId($id);

            $ng -> setNewsletterUserId($newsletter_user -> getId());

            $ng -> save();
        }

        if ($this -> hasRequestParameter('save_and_send_confirm')) {
            $c = new Criteria();
            $c -> addJoin(NewsletterGroupPeer::ID, NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID);
            $c -> add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $newsletter_user -> getId());
            $c -> add(NewsletterGroupPeer::IS_PUBLIC, 1);
            $choseGroup = NewsletterGroupPeer::doSelect($c);

            return ($this -> sendMailConfirm($newsletter_user, $choseGroup, $newsletter_user -> getHash()));
        }

    }

    protected function updateConfigFromRequest() {
        $config = $this -> getRequestParameter('config');

        $this -> config -> set('newsletter_enabled', isset($config['newsletter_enabled']) ? $config['newsletter_enabled'] : false, false);

        $this -> config -> set('newsletter_on', isset($config['newsletter_on']) ? $config['newsletter_on'] : false, false);

        $this -> config -> set('newsletter_default_culture', $config['newsletter_default_culture'], false);

        $this -> config -> set('templates', $config['templates'], true);
        
        $this -> config -> set('register_message_on', $config['register_message_on'], false);
        
        $this -> config -> set('register_message_title', $config['register_message_title'], true);
        
        $this -> config -> set('register_message_templates', $config['register_message_templates'], true);
        
        $this -> config -> set('register_text_title', $config['register_text_title'], true);
        
        $this -> config -> set('register_text_description', $config['register_text_description'], true);
        
        $this -> config -> set('register_text_under_register', $config['register_text_under_register'], true);
        
        $this -> config -> set('register_text_widget_title', $config['register_text_widget_title'], true);
        
        $this -> config -> set('register_text_widget_description', $config['register_text_widget_description'], true);

    }

    protected function saveConfig() 
    {     

        $this->config->save();

        WebpagePeer::clearCache();

        stFastCacheManager::clearCache();
    
    }

}
