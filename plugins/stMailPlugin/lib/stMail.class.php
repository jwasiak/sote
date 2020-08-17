<?php

/**
 * SOTESHOP/stMailPlugin
 *
 * Ten plik należy do aplikacji stMailPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stMailPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stMail.class.php 12185 2011-04-13 11:31:16Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa stMailTemplate
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stMailPlugin
 * @subpackage  libs
 */
class stMailTemplate
{

   /**
    * Zwraca zawartosc szablonu dla maili
    *
    * @param   string      $templateName       Nazwa szablonu
    * @param   array       $templateVars       zmienne przekazywane do szablonu
    * @return  string      zawartosc szablonu
    */
   static public function render($templateName, $templateVars = array())
   {
      $context = sfContext::getInstance();

      $actionName = $templateName."Mail";

      if (($pos = strpos($templateName, '/')) !== false)
      {
         $moduleName = substr($templateName, 0, $pos);

         $templateFile = substr($templateName, $pos + 1);
      }
      else
      {
         $moduleName = $context->getModuleName();

         $templateFile = $templateName;
      }

      $actionName = $templateFile.'Mail';

      $view = new sfPartialView();
      $view->initialize($context, $moduleName, $actionName, '');
      return $view->render($templateVars);
   }

}

/**
 * A wrapper class which implements most of the Swift mailer functionality
 *
 * This class only purpose is to maintain the compatibility between Swift mailer versions
 * 
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stMailPlugin
 * @subpackage  libs
 */
class stMail
{

   protected static $instance = array();
   protected static $port = array('tls' => 25, 'ssl' => 465, null => 25);
   /**
    * @var stMailLogger
    */
   protected $logger = null;
   /**
    * @var Swift_Message
    */
   protected $message = null;
   /**
    * @var Swift_Mailer
    */
   public $mailer = null;

   protected $attachments = array();

   const TIMEOUT = 30;

   /**
    * Singleton
    *
    * @return stMail instance
    */
   public static function getInstance($class = null)
   {
      if (!isset(self::$instance[$class]))
      {
         if (null === $class)
         {
            $class = __CLASS__;
         }

         self::$instance[$class] = new $class();

         self::$instance[$class]->initialize();
      }

      return self::$instance[$class];
   }

   /**
    *
    * Initialize
    *
    */
   public function initialize()
   {
      require_once sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stSwiftPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'swift_init.php';

      if (sfConfig::get('sf_logging_enabled'))
      {
         $this->logger = new stMailLogger();
      }

      $this->setConnection(Swift_SmtpTransport::newInstance());

      $this->createNewMessage();
   }

   /**
    *
    * Validate the current connection
    *
    * @return bool Return true if everything is ok, false otherwise
    */
   public function validateConnection()
   {
      $transport = $this->mailer->getTransport();

      try
      {
         $transport->start();
      }
      catch (Exception $e)
      {
         return false;
      }

      return $transport->isStarted();
   }

   /**
    *
    * Return Swift Mailer instance
    *
    * @return Swift_Mailer instance
    */
   public function getSwiftMailer()
   {
      return $this->mailer;
   }

   public function createNewMessage($subject = null, $body = null)
   {
      $this->message = Swift_Message::newInstance($subject, $body);

      return $this;
   }

   /**
    * @deprecated use setSmtpConnection
    */
   public function addSmtpConnection($email, $host = 'localhost', $port = null, $username = null, $password = null, $security = null)
   {
      return $this->setSmtpConnection($email, $host, $port, $username, $password, $security);
   }

   /**
    * Set a new smtp connection
    * @param string $sender
    * @param string $host
    * @param int $port
    * @param string $username
    * @param string $password
    * @param int $security
    * @return stMail instance
    */
   public function setSmtpConnection($sender, $host = 'localhost', $port = null, $username = null, $password = null, $security = null)
   {
      $transport = Swift_SmtpTransport::newInstance($host, $port, $security);
      if (isset($username))
      {
         $transport->setUsername($username);
      }

      if (isset($password))
      {
         $transport->setPassword($password);
      }

      $transport->setTimeout(self::TIMEOUT);

      $this->setConnection($transport);

      $this->setSender($sender);

      if (!$this->message->getFrom())
      {
         $this->setFrom($sender);
      }

      return $this;
   }

   /**
    * Set swift connection
    *
    * @param Swift_Transport $transport
    * 
    * @return stMail instance
    */
   public function setConnection($transport)
   {
      $this->mailer = Swift_Mailer::newInstance($transport);

      if ($this->logger)
      {
         $this->mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($this->logger));
      }

