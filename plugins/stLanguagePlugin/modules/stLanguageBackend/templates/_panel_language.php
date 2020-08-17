<?php
$language = array();
$c = new Criteria();
$c->add(LanguagePeer::IS_TRANSLATE_PANEL, 1);
foreach (LanguagePeer::doSelectWithI18n($c) as $l)
{
    if ($l->getIsDefaultPanel()) $default = $l->getId();
	$language[$l->getId()] = __($l->getName());
}
echo select_tag('config[language_panel]', options_for_select($language, $default), array());