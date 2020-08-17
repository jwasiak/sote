<?php

/**
 * Subclass for performing query and update operations on the 'st_newsletter_user' table.
 *
 * @package     stNewsletterPlugin
 * @subpackage  libs
 */
class NewsletterUserPeer extends BaseNewsletterUserPeer
{
   public static function retrieveByEmail($email)
   {
      $c = new Criteria();

      $c->add(self::EMAIL, $email);

      return self::doSelectOne($c);
   }

   public static function getAssignedById($id)
   {
      $c = new Criteria();

      $c->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID);

      $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $id);

      NewsletterUserHasNewsletterGroupPeer::setHydrateMethod(array('NewsletterUserPeer', 'hydrateAssigned'));

      $ret = NewsletterUserHasNewsletterGroupPeer::doSelect($c);

      NewsletterUserHasNewsletterGroupPeer::setHydrateMethod(null);

      return $ret;
   }

   public static function hydrateAssigned(ResultSet $rs)
   {
      $results = array();

      $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);

      while($rs->next())
      {
         $results[$rs->getInt('NEWSLETTER_GROUP_ID')] = true;
      }

      return $results;
   }

}
