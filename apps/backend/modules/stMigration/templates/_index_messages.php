<?php if ($sf_request->hasErrors()): ?>
<div class="form-errors" style="margin: 10px;">
<h2><?php echo __('Popraw dane w formularzu.', null, 'stAdminGeneratorPlugin') ?></h2>
<dl>
<?php foreach ($sf_request->getErrorNames() as $name): ?>
  <dt><?php echo __($labels[$name]) ?></dt>
  <dd><?php echo $sf_request->getError($name) ?></dd>
<?php endforeach; ?>
</dl>
</div>
<?php elseif ($sf_flash->has('notice')): ?>
<div class="save-ok" style="margin: 10px;">
<h2><?php echo __($sf_flash->get('notice')) ?></h2>
</div>
<?php endif; ?>
<?php if ($sf_flash->has('warning')): ?>
<div class="form-errors" style="margin: 10px;">
<h2><?php echo __($sf_flash->get('warning')) ?></h2>
</div>
<?php endif; ?>