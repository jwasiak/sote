<?php
use_helper('stImageSize');
$fileName = "http://".$sf_request->getHost().$image;
echo st_photo_link_onclick($image,450,300, "javascript:window.open('".$fileName."','', 'width=".($dimensions[0] + 20).",height=".($dimensions[1] + 30).",scrollbars=yes');");
?>