<?php
class stMigrationSoteshopReviewBase extends stMigrationModel
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