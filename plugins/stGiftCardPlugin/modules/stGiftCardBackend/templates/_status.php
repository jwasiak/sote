<?php use_helper('stGiftCard') ?>

<?php if ($type == 'list'): ?>
<?php echo st_gift_card_status_name($gift_card->getStatus()) ?>
<?php else: ?>
<?php echo st_gift_card_status_select_tag('gift_card[status]', $gift_card->getStatus()) ?>
<?php endif; ?>