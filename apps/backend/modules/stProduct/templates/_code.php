<?php 

if (strlen($product->getCode()) > 20) {

    echo st_truncate_text($product->getCode(), '20', '...');

} else {

    echo $product->getCode();

}

?>