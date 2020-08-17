<?php
if ($trusted_shops->getRatingStatus()) {
	echo __('Aktywny');
} else {
	echo __('Nieaktywny');
	echo ' - '.st_link_to(__('Aktywuj'), 'stTrustedShopsBackend/ratingActive?id='.$trusted_shops->getId());
}