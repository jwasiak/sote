<?php
if ($language->getCurrencyId()) {
	echo $language->getCurrency()->getName();
} else {
	echo '-';
}