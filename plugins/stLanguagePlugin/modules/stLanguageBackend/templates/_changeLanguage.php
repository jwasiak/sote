<?php

if (stSoteshopVersion::getVersion() != stSoteshopVersion::ST_SOTESHOP_VERSION_INTERNATIONAL) {
	if($sf_context->getUser()->getCulture() == 'pl_PL')
	{
		echo image_tag('backend/stLanguagePlugin/polish_active.png').' ';
		echo link_to(image_tag('backend/stLanguagePlugin/english_inactive.png'), 'language/changeLanguage?name=en');
	}elseif ($sf_context->getUser()->getCulture() == 'en_US'){
		echo link_to(image_tag('backend/stLanguagePlugin/polish_inactive.png'), 'language/changeLanguage?name=pl').' ';
		echo image_tag('backend/stLanguagePlugin/english_active.png');
	}
}