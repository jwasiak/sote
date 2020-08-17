<?php 

use_helper('stText');
  
if (strlen($delivery->getName()) > 20) {

    echo st_truncate_text($delivery->getName(), '20', '...');

} else {

    echo $delivery->getName();

}

?>