<?php

/**
 * Subclass for representing a row from the 'st_newsletter_message' table.
 *
 * @package     stNewsletterPlugin
 * @subpackage  libs
 */
class NewsletterMessage extends BaseNewsletterMessage
{

   public function getUsers(Criteria $c)
   {
      $c = clone $c;

      $this->addUserCriteria($c);

      $c->addGroupByColumn(NewsletterUserPeer::ID);

      return NewsletterUserPeer::doSelect($c);
   }

   public function countUsers(Criteria $c)
   {
      $c = clone $c;

      $this->addUserCriteria($c);

      return NewsletterUserPeer::doCount($c, true);
   }

   protected function addUserCriteria(Criteria $c)
   {
      $c->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, NewsletterUserPeer::ID);

      $c->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID);

      $c->add(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_MESSAGE_ID, $this->getId());

      $c->add(NewsletterUserPeer::ACTIVE, true);

      $c->add(NewsletterUserPeer::CONFIRM, true);
   }
   
   public function getSubject()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }

      $v = parent::getSubject();

      if (is_null($v))
      {
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      }

      return $v;
   }

   /**
    * Przeciążenie setName
    *
    * @param string
    */
   public function setSubject($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setSubject($v);
   }
   
      public function getContent()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }
      $v = parent::getContent();
      if (is_null($v))
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      return $v;
   }

   public function setContent($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setContent($v);
   }

}
