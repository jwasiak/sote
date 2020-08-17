<?php

/**
 * Subclass for representing a row from the 'st_newsletter_user' table.
 *
 * @package     stNewsletterPlugin
 * @subpackage  libs
 */
class NewsletterUser extends BaseNewsletterUser
{

   public function save($con = null)
   {
      if ($this->isNew())
      {
         $this->generateHash();
      }

      parent::save($con);
   }

   public function setUserId($v)
   {
      $this->setSfGuardUserId($v);
   }

   public function getUserId()
   {
      return $this->getSfGuardUserId();
   }

   public function generateHash()
   {
      $this->setHash(md5(microtime()));
   }

   public function getHash()
   {
      if (parent::getHash() === null)
      {
         $this->generateHash();

         $this->save();
      }

      return parent::getHash();
   }

}
