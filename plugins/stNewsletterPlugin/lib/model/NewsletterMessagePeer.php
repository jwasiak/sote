<?php

/**
 * Subclass for performing query and update operations on the 'st_newsletter_message' table.
 *
 * @package     stNewsletterPlugin
 * @subpackage  libs
 */
class NewsletterMessagePeer extends BaseNewsletterMessagePeer
{

   public static function getAssignedById($id)
   {
      $c = new Criteria();

      $c->addSelectColumn(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID);

      $c->add(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_MESSAGE_ID, $id);

      NewsletterMessageHasNewsletterGroupPeer::setHydrateMethod(array('NewsletterMessagePeer', 'hydrateAssigned'));

      $ret = NewsletterMessageHasNewsletterGroupPeer::doSelect($c);

      NewsletterMessageHasNewsletterGroupPeer::setHydrateMethod(null);

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
