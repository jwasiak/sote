<?php
try {
    if (version_compare($version_old, '1.1.1.2', '<'))
    {
        $dispatcher = stEventDispatcher::getInstance();
        $dispatcher->connect('stInstallerTaks.onClose', array('stTranslateCountries', 'postInstall'));
        stTranslateOrderStatus::updateStatusI18n();
    }

    /**
     * Ładowanie fixtures w przypadku gdy wystąpił błąd
     *
     * @author Michal Prochowski <michal.prochowski@sote.pl>
     */
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $language = LanguagePeer::doCount(new Criteria());

    if ($language == 0)
    {
        $pl = new Language();
        $pl->setName('Polska');
        $pl->setShortcut('pl');
        $pl->setActiveImage('1566c080cf8049d5cb86b18b7a610b16.png');
        $pl->setInactiveImage('e36ed4ad574c197ee1a323798c826fa2.png');
        $pl->setActive(1);
        $pl->setIsDefault(1);
        $pl->setLanguage('pl_PL');
        $pl->setIsTranslate(0);
        $pl->setSystem(1);
        $pl->save();

        $en = new Language();
        $en->setName('Angielska');
        $en->setShortcut('en');
        $en->setActiveImage('1dcf507142e7f2c1453d9ef1ccd8649a.png');
        $en->setInactiveImage('e62dec526f4e7df01cce2e301b013690.png');
        $en->setActive(1);
        $en->setIsDefault(0);
        $en->setLanguage('en_US');
        $en->setIsTranslate(1);
        $en->setSystem(1);
        $en->save();
    }

    if (version_compare($version_old, '1.0.6.18', '<'))
    {
        $laguageHasDomain = LanguageHasDomainPeer::doCount(new Criteria());
        if ($laguageHasDomain == 0)
        {
            $stWebRequest = new stWebRequest();

            $language = LanguagePeer::doSelectDefault();

            if (is_object($language))
            {
                $obj = new LanguageHasDomain();
                $obj->setLanguageId($language->getId());
                $obj->setDomain($stWebRequest->getHost());
                $obj->setIsDefault(1);
                $obj->save();
            }
        }
    }

    if (version_compare($version_old, '1.1.0.15', '<')) {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(LanguagePeer::LANGUAGE, 'pl_PL');
        $c->add(LanguagePeer::SYSTEM, 1);
        $l = LanguagePeer::doSelectOne($c);

        if (is_object($l))
        {
            $l->setCulture('pl_PL');
            $l->setName('Polska');
            $l->save();

            $l->setCulture('en_US');
            $l->setName('Polish');
            $l->save();
        }

        $c = new Criteria();
        $c->add(LanguagePeer::LANGUAGE, 'en_US');
        $c->add(LanguagePeer::SYSTEM, 1);
        $l = LanguagePeer::doSelectOne($c);

        if (is_object($l))
        {
            $l->setCulture('pl_PL');
            $l->setName('Angielska');
            $l->save();

            $l->setCulture('en_US');
            $l->setName('English');
            $l->save();
        }
    }

    if (version_compare($version_old, '1.1.0.16', '<')) {
        $c = new Criteria();
        $c->add(LanguagePeer::LANGUAGE, 'pl_PL');
        $c->add(LanguagePeer::SYSTEM, 1);
        $l = LanguagePeer::doSelectOne($c);

        if (is_object($l))
        {
            $l->setIsDefaultPanel(1);
            $l->setIsTranslatePanel(1);
            $l->save();
        }

        $c = new Criteria();
        $c->add(LanguagePeer::LANGUAGE, 'en_US');
        $c->add(LanguagePeer::SYSTEM, 1);
        $l = LanguagePeer::doSelectOne($c);

        if (is_object($l))
        {
            $l->setIsTranslatePanel(1);
            $l->save();
        }
    }
} catch (Exception $e) {}

try {
    if (version_compare($version_old, '2.1.0.8', '<')) {
        $phpTemplates = array('_shortcut.php', '_show_active_image.php', '_show_inactive_image.php');
        $path = sfConfig::get('sf_plugins_dir').'/stLanguagePlugin/modules/stLanguageBackend/templates/';

        foreach ($phpTemplates as $file) {
            if(file_exists($path.$file)) {
                unlink($path.$file);
            }
        }
    }
} catch (Exception $e) {}


if (version_compare($version_old, '7.1.1.7', '<'))
{
    $file = sfConfig::get('sf_root_dir').'/plugins/stLanguagePlugin/modules/stLanguageBackend/templates/_edit_form.php';

    if (is_file($file))
    {
        unlink($file);
    }
}