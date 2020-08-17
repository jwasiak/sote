<?php

/**
 * Subclass for representing a row from the 'st_search_link' table.
 *
 * 
 *
 * @package plugins.stSearchPlugin.lib.model
 */ 
class SearchLink extends BaseSearchLink
{
    public function getTitle()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }

        $v = parent::getTitle();

        if (null === $v)
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }

        return $v;
    }
 
    public function setTitle($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setTitle($v);
    }

    public function getDescription()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }

        $v = parent::getDescription();

        if (null === $v)
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }

        return $v;
    }
 
    public function setDescription($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setDescription($v);
    }

    public function getUrl()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }

        $v = parent::getUrl();

        if (null === $v)
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }

        return $v;
    }
 
    public function setUrl($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setUrl($v);
    }

    public function getMetaTitle()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }
        else
        {
            $v = parent::getMetaTitle();

            if (null === $v)
            {
                $v = stLanguage::getDefaultValue($this, __METHOD__);
            }
        }

        if (!$v)
        {
            $v = $this->getTitle();
        }

        return $v;
    }
 
    public function setMetaTitle($v)
    {
        $v = $this->filterValue($v);

        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        return parent::setMetaTitle($v);
    }

    public function getMetaKeywords()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }
        else
        {
            $v = parent::getMetaKeywords();

            if (null === $v)
            {
                $v = stLanguage::getDefaultValue($this, __METHOD__);
            }
        }

        if (!$v)
        {
            $keywords = explode(" ", strtr($this->getSearchKeywords(), ',', ''));
            $v = implode(",", $keywords);
        }       

        return $v;
    }
 
    public function setMetaKeywords($v)
    {
        $v = $this->filterValue($v);

        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        return parent::setMetaKeywords($v);
    }

    public function getMetaDescription()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }
        else
        {
            $v = parent::getMetaDescription();

            if (null === $v)
            {
                $v = stLanguage::getDefaultValue($this, __METHOD__);
            }
        }

        if (!$v && $this->getDescription())
        {
            $v = mb_substr(strip_tags($this->getDescription()), 0, 160);
        }

        return $v;
    }
 
    public function setMetaDescription($v)
    {
        $v = $this->filterValue($v);

        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setMetaDescription($v);
    }

    public function urlFilter($friendly_url)
    {
       $c = new Criteria();
 
       $c->add(SearchLinkI18nPeer::ID, $this->getPrimaryKey(), Criteria::NOT_EQUAL);
 
       $c->add(SearchLinkI18nPeer::URL, $friendly_url);
 
       if (SearchLinkI18nPeer::doCount($c) > 0)
       {
          return stPropelSeoUrlBehavior::makeSeoFriendly($friendly_url.'-'.$this->getId());
       }
 
       return false;
    }

    protected function filterValue($value)
    {
        $value = preg_replace('/<script[^>]*>(.*?)<\/script>/is', "", $value);
        $value = strip_tags($value);
        $value = str_replace(array("\n", "\r"), " ", $value);
        $value = str_replace("  ", " ", $value);

        return trim($value);
    }
}

sfPropelBehavior::add('SearchLink', array('stPropelSeoUrlBehavior' => array('source_column' => 'Title', 'target_column' => 'Url', 'target_column_filter' => 'urlFilter')));