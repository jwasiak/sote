<?php
class stUpdatePositioningPlugin
{
    protected $msg = '';

    protected $title = '';

    protected $langs = array();

    public function __construct()
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $this->langs = LanguagePeer::doSelectLanguages();
    }

    public function productUpdate($step)
    {
        sfLoader::loadPluginConfig();
        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(20);
        stPropelSeoUrlBehavior::configuration(array('auto_generate_url'=>true));

        $objects = ProductPeer::doSelect($c);
        foreach ($objects as $object) {
            foreach ($this->langs as $lang) {
                $object->setCulture($lang->getOriginalLanguage());
                try {
                    $object->save();
                } catch (Exception $e) {
                }
            }
        }
        $this->title = sfContext::getInstance()->getI18N()->__('Aktualizacja produktów', array(), 'stPositioningBackend');
        return ($step+count($objects));
    }

    public function categoryUpdate($step)
    {
        sfLoader::loadPluginConfig();
        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(20);
        stPropelSeoUrlBehavior::configuration(array('auto_generate_url'=>true));

        $objects = CategoryPeer::doSelect($c);
        foreach ($objects as $object) {
            foreach ($this->langs as $lang) {
                $object->setCulture($lang->getOriginalLanguage());
                try {
                    $object->save();
                } catch (Exception $e) {
                }
            }
        }
        $this->title = sfContext::getInstance()->getI18N()->__('Aktualizacja kategorii', array(), 'stPositioningBackend');
        return ($step+count($objects));
    }

    public function productGroupUpdate($step)
    {
        sfLoader::loadPluginConfig();
        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(1);
        stPropelSeoUrlBehavior::configuration(array('auto_generate_url'=>true));


        $object = ProductGroupPeer::doSelectOne($c);
        if (is_object($object)) {
            try {
                foreach ($this->langs as $lang) {
                    $object->setCulture($lang->getOriginalLanguage());
                    $object->save();
                }
            } catch (Exception $e) {
            }
        }
        $this->title = sfContext::getInstance()->getI18N()->__('Aktualizacja grup produktów', array(), 'stPositioningBackend');
        return $step+1;
    }

    public function webpageUpdate($step)
    {
        sfLoader::loadPluginConfig();
        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(1);
        stPropelSeoUrlBehavior::configuration(array('auto_generate_url'=>true));

        $object = WebpagePeer::doSelectOne($c);
        if (is_object($object)) {
            try {
                foreach ($this->langs as $lang) {
                    $object->setCulture($lang->getOriginalLanguage());
                    $object->save();
                }
            } catch (Exception $e) {
            }
        }
        $this->title = sfContext::getInstance()->getI18N()->__('Aktualizacja stron www', array(), 'stPositioningBackend');
        return $step+1;
    }

    /**
     * Generowanie linków dla producenta po aktualizacji
     */
    public function producerUpdate($step)
    {
        sfLoader::loadPluginConfig();
        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(20);
        stPropelSeoUrlBehavior::configuration(array('auto_generate_url'=>true));

        $objects = ProducerPeer::doSelect($c);
        foreach ($objects as $object) {
            foreach ($this->langs as $lang) {
                $object->setCulture($lang->getOriginalLanguage());
                try {
                    $object->save();
                } catch (Exception $e) {
                }
            }
        }
        $this->title = sfContext::getInstance()->getI18N()->__('Aktualizacja producentów', array(), 'stPositioningBackend');
        return ($step+count($objects));
    }

    /**
     * Generowanie linków dla bloga po aktualizacji
     */
    public function blogUpdate($step)
    {
        sfLoader::loadPluginConfig();
        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(20);
        stPropelSeoUrlBehavior::configuration(array('auto_generate_url'=>true));

        $objects = BlogrPeer::doSelect($c);
        foreach ($objects as $object) {
            foreach ($this->langs as $lang) {
                $object->setCulture($lang->getOriginalLanguage());
                try {
                    $object->save();
                } catch (Exception $e) {
                }
            }
        }
        $this->title = sfContext::getInstance()->getI18N()->__('Aktualizacja bloga', array(), 'stPositioningBackend');
        return ($step+count($objects));
    }

    public function getMessage()
    {
        return $this->msg;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function init()
    {
        $i18n = sfContext::getInstance()->getI18N();
        switch (sfContext::getInstance()->getRequest()->getParameterHolder()->get('name')) {
            case "stPositioning_ProductUpdate" :
                $this->title = $i18n->__('Aktualizacja produktów', array(), 'stPositioningBackend');
                break;
            case "stPositioning_CategoryUpdate" :
                $this->title = $i18n->__('Aktualizacja kategorii', array(), 'stPositioningBackend');
                break;
            case "stPositioning_ProductGroupUpdate" :
                $this->title = $i18n->__('Aktualizacja grup produktów', array(), 'stPositioningBackend');
                break;
            case "stPositioning_WebpageUpdate" :
                $this->title = $i18n->__('Aktualizacja stron www', array(), 'stPositioningBackend');
                break;
            case "stPositioning_BlogUpdate" :
                $this->title = $i18n->__('Aktualizacja bloga', array(), 'stPositioningBackend');
                break;
        }
    }

    public function close()
    {
        $i18n = sfContext::getInstance()->getI18N();
        switch (sfContext::getInstance()->getRequest()->getParameterHolder()->get('name')) {
            case "stPositioning_ProductUpdate" :
                $this->title = $i18n->__('Aktualizacja produktów', array(), 'stPositioningBackend');
                touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_ProductUpdate.log');
                break;
            case "stPositioning_CategoryUpdate" :
                $this->title = $i18n->__('Aktualizacja kategorii', array(), 'stPositioningBackend');
                touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_CategoryUpdate.log');
                break;
            case "stPositioning_ProductGroupUpdate" :
                $this->title = $i18n->__('Aktualizacja grup produktów', array(), 'stPositioningBackend');
                touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_ProductGroupUpdate.log');
                break;
            case "stPositioning_WebpageUpdate" :
                $this->title = $i18n->__('Aktualizacja stron www', array(), 'stPositioningBackend');
                touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_WebpageUpdate.log');
                break;
            case "stPositioning_BlogUpdate" :
                $this->title = $i18n->__('Aktualizacja bloga', array(), 'stPositioningBackend');
                touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_BlogUpdate.log');
                break;
        }
    }

    public static function postInstall(sfEvent $event) {
        sfLoader::loadHelpers('stProgressBar');
        sfLoader::loadHelpers('Partial');
        $event->getSubject()->msg .= progress_bar('stPositioning_ProductUpdate', 'stUpdatePositioningPlugin', 'productUpdate', ProductPeer::doCount(new Criteria()));
        $event->getSubject()->msg .= progress_bar('stPositioning_CategoryUpdate', 'stUpdatePositioningPlugin', 'categoryUpdate', CategoryPeer::doCount(new Criteria()));
        $event->getSubject()->msg .= progress_bar('stPositioning_ProductGroupUpdate', 'stUpdatePositioningPlugin', 'productGroupUpdate', ProductGroupPeer::doCount(new Criteria()));
        $event->getSubject()->msg .= progress_bar('stPositioning_WebpageUpdate', 'stUpdatePositioningPlugin', 'webpageUpdate', WebpagePeer::doCount(new Criteria()));
        $event->getSubject()->msg .= progress_bar('stPositioning_BlogUpdate', 'stUpdatePositioningPlugin', 'blogUpdate', BlogPeer::doCount(new Criteria()));
    }

     public static function postInstallProducer(sfEvent $event) {
        sfLoader::loadHelpers('stProgressBar');
        sfLoader::loadHelpers('Partial');
         $event->getSubject()->msg .= progress_bar('stPositioning_ProducerUpdate', 'stUpdatePositioningPlugin', 'producerUpdate', ProducerPeer::doCount(new Criteria()));
     }
}
