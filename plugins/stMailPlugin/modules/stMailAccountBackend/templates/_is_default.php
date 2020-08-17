<?php echo object_checkbox_tag($mail_account, 'getIsDefault', array (
  'control_name' => 'mail_account[is_default]',
  'disabled' => $mail_account->getIsDefault(),
)); ?> 

<?php if ($mail_account->getIsDefault()): ?>
    <?php echo input_hidden_tag('mail_account[is_default]', 1) ?>
<?php endif ?>