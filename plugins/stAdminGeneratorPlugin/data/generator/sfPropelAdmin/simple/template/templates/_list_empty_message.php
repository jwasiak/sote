<div style="width: 98.2%; min-height: 50px; border: 1px solid #ccc; padding: 10px;">
<?php if (is_array($message = $this->getParameterValue('list.empty_message', 'Brak rekordów'))):  ?>
<p id="st_record_list-empty">[?php echo __('<?php echo $message['message'] ?>', array(), '<?php echo $message['i18n'] ? $message['i18n'] : 'stAdminGeneratorPlugin' ?>') ?]</p>
<?php else: ?>
<p id="st_record_list-empty">[?php echo __('<?php echo $message ?>', array(), 'stAdminGeneratorPlugin') ?]</p>
<?php endif; ?>
</div>