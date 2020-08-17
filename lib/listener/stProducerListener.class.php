<?php

class stProducerListener
{

    public static function postInstall(sfEvent $event)
    {
        $dbm = new sfDatabaseManager();
        
        $dbm->initialize();

        $count = ProducerPeer::doCount(new Criteria());

        if ($count > 0)
        {
            sfLoader::loadHelpers('stProgressBar', 'Partial');

            $event->getSubject()->msg .= progress_bar('stProducer', 'stProducerProgressBar', 'logoMigration', $count);
        }
    }

}

class stProducerProgressBar
{

    public function close()
    {
        $this->setMessage('Przenoszenie loga producentów zakończone pomyślnie');
    }

    public function logoMigration($offset = 0)
    {
        $this->initialize();

        $c = new Criteria();

        $c->setOffset($offset);

        $c->setLimit(10);

        $producers = ProducerPeer::doSelect($c);

        $web_dir = sfConfig::get('sf_web_dir');

        foreach ($producers as $producer)
        {
            $image = $producer->getImage();

            $filepath = $web_dir.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'producer'.DIRECTORY_SEPARATOR.$image;

            if ($image && is_file($filepath))
            {
                $ext = sfAssetsLibraryTools::getFileExtension($filepath);

                $producer->createAsset($producer->getId().'.'.$ext, $filepath);

                $producer->save();
            }

            $offset++;
        }

        $this->setMessage('Przenoszenia loga producentów w toku');

        return $offset;
    }

    protected function setMessage($message)
    {
        static $user = null;

        if (!$user)
        {
            $user = sfContext::getInstance()->getUser();
        }

        $user->setAttribute('stProgressBar-stProducer', $message, 'symfony/flash');
    }

    protected function initialize()
    {
        sfLoader::loadPluginConfig();

        $dbm = new sfDatabaseManager();

        $dbm->initialize();
    }

}