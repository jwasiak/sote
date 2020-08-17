<?php

stPluginHelper::addRouting('stTinyMCE', '/wysiwyg/:action/*', 'stTinyMCE', 'config', 'backend');
stConfiguration::addModule(array('label' => 'Edytor WYSIWYG', 'route' => '@stTinyMCE', 'icon' => 'stTinyMCEPlugin'), 'Konfiguracja modułów');