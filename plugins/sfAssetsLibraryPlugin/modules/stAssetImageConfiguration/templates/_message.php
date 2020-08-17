<?php if ($sf_request->hasErrors()): ?>
<div class="form-errors">
   <h2><?php echo __('Popraw dane w formularzu.', null, 'stAdminGeneratorPlugin') ?></h2>
</div>
<?php elseif ($sf_flash->has('notice')): ?>
<div class="save-ok">
   <h2><?php echo $sf_flash->get('notice') ?></h2>
</div>
<?php elseif ($sf_flash->has('warning')): ?>
<div class="form-errors">
   <h2><?php echo $sf_flash->get('warning') ?></h2>
</div>
<?php endif; ?>