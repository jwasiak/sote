<?php
use_helper('stProduct');

?>

<span style="float: left"><?php echo link_to(st_product_get_attachment_icon($product_has_attachment->getAttachment()), 'stProduct/attachmentEdit?product_id='.$product_has_attachment->getProductId().'&id='.$product_has_attachment->getId()) ?></span>
<span style="float: left; padding-left: 5px"><?php echo link_to($product_has_attachment->getFilename(), 'stProduct/attachmentEdit?product_id='.$product_has_attachment->getProductId().'&id='.$product_has_attachment->getId()) ?></span>
<br style="clear: left" />

