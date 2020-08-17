<?php

/**
 * Subclass for representing a row from the 'st_language_has_domain' table.
 *
 *
 *
 * @package plugins.stLanguagePlugin.lib.model
 */
class LanguageHasDomain extends BaseLanguageHasDomain
{
    /**
     * Przeciążenie zapisu
     */
    public function save($con = null)
    {
        if ($this->isColumnModified(LanguageHasDomainPeer::IS_DEFAULT)) {
            if ($this->is_default == 1) {
                $c1 = new Criteria();
                $c1->add(LanguageHasDomainPeer::LANGUAGE_ID, $this->getLanguageId());
                $c2 = new Criteria();
                $c2->add(LanguageHasDomainPeer::IS_DEFAULT, 0);
                BasePeer::doUpdate($c1, $c2, Propel::getConnection());
            }
        }

        stFastCacheManager::clearCache();
        stLanguageFastCache::create();
        
        $stCache = new stFunctionCache('stLanguagePlugin');
        $stCache->clearFunction('allLanguageHasDomain');
        $stCache->clearFunction('languageByDomain*');
        
        return parent::save($con);
    }

    /**
     * Przeciążenie zapisu
     */
    public function delete($con = null)
    {
        stFastCacheManager::clearCache();
        stLanguageFastCache::create();
        
        $stCache = new stFunctionCache('stLanguagePlugin');
        $stCache->clearFunction('allLanguageHasDomain');
        $stCache->clearFunction('languageByDomain*');

        return parent::delete($con);
    }
}
