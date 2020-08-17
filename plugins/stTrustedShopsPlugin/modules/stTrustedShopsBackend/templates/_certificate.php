<?php 
if ($trusted_shops->isNew())
{
	echo input_tag('trusted_shops[certificate]', $trusted_shops->getCertificate(), array('size' => 40));
} else {
	echo input_hidden_tag('trusted_shops[certificate]', $trusted_shops->getCertificate());
    echo $trusted_shops->getCertificate();
    if (!$trusted_shops->isRating()) echo ' ('.$trusted_shops->getType().')';
}