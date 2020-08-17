<?php
class stFixPositioning
{
    protected $msg = '';

    protected $title = '';

    protected $langs = array();

    public function __construct()
    {
        $active = sfContext::getInstance()->getUser()->getAttribute('languages', array(), 'soteshop/stFixPositioning');

        $langs = LanguagePeer::doSelectActive();

        foreach ($langs as $lang)
        {
            if (isset($active[$lang->getId()]))
            {
                $this->langs[] = $lang;
            }
        }
    }

    public function productUpdate($step)
    {
        if (!$step)
        {
            foreach ($this->langs as $lang)
            {
                if (stLanguage::getOptLanguage() == $lang->getOriginalLanguage())
                {
                    self::setNull(ProductPeer::TABLE_NAME, ProductPeer::OPT_URL);
                }
                
                self::setNull(ProductI18nPeer::TABLE_NAME, ProductI18nPeer::URL, ProductI18nPeer::CULTURE, $lang->getOriginalLanguage());
            }
        }

        $i18n = sfContext::getInstance()->getI18N();
        stPropelSeoUrlBehavior::configuration(array('auto_generate_url'=>true));
        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(20);

        foreach ($this->langs as $lang) 
        {
            $culture = $lang->getOriginalLanguage(); 
            $objects = ProductPeer::doSelectWithI18n($c, $culture);

            foreach ($objects as $object) 
            {
                $object->setCulture($culture);
                $object->save();
            }
        }

        $this->title = $i18n->__('Aktualizacja produktów', array(), 'stPositioningBackend');

        return $step+count($objects);
    }

    public function categoryUpdate($step)
    {
        if (!$step)
        {
            foreach ($this->langs as $lang)
            {
                if (stLanguage::getOptLanguage() == $lang->getOriginalLanguage())
                {
                    self::setNull(CategoryPeer::TABLE_NAME, CategoryPeer::OPT_URL);
                }

                self::setNull(CategoryI18nPeer::TABLE_NAME, CategoryI18nPeer::URL, CategoryI18nPeer::CULTURE, $lang->getOriginalLanguage());
            }
        }

        $i18n = sfContext::getInstance()->getI18N();
        
        stPropelSeoUrlBehavior::configuration(array('auto_generate_url'=>true));

        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(20);

        foreach ($this->langs as $lang) 
        {
            $culture = $lang->getOriginalLanguage(); 
            $objects = CategoryPeer::doSelectWithI18n($c, $culture);

            foreach ($objects as $object) 
            {
                $object->setCulture($culture);
                $object->save();
            }
        }

        $this->title = $i18n->__('Aktualizacja kategorii', array(), 'stPositioningBackend');
        return $step+count($objects);
    }

    public function productGroupUpdate($step)
    {
        if (!$step)
        {
            foreach ($this->langs as $lang)
            {
                if (stLanguage::getOptLanguage() == $lang->getOriginalLanguage())
                {
                    self::setNull(ProductGroupPeer::TABLE_NAME, ProductGroupPeer::OPT_URL);
                }
                
                self::setNull(ProductGroupI18nPeer::TABLE_NAME, ProductGroupI18nPeer::URL, ProductGroupI18nPeer::CULTURE, $lang->getOriginalLanguage());
            }
        }

        $i18n = sfContext::getInstance()->getI18N();
        
        stPropelSeoUrlBehavior::configuration(array('auto_generate_url'=>true));

        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(20);

        foreach ($this->langs as $lang) 
        {
            $culture = $lang->getOriginalLanguage(); 
            $objects = ProductGroupPeer::doSelectWithI18n($c, $culture);

            foreach ($objects as $object) 
            {
                $object->setCulture($culture);
                $object->save();
            }
        }

        $this->title = $i18n->__('Aktualizacja grup produktów', array(), 'stPositioningBackend');
        return $step+count($objects);
    }

    public function webpageUpdate($step)
    {
        if (!$step)
        {
            foreach ($this->langs as $lang)
            {
                if (stLanguage::getOptLanguage() == $lang->getOriginalLanguage())
                {
                    self::setNull(WebpagePeer::TABLE_NAME, WebpagePeer::OPT_URL);
                }

                self::setNull(WebpageI18nPeer::TABLE_NAME, WebpageI18nPeer::URL, WebpageI18nPeer::CULTURE, $lang->getOriginalLanguage());
            }
        }

        $i18n = sfContext::getInstance()->getI18N();
        
        stPropelSeoUrlBehavior::configuration(array('auto_generate_url'=>true));

        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(20);

        foreach ($this->langs as $lang) 
        {
            $culture = $lang->getOriginalLanguage(); 
            $objects = WebpagePeer::doSelectWithI18n($c, $culture);

            foreach ($objects as $object) 
            {
                $object->setCulture($culture);
                $object->save();
            }
        }

        $this->title = $i18n->__('Aktualizacja stron www', array(), 'stPositioningBackend');
        return $step+count($objects);
    }

    public  function producerUpdate($step)
    {
        if (!$step)
        {
            foreach ($this->langs as $lang)
            {
                if (stLanguage::getOptLanguage() == $lang->getOriginalLanguage())
                {
                    self::setNull(ProducerPeer::TABLE_NAME, ProducerPeer::OPT_URL);
                }
                
                self::setNull(ProducerI18nPeer::TABLE_NAME, ProducerI18nPeer::URL, ProducerI18nPeer::CULTURE, $lang->getOriginalLanguage());
            }
        }

        $i18n = sfContext::getInstance()->getI18N();
        
        stPropelSeoUrlBehavior::configuration(array('auto_generate_url'=>true));

        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(20);

        foreach ($this->langs as $lang) 
        {
            $culture = $lang->getOriginalLanguage(); 
            $objects = ProducerPeer::doSelectWithI18n($c, $culture);

            foreach ($objects as $object) 
            {
                $object->setCulture($culture);
                $object->save();
            }
        }

        $this->title = $i18n->__('Aktualizacja producentów', array(), 'stPositioningBackend');
        return $step+count($objects);
    }

