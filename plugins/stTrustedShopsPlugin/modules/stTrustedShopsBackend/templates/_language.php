<?php echo select_tag('trusted_shops[language]', objects_for_select(LanguagePeer::doSelectLanguages(), 'getLanguage', 'getOptName', $trusted_shops->getLanguage()));
