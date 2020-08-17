<?php
/**
 * SOTESHOP/stMigrationSoteshopPlugin
 *
 * Ten plik należy do aplikacji stMigrationSoteshopPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stMigrationSoteshopPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stMigrationReview.class.php 16984 2012-02-07 12:00:51Z marcin $
 */

/**
 * Klasa odpowiadająca za obsługę procesu migracji
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigrationSoteshopPlugin
 * @subpackage  libs
 */
class stMigrationReview extends stMigrationModel
{
    /**
     *
     * @param Review $review
     */
    public function postCreate($review)
    {
        $review->setActive(true);

        $review->setAdminActive(true);

        $review->setAgreement(true);
        
        $review->setLanguage('pl_PL');
    }

    /**
     *
     * @param Review $review
     * @param string $user_id Id produktu nadane przez administratora
     */
    public function setMProductId($review, $user_id)
    {
        $c = new Criteria();

        $c->add(ProductPeer::CODE, stMigrationSoteshopHelper::fixString($user_id));

        $product = ProductPeer::doSelectOne($c);

        $review->setProductId($product ? $product->getId() : null);

        unset($product);
    }
}
