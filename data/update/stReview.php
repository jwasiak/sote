<?php
try {
   if (version_compare($version_old, '1.2.0.7', '<'))
   {
       $databaseManager = new sfDatabaseManager();
       $databaseManager->initialize();

        $c = new Criteria();        
        $reviews = ReviewPeer::doSelect($c);

        
        foreach ($reviews as $review)
        {

           if($review->getSfGuardUserId()!="")
           {
                $c = new Criteria();
                $c->add(sfGuardUserPeer::ID, $review->getSfGuardUserId());
                $user = sfGuardUserPeer::doSelectOne($c);

                $review->setLanguage($user->getLanguage());
           }
           else
           {
              $language = LanguagePeer::doSelectDefault();
              $review->setLanguage($language->getOriginalLanguage());
           }

           $review->save();
        }

       $databaseManager->shutdown();
   }
} catch (Exception $e) {}

try {
  if (version_compare($version_old, '2.0.0.8', '<'))
  {
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
    
    $c = new Criteria();
    $c->add(ReviewPeer::LANGUAGE, NULL);
    $newReviewLanguages = ReviewPeer::doSelect($c);

    foreach ($newReviewLanguages as $newReviewLanguage) {
      $newReviewLanguage->setLanguage("pl_PL");
      $newReviewLanguage->save();
    }
    
  }
} catch (Exception $e) {}