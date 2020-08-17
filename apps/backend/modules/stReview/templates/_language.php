<?php
$languages = LanguagePeer::doSelect(new Criteria());

$reviewLanguages = array();
foreach ($languages as $language) {

   $c = new Criteria();
   $c->add(LanguageI18nPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());
   $LanguageI18n = $language->getLanguageI18ns($c);
   $reviewLanguages[$language->getOriginalLanguage()] = $LanguageI18n[0]->getName();
}

echo select_tag("review[language]", options_for_select($reviewLanguages, $review->getLanguage()));