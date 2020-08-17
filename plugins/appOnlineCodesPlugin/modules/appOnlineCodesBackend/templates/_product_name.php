<?php
if (isset($online_codes) && is_object($online_codes)) $object = $online_codes;
elseif (isset($online_files) && is_object($online_files)) $object = $online_files; 

if (is_object($object->getProduct())) {
    echo st_external_link_to($object->getProduct(),'stProduct/edit?id='.$object->getProductId());
} else {
    echo '-';
}