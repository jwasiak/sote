<?php echo select_tag('newsletter_user[language]', options_for_select($languages, $newsletter_user->getLanguage()!="" ? $newsletter_user->getLanguage() : $defaultLanguages)); ?>           

