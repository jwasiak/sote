<?php if ($type == 'list'): ?>
<?php use_helper('stCurrency') ?>
<?php echo st_format_price($gift_card->getMinOrderAmount(), 0) ?>
<?php else: ?>
<?php use_javascript('stPrice.js') ?>
<?php echo input_tag('gift_card[min_order_amount]', $gift_card->getMinOrderAmount(), array('size' => 6, 'onchange' => 'this.value=stPrice.fixNumberFormat(this.value, 0)')) ?> 
<?php endif; ?>
