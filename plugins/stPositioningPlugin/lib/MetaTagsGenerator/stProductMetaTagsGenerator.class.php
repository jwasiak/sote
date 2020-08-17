<?php
/**
 * SOTESHOP/stPositioningPlugin
 *
 * Ten plik należy do aplikacji stPositioningPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProductMetaTagsGenerator.class.php 3628 2010-02-22 09:24:13Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stProductMetaTagsGenerator
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
class stProductMetaTagsGenerator extends stMetaTagsGenerator
{
    /**
     * Generowanie meta tagów
     *
     * @param Product $product
     */
    public function generate($product)
    {
        if (is_object($product))
        {
            $keywords = array($product->getName());
            $newKeywords = array();

            $product->setCulture($this->culture);

            $c = new Criteria();
            $c->addSelectColumn(CategoryI18nPeer::NAME);
            $c->addSelectColumn(CategoryPeer::OPT_NAME);
            $c->add(ProductHasCategoryPeer::PRODUCT_ID, $product->getId());
            $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);
            CategoryPeer::setHydrateMethod(array($this, 'hydrateCategoryKeywords'));
            $keywords = array_merge($keywords, CategoryPeer::doSelectWithI18n($c, $this->culture));
            CategoryPeer::setHydrateMethod(null);

            if (is_object($product->getProducer())) $keywords[] = $product->getProducer()->getName();

            foreach ($keywords as $keyword)
            {
                if ($keyword != stLocale::removeLocalSymbols($keyword, sfContext::getInstance()->getUser()->getCulture()))
                {
                    $newKeywords[] = stLocale::removeLocalSymbols($keyword, sfContext::getInstance()->getUser()->getCulture());
                }
            }
            $keywords = array_merge($keywords, $newKeywords);
            $keywords = array_unique($keywords);
            

            if ($this->positioning->getTitleProduct())
            {
                $this->title = str_replace("{NAME}", $product->getName(), $this->positioning->getTitleProduct()); 
            }else{
                $this->title = $product->getName();
            }

            $this->keywords = implode(', ',$keywords);

            if ($product->getShortDescription())
            {
                $this->description = mb_substr(strip_tags($product->getShortDescription()),0,170,'UTF-8');
            }
            elseif ($product->getDescription())
            {
                $this->description = mb_substr(strip_tags($product->getDescription()),0,170,'UTF-8');
            }
            else
            {
                $this->description = "";
            }
        }
    }

    public function hydrateCategoryKeywords(ResultSet $rs)
    {
        $keywords = array();

        while($rs->next())
        {
            $row = $rs->getRow();

            $keywords[] = $row[0] ? $row[0] : $row[1]; 
        }

        return $keywords;
    }
}