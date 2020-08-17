<?php
if (version_compare($version_old, '1.0.5.6', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
    
    $newQuestionStatus1 = new QuestionStatus();
    $newQuestionStatus1->setOptName("Anulowane");
    $newQuestionStatus1->setStatusType("ST_CANCELED");
    $newQuestionStatus1->setIsDefault(0);
    $newQuestionStatus1->setIsSystemDefault(1);
    $newQuestionStatus1->save();
    
    $newQuestionStatus2 = new QuestionStatus();
    $newQuestionStatus2->setOptName("Nowe");
    $newQuestionStatus2->setStatusType("ST_NEW");
    $newQuestionStatus2->setIsDefault(1);
    $newQuestionStatus2->setIsSystemDefault(1);
    $newQuestionStatus2->save();
    
    $newQuestionStatus3 = new QuestionStatus();
    $newQuestionStatus3->setOptName("Oczekuje");
    $newQuestionStatus3->setStatusType("ST_PENDING");
    $newQuestionStatus3->setIsDefault(0);
    $newQuestionStatus3->setIsSystemDefault(1);
    $newQuestionStatus3->save();
    
    $newQuestionStatus4 = new QuestionStatus();
    $newQuestionStatus4->setOptName("Wysłane");
    $newQuestionStatus4->setStatusType("ST_COMPLETE");
    $newQuestionStatus4->setIsDefault(0);
    $newQuestionStatus4->setIsSystemDefault(1);
    $newQuestionStatus4->save();
}

if (version_compare($version_old, '1.0.5.22', '<'))
{
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(QuestionStatusPeer::IS_SYSTEM_DEFAULT,1);
        $q_stats = QuestionStatusPeer::doSelect($c);

        foreach ($q_stats as $q_stat)
        {
            $q_stat->setCulture('pl_PL');
            $q_stat->setName($q_stat->getOptName());
            $q_stat->setStatusType($q_stat->getStatusType());
            $q_stat->setIsDefault($q_stat->getIsDefault());
            $q_stat->setIsSystemDefault($q_stat->getIsSystemDefault());
            $q_stat->setCulture('en_US');

            if ($q_stat->getStatusType()=="ST_CANCELED")
            {
                $q_stat->setName("Canceled");
            }

            if ($q_stat->getStatusType()=="ST_NEW")
            {
                $q_stat->setName("New");
            }

            if ($q_stat->getStatusType()=="ST_PENDING")
            {
                $q_stat->setName("Pending");
            }

            if ($q_stat->getStatusType()=="ST_COMPLETE")
            {
                $q_stat->setName("Complete");
            }

            $q_stat->save();
        }
    }
    catch (Exception $e)
    {
        if (SF_ENVIRONMENT == 'dev')
        {
            throw new PropelException($e);
        }
    }
}
?>