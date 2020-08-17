[?php if ($sf_request->hasErrors()): ?]
<div class="form-errors">
<h2>[?php echo __('Popraw dane w formularzu.', array(), 'stAdminGeneratorPlugin') ?]</h2>
<dl>
[?php foreach ($sf_request->getErrorNames() as $name): if (!isset($labels[$name])) continue ?]
  <dt>[?php echo __($labels[$name]) ?]</dt>
  <dd>[?php echo $sf_request->getError($name) ?]</dd>
[?php endforeach; ?]
</dl>
</div>
[?php elseif ($sf_flash->has('notice')): ?]
<div class="save-ok">
<h2>[?php echo $sf_flash->get('notice') ?]</h2>
</div>
[?php endif; ?]
[?php if ($sf_flash->has('warning')): ?]
<div class="form-errors">
<h2>[?php echo __($sf_flash->get('warning')) ?]</h2>
</div>
[?php endif; ?]

