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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stNewsletter.class.php 3208 2010-01-28 13:12:43Z bartek $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa stNewsletter
 *
 * @package     stNewsletterPlugin
 * @subpackage  libs
 */
class stNewsletter {
    //    public static function send($offset = 0)
    //    {
    //        return $offset+1;
    //    }

    public static function getNewsletterGroups($object = null) {
        $c = new Criteria();
        $c -> add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $object -> getId());
        $c -> add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID . '=' . NewsletterGroupPeer::ID, Criteria::CUSTOM);

        $userGroups = NewsletterGroupPeer::doSelect($c);
        $groups = array();
        foreach ($userGroups as $group) {
            $groups[] = $group -> getName();
        }

        return implode('|', $groups);
    }

    public static function setNewsletterGroups($object = null, $value = '') {
        $c = new Criteria();
        $c -> add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $object -> getId());

        $remove = false;
        if ($value{0} != '+' && $value{0} != '-') {
            NewsletterUserHasNewsletterGroupPeer::doDelete($c);
            $remove = true;
        }

        $userGroups = explode('|', $value);
        if (is_array($userGroups)) {
            foreach ($userGroups as $group) {

                $modifier = null;
                if ($group{0} == '+' || $group{0} == '-') {
                    $modifier = $group{0};
                    $group = substr($group, 1);
                }

                $c = new Criteria();
                $c -> add(NewsletterGroupPeer::OPT_NAME, trim($group));
                $dbGroup = NewsletterGroupPeer::doSelectOne($c);
                if (!$dbGroup && strlen(trim($group)) && $modifier != '-') {
                    $dbGroup = new NewsletterGroup();
                    $dbGroup -> setCulture('pl_PL');
                    $dbGroup -> setName(trim($group));
                    $dbGroup -> save();
                }

                if ($dbGroup) {
                    if (($remove == true && $modifier == null) || ($remove == false && $modifier == '+')) {
                        $newslletterLink = new NewsletterUserHasNewsletterGroup();
                        $newslletterLink -> setNewsletterUser($object);
                        $newslletterLink -> setNewsletterGroup($dbGroup);
                        $newslletterLink -> save();
                    } elseif ($remove == false && $modifier == '-') {
                        $c = new Criteria();
                        $c -> add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $object -> getId());
                        $c -> add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, $dbGroup -> getId());
                        NewsletterUserHasNewsletterGroupPeer::doDelete($c);
                    }
                }
            }
        }
    }

    public static function addNewUserToNewsletterList($email, $user_id) {
        $c = new Criteria();
        $c -> add(NewsletterUserPeer::EMAIL, $email);
        $newsletterUser = NewsletterUserPeer::doSelectOne($c);

        if ($newsletterUser) {
            $newsletterUser -> setUserId($user_id);
            $newsletterUser -> save();
        }
    }

}
