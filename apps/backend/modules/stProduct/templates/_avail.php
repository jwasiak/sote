<?php 

if (strlen($product->getFrontendAvailability()) > 10) {

    echo st_truncate_text($product->getFrontendAvailability(), '10', '...');

} else {

    echo $product->getFrontendAvailability();

}

?>