<?php if($confirm == 1): ?>
    <span style="color: green;"><?php echo __("Dane zostały potwierdzone.") ?></span>
    <?php echo input_hidden_tag('partner_data[is_confirm]', 1); ?>
<?php else: ?>
    <span style="color: red;"><?php echo link_to(__("Zatwierdz dane."),"/partner/updateConfirm?id=".$id) ?></span>
    <?php echo input_hidden_tag('partner_data[is_confirm]', 0); ?>
<?php endif; ?>