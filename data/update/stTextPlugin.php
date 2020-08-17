<?php
if (version_compare($version_old, '1.0.1.9', '<'))
{
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $texts = TextPeer::doSelect($c);
        foreach ($texts as $text)
        {
            $text->setCulture('pl_PL');
            $text->setName($text->getName());
            $text->setContent($text->getContent());
            $text->save();
        }
}