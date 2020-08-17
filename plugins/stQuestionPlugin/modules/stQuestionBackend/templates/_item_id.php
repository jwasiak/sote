<?php use_helper('stText'); ?>
<?php if ($questions->getItemId()): ?>
    <?php echo st_external_link_to(st_truncate_text($questions->getProduct()->getName(),40), 'product/edit?id='.$questions->getItemId())?>
<?php else: ?>
    <span style="color: #4B7195; font-size:12px;">
        <?php echo st_truncate_text($questions->getItemName(),45) ?>
    </span>
<?php endif; ?>