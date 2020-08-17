<?php
$sfCultureInfoPl = new sfCultureInfo('pl');
$languages = $sfCultureInfoPl->getLanguages();
$languages = array_merge($languages, array('uk' => 'ukraiński'));

if ($sf_user->getCulture() == 'en_US'){
    $sfCultureInfoEn = new sfCultureInfo('en');
    $languagesEn = $sfCultureInfoEn->getLanguages();

    foreach($languages as $key => $value){
        $tmp[$key] = $languagesEn[$key];
    }
    $languages = $tmp;
    unset($tmp,$languagesEn);
}

uasort($languages, function($a, $b) {
    $a = stTextAnalyzer::unaccent($a);
    $b = stTextAnalyzer::unaccent($b);
    return strnatcmp($a, $b);
});

echo select_tag('language[language]', options_for_select($languages, $language->getLanguage()), array('disabled' => !$language->isNew()));