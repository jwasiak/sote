<?php if ($type == 'list'): ?>
<?php use_helper('stCurrency') ?>
<?php echo st_format_price($gift_card->getAmount()) ?>
<?php else: ?>
<?php use_javascript('stPrice.js') ?>
<?php echo input_tag('gift_card[amount]', stPrice::round($gift_card->getAmount()), array('size' => 6, 'onchange' => 'this.value=stPrice.fixNumberFormat(this.value)')) ?> 
<?php endif; ?>
