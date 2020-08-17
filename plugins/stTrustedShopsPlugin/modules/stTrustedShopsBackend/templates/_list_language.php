<?php
switch ($trusted_shops->getLanguage()) {
	case 'de':
		$lang = __('Niemiecki');
		break;
	case 'en':
		$lang = __('Angielski');
		break;
	case 'fr':
		$lang = __('Francuski');
		break;
	case 'pl':
		$lang = __('Polski');
		break;
	default:
		$lang = '-';
		break;
}
echo $lang;