<?php $catalogue = isset($i18n_catalogue) ? $i18n_catalogue : 'stAdminGeneratorPlugin'; ?>
<?php if ($sf_request->hasErrors()): ?>
<div class="form-errors">
  <h2><?php echo __('Correct the data in the form.', null, 'stAdminGeneratorPlugin') ?></h2>
<?php if (isset($labels) && $labels): ?>  
  <dl>
<?php foreach ($sf_request->getErrorNames() as $name): if (!isset($labels[$name])) continue ?>
    <dt><?php echo __($labels[$name], null, $catalogue) ?></dt>
    <dd><?php echo __($sf_request->getError($name), null, $catalogue) ?></dd>
<?php endforeach; ?>
  </dl>
<?php endif; ?>
</div>
<?php elseif ($sf_flash->has('notice')): ?>
<div class="save-ok">
  <h2><?php echo __($sf_flash->get('notice'), null, $catalogue) ?></h2>
</div>
<?php elseif ($sf_flash->has('warning')): ?>
<div class="form-errors">
  <h2><?php echo __($sf_flash->get('warning'), null, $catalogue) ?></h2>
</div>
<?php endif; ?>