<?php $hides = $this->getParameterValue('list.hide', array()) ?>
<?php foreach ($this->getColumns('list.display') as $column): if (in_array($column->getName(), $hides) || $this->getParameterValue('list.fields.'.$column->getName().'.filter_only')) continue ?>
<?php
$credentials = $this->getParameterValue('list.fields.'.$column->getName().'.credentials');

if ($credentials) 
{
   $credentials = str_replace("\n", ' ', var_export($credentials, true));
}

$i18n_catalogue = $this->getParameterValue('list.fields.'.$column->getName().'.i18n', $this->getModuleName());

$width = $this->getParameterValue('list.fields.'.$column->getName().'.width');

$min_width = $this->getParameterValue('list.fields.'.$column->getName().'.min_width');
?>
<?php $install_version = $this->getParameterValue('list.fields.'.$column->getName().'.hide_install_version') ?>
<?php if ($install_version): ?>
  [?php if (!stSoteshop::checkInstallVersion('<?php echo $install_version ?>')): ?]
<?php endif ?>
<?php $old_config = $this->getParameterValue('list.fields.'.$column->getName().'.old_config') ?>
<?php if ($old_config): ?>
[?php if (!stTheme::hideOldConfiguration()): ?]
<?php endif ?>
<?php if ($credentials): $credentials = str_replace("\n", ' ', var_export($credentials, true)) ?>
[?php if ($sf_user->hasCredential(<?php echo $credentials ?>)): ?]
<?php endif; ?>
<th id="sf_admin_list_th_<?php echo $column->getName() ?>" style="<?php if ($width): ?>width: <?php echo $width ?>;<?php endif; ?><?php if ($min_width): ?>min-width: <?php echo $min_width ?>;<?php endif; ?>">
<?php 
if ($this->getParameterValue('list.fields.'.$column->getName().'.display'))
{
   $columns = $this->getColumns('list.fields.'.$column->getName().'.display');
}
else
{
   $columns = array($column);
}
?>

<?php foreach ($columns as $index => $column): ?>
<?php 
$name = str_replace("'", "\\'", $this->getParameterValue('list.fields.'.$column->getName().'.name'));
$i18n_catalogue = $this->getParameterValue('list.fields.'.$column->getName().'.i18n', $i18n_catalogue);
$callback = $this->getParameterValue('list.fields.'.$column->getName().'.label_callback');
$sortable = $this->getParameterValue('list.fields.'.$column->getName().'.sortable', true);
$url = sprintf('%s/%s?sort=%s', 
   $this->getModuleName(), 
   $this->getCustomActionNameCamelized('', 'List', 'list'),
   $column->getName());
?>
<?php if ($sortable && ($column->isReal() || $this->getParameterValue('list.fields.'.$column->getName().'.sort_field'))): ?>
[?php if (isset($for_filters)): ?]
[?php echo __('<?php echo $name ?>', array(), '<?php echo $i18n_catalogue ?>') ?]
[?php else: ?]
[?php if ($sf_user->getAttribute('type', null, 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort') == 'asc'): ?]
<a href="[?php echo st_url_for('<?php echo $url ?><?php echo $this->getForwardParametersForUrl('$', '&', 'list') ?>.'&type=desc') ?]?page=[?php echo $pager->getPage() ?]">
<?php if ($callback): ?>
[?php echo <?php echo $callback ?>('<?php echo $name ?>'); ?]
<?php else: ?>
[?php echo __('<?php echo $name ?>', array(), '<?php echo $i18n_catalogue ?>') ?]
<?php endif; ?>
</a>
[?php if ($sf_user->getAttribute('sort', null, 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort') == '<?php echo $column->getName() ?>'): ?]
<img src="/images/backend/icons/desc.png" style="vertical-align: middle; width: 13px" />
[?php endif; ?]
[?php else: ?]
<a href="[?php echo st_url_for('<?php echo $url ?><?php echo $this->getForwardParametersForUrl('$', '&', 'list') ?>.'&type=asc') ?]?page=[?php echo $pager->getPage() ?]">
<?php if ($callback): ?>
[?php echo <?php echo $callback ?>('<?php echo $name ?>'); ?]
<?php else: ?>
[?php echo __('<?php echo $name ?>', array(), '<?php echo $i18n_catalogue ?>') ?]
<?php endif; ?>
</a>
[?php if ($sf_user->getAttribute('sort', null, 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort') == '<?php echo $column->getName() ?>'): ?]
<img src="/images/backend/icons/asc.png" style="vertical-align: middle; width: 13px" />
[?php endif; ?]
[?php endif; ?]
[?php endif; ?]
<?php else: ?>
[?php echo __('<?php echo $name ?>', array(), '<?php echo $i18n_catalogue ?>') ?]
<?php endif; ?>
<?php echo $this->getHelpAsIcon($column, 'list') ?>
<?php endforeach; ?>
</th>
<?php if ($credentials): ?>
[?php endif; ?]
<?php endif; ?>
<?php if ($old_config): ?>
[?php endif; ?]
<?php endif ?>
<?php if ($install_version): ?>
[?php endif; ?]
<?php endif ?>
<?php endforeach; ?>