    public function blogUpdate($step)
    {
        if (!$step)
        {
            foreach ($this->langs as $lang)
            {
                if (stLanguage::getOptLanguage() == $lang->getOriginalLanguage())
                {
                    self::setNull(BlogPeer::TABLE_NAME, BlogPeer::OPT_URL);
                }
                
                self::setNull(BlogI18nPeer::TABLE_NAME, BlogI18nPeer::URL, BlogI18nPeer::CULTURE, $lang->getOriginalLanguage());
            }
        }

        $i18n = sfContext::getInstance()->getI18N();
        
        stPropelSeoUrlBehavior::configuration(array('auto_generate_url'=>true));

        $c = new Criteria();
        $c->setOffset($step);
        $c->setLimit(20);

        foreach ($this->langs as $lang) 
        {
            $culture = $lang->getOriginalLanguage(); 
            $objects = BlogPeer::doSelectWithI18n($c, $culture);

            foreach ($objects as $object) 
            {
                $object->setCulture($culture);
                $object->save();
            }
        }

        $this->title = $i18n->__('Aktualizacja bloga', array(), 'stPositioningBackend');
        return $step+count($objects);
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
            case "stPositioning_ProducerUpdate" :
                $this->title = $i18n->__('Aktualizacja producentów', array(), 'stPositioningBackend');
                break;
            case "stPositioning_BlogUpdate" :
                $this->title = $i18n->__('Aktualizacja bloga', array(), 'stPositioningBackend');
                break;
        }
    }

    public function close()
    {
        $user = sfContext::getInstance()->getUser();
        $reference_cnt = $user->getAttribute('reference_cnt', 0, 'soteshop/stPositioningPlugin');
        $reference_cnt--;
        $user->setAttribute('reference_cnt', $reference_cnt, 'soteshop/stPositioningPlugin');

        if ($reference_cnt <= 0)    
        {
            stLock::unlock('frontend');
        }

        $i18n = sfContext::getInstance()->getI18N();
        switch (sfContext::getInstance()->getRequest()->getParameterHolder()->get('name')) {
            case "stPositioning_ProductUpdate" :
                $this->title = $i18n->__('Aktualizacja produktów', array(), 'stPositioningBackend');
                touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_ProductUpdate.log');
                break;
            case "stPositioning_CategoryUpdate" :
                $this->title = $i18n->__('Aktualizacja kategorii', array(), 'stPositioningBackend');
                touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_CategoryUpdate.log');
                ProductHasCategoryPeer::cleanCache();
                break;
            case "stPositioning_ProductGroupUpdate" :
                $this->title = $i18n->__('Aktualizacja grup produktów', array(), 'stPositioningBackend');
                touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_ProductGroupUpdate.log');
                break;
            case "stPositioning_WebpageUpdate" :
                $this->title = $i18n->__('Aktualizacja stron www', array(), 'stPositioningBackend');
                touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_WebpageUpdate.log');
                break;
            case "stPositioning_ProducerUpdate" :
                $this->title = $i18n->__('Aktualizacja producentów', array(), 'stPositioningBackend');
                touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_ProducerUpdate.log');
                break;
            case "stPositioning_BlogUpdate" :
                $this->title = $i18n->__('Aktualizacja bloga', array(), 'stPositioningBackend');
                touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_BlogUpdate.log');
                break;
        }
    }

    public static function setNull($table, $column, $cultureColumn = null, $culture = null)
    {
        if (null !== $culture)
        {
            $ps = Propel::getConnection()->prepareStatement(sprintf('UPDATE %s SET %s = null WHERE %s = ?', $table, $column, $cultureColumn));

            $ps->setString(1, $culture);

            $ps->executeQuery();
        }
        else
        {
            Propel::getConnection()->executeQuery(sprintf('UPDATE %s SET %s = null', $table, $column));
        }
    }

    public static function postInstall(sfEvent $event) {
        sfLoader::loadHelpers('stProgressBar');
        sfLoader::loadHelpers('Partial');
        $event->getSubject()->msg .= progress_bar('stPositioning_ProductUpdate', 'stUpdatePositioningPlugin', 'productUpdate', ProductPeer::doCount(new Criteria()));
        $event->getSubject()->msg .= progress_bar('stPositioning_CategoryUpdate', 'stUpdatePositioningPlugin', 'categoryUpdate', CategoryPeer::doCount(new Criteria()));
        $event->getSubject()->msg .= progress_bar('stPositioning_ProductGroupUpdate', 'stUpdatePositioningPlugin', 'productGroupUpdate', ProductGroupPeer::doCount(new Criteria()));
        $event->getSubject()->msg .= progress_bar('stPositioning_WebpageUpdate', 'stUpdatePositioningPlugin', 'webpageUpdate', WebpagePeer::doCount(new Criteria()));
        $event->getSubject()->msg .= progress_bar('stPositioning_ProducerUpdate', 'stUpdatePositioningPlugin', 'producerUpdate', ProducerPeer::doCount(new Criteria()));
        $event->getSubject()->msg .= progress_bar('stPositioning_BlogUpdate', 'stUpdatePositioningPlugin', 'blogUpdate', BlogPeer::doCount(new Criteria()));
    }
}
