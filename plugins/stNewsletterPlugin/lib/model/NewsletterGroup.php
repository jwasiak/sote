<?php

/**
 * Subclass for representing a row from the 'st_newsletter_group' table.
 *
 * @package     stNewsletterPlugin
 * @subpackage  libs
 */
class NewsletterGroup extends BaseNewsletterGroup
{
    public function getCountUsers()
    {
        $c = new Criteria();

        $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, $this->getId());
        $c->add(NewsletterUserPeer::ACTIVE, 1);
        $c->add(NewsletterUserPeer::CONFIRM, 1);

        return NewsletterUserHasNewsletterGroupPeer::doCountJoinAll($c);
    }

    /**
     * Przeciążenie hydrate
     *
     * @param ResultSet $rs
     * @param int $startcol
     * @return object
     */
    public function hydrate(ResultSet $rs, $startcol = 1)
    {
        $this->setCulture(stLanguage::getHydrateCulture());
        return parent::hydrate($rs, $startcol);
    }

    /**
     * Przeciążenie getName
     *
     * @return string
     */
    public function getName()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }

        $v = parent::getName();

        if (is_null($v))
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }

        return $v;
    }

    /**
     * Przeciążenie setName
     *
     * @param string $v Nazwa producenta
     */
    public function setName($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setName($v);
    }

    /**
     * Przeciążenie getDescription
     *
     * @return string
     */
    public function getDescription()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }

        $v = parent::getDescription();

        if (is_null($v))
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }

        return $v;
    }

    /**
     * Przeciążenie setDescription
     *
     * @param string $v Nazwa producenta
     */
    public function setDescription($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setDescription($v);
    }
}