      return $this;
   }

   /**
    * Set the html body content of this message
    * @param string $content
    * 
    * @return stMail instance
    */
   public function setHtmlMessage($content)
   {
      $this->message->setBody(self::addHost($content), 'text/html');

      return $this;
   }

   /**
    * Set the alternative plain text body content of this message
    * @param string $content
    * 
    * @return stMail instance
    */
   public function setPlainMessage($content)
   {
      $this->message->addPart(self::addHost($content), 'text/plain');

      return $this;
   }

   /**
    * Set the From address
    * 
    * It is permissible for multiple From addresses to be set using an array.
    * 
    * If multiple From addresses are used, you SHOULD set the Sender address and
    * according to RFC 2822, MUST set the sender address.
    * 
    * An array can be used if display names are to be provided: i.e.
    * array('email@address.com' => 'Real Name').
    * 
    * If the second parameter is provided and the first is a string, then $name
    * is associated with the address.
    *
    * @param mixed $addresses
    * @param string $name optional
    */
   public function setFrom($addresses, $name = null)
   {
      $this->message->setFrom($addresses, $name);

      return $this;
   }

   /**
    * Set the sender of this message.
    * 
    * If multiple addresses are present in the From field, this SHOULD be set.
    * 
    * According to RFC 2822 it is a requirement when there are multiple From
    * addresses, but Swift itself does not require it directly.
    * 
    * An associative array (with one element!) can be used to provide a display-
    * name: i.e. array('email@address' => 'Real Name').
    * 
    * If the second parameter is provided and the first is a string, then $name
    * is associated with the address.
    * 
    * @param mixed $address
    * @param string $name optional
    * @return stMail instance 
    */
   public function setSender($address, $name = null)
   {
      $this->message->setSender($address, $name);

      return $this;
   }

   /**
    * Set the To address(es).
    * 
    * Recipients set in this field will receive a copy of this message.
    * 
    * This method has the same synopsis as {@link setFrom()} and {@link setCc()}.
    * 
    * If the second parameter is provided and the first is a string, then $name
    * is associated with the address.
    * 
    * @param mixed $addresses
    * @param string $name optional
    * @return stMail instance
    */
   public function setTo($addresses, $name = null)
   {
      $this->message->setTo($addresses, $name);

      return $this;
   }

   /**
    * Set the Bcc address(es).
    *
    * Recipients set in this field will receive a 'blind-carbon-copy' of this
    * message.
    *
    * In other words, they will get the message, but any other recipients of the
    * message will have no such knowledge of their receipt of it.
    *
    * This method has the same synopsis as {@link setFrom()} and {@link setTo()}.
    *
    * @param mixed $addresses
    * @param string $name optional
    */
   public function setBcc($addresses, $name = null)
   {
      $this->message->setBcc($addresses, $name);

      return $this;
   }

   /**
    * Add a Bcc: address
    *
    * If $name is passed this name will be associated with the address.
    *
    * @param string $address
    * @param string $name optional
    */
   public function addBcc($address, $name = null)
   {
      $this->message->addBcc($address, $name);
   }

   /**
    * Set the Reply-To address(es).
    * 
    * Any replies from the receiver will be sent to this address.
    * 
    * It is permissible for multiple reply-to addresses to be set using an array.
    * 
    * This method has the same synopsis as {@link setFrom()} and {@link setTo()}.
    * 
    * If the second parameter is provided and the first is a string, then $name
    * is associated with the address.
    * 
    * @param mixed $addresses
    * @param string $name optional
    * @return stMail instance
    */
   public function setReplyTo($addresses, $name = null)
   {
      $this->message->setReplyTo($addresses, $name);

      return $this;
   }

   /**
    * Set subject of this message
    *
    * @param string $subject  
    * @return stMail instance
    */
   public function setSubject($subject)
   {
      $this->message->setSubject($subject);

      return $this;
   }

   public function getSubject()
   {
      return $this->message->getSubject();
   }

   /**
    * Set the charaset of this message
    * 
    * @param string $charset
    * @return stMail instance
    */
   public function setCharset($charset = 'utf-8')
   {
      $this->message->setCharset($charset);

      return $this;
   }

   /**
    * Add a new Attachment from a filesystem path
    * 
    * @param string $filename optional
    * @param string $path
    * @param string $content_type optional
    * @return stMail instance
    */
   public function addAttachment($filename = null, $path, $content_type = null)
   {
      $attachment = Swift_Attachment::fromPath($path, $content_type);

      if ($filename)
      {
         $attachment->setFilename($filename);
      }

      $this->message->attach($attachment);

      $this->attachments[] = $attachment;

      return $this;
   }

   public function addAttachmentData($filename, $data, $content_type)
   {
      $attachment = Swift_Attachment::newInstance($data, $filename, $content_type); 
       
      $this->message->attach($attachment);

      $this->attachments[] = $attachment;

      return $this;          
   }

   public function removeAttachments()
   {
      foreach ($this->attachments as $attachment)
      {
         $this->message->detach($attachment);
      }

      $this->attachments = array();

      return $this;
   }

   /**
    * Send the given Message like it would be sent in a mail client.
    *
    * All recipients (with the exception of Bcc) will be able to see the other
    * recipients this message was sent to.
    *
    * If you need to send to each recipient without disclosing details about the
    * other recipients see {@link batchSend()}.
    *
    * The return value is the number of recipients who were accepted for
    * delivery.
    *
    * @param array &$failed_recipients, optional
    * @return int
    * @see batchSend()
    */
   public function send(&$failed_recipients = null)
   {
      try
      {
         $ret = $this->mailer->send($this->message, $failed_recipients);
      }
      catch (Exception $e)
      {
         $ret = false;
      }

      return $ret;
   }

   /**
    * Send the given Message to all recipients individually.
    *
    * This differs from {@link send()} in the way headers are presented to the
    * recipient.  The only recipient in the "To:" field will be the individual
    * recipient it was sent to.
    *
    * The return value is the number of recipients who were accepted for
    * delivery.
    *
    * @param array &$failedRecipients, optional
    * @return int
    * @see send()
    */
   public function sendBatch(&$failed_recipients = null)
   {
      try
      {
         $ret = $this->mailer->sendBatch($this->message, $failed_recipients);
      }
      catch (Exception $e)
      {
         $ret = false;
      }

      return $ret;
   }

   public static function defaultPort($security = null)
   {
      return isset(self::$port[$security]) ? self::$port[$security] : self::$port[null];
   }
   
   public static function getDefaultPorts()
   {
      return self::$port;
   }

   public static function addHost($content)
   {
      return sfContext::getInstance()->getRequest()->addHost($content);
   }

}
