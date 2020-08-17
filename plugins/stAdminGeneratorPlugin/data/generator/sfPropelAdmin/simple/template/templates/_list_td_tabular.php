[?php $list_mode = $sf_user->getAttribute('<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?>.mode', null, 'soteshop/stAdminGenerator/<?php echo $this->getModuleName() ?>/config'); ?]
<?php $hs = $this->getParameterValue('list.hide', array()) ?>                  
<?php foreach ($this->getColumns('list.display') as $column): ?>
<?php if (in_array($column->getName(), $hs) || $this->getParameterValue('list.fields.'.$column->getName().'.filter_only')) continue ?>
<?php $credentials = $this->getParameterValue('list.fields.'.$column->getName().'.credentials') ?>
<?php $old_config = $this->getParameterValue('list.fields.'.$column->getName().'.old_config') ?>
<?php $install_version = $this->getParameterValue('list.fields.'.$column->getName().'.hide_install_version') ?>
<?php if ($install_version): ?>
  [?php if (!stSoteshop::checkInstallVersion('<?php echo $install_version ?>')): ?]
<?php endif ?>
<?php if ($old_config): ?>
[?php if (!stTheme::hideOldConfiguration()): ?]
<?php endif ?>
<?php if ($credentials): $credentials = str_replace("\n", ' ', var_export($credentials, true)) ?>
    [?php if ($sf_user->hasCredential(<?php echo $credentials ?>)): ?]
<?php endif; ?>
<?php
   $type = $column->getCreoleType();
   $align = $this->getParameterValue('list.fields.'.$column->getName().'.align');
   $params = $this->getParameterValue('list.fields.'.$column->getName());
   $params = (isset($params['params']) ? sfToolkit::stringToArray($params['params']) : array());

   if ($column->isLink())
   {
      if (isset($params['link_to']))
      {
         $link = "'".$this->replaceConstantsForTemplate($params['link_to']).$this->getForwardParametersForUrl('$', '&');
      }
      else
      {
         $link = "'".$this->getModuleName().'/'.$this->getCustomActionNameCamelized('', 'Edit', 'edit').'?'.$this->getPrimaryKeyUrlParams().".'".$this->getForwardParametersForUrl('$', '&');
      }      
   }

   $column_value = $this->getColumnListTag($column);

   if (isset($params['truncate_text']))
   {
      $column_value = 'truncate_text('.$column_value.', '.$params['truncate_text'].')';
   }
?>
[?php if ($list_mode != 'edit'): ?]
<td class="column_<?php echo $column->getName() ?><?php if ($type == CreoleTypes::BOOLEAN): ?> column_boolean<?php endif; ?>" style="<?php if ($align): ?>text-align: <?php echo $align ?>;<?php endif; ?>">
<?php if ($column->isLink()): ?>
   <a href="[?php echo st_url_for(<?php echo $link ?>) ?]">
      [?php echo <?php echo $column_value ?> ?]
   </a>   
<?php else: ?>   
   [?php echo <?php echo $column_value ?> ?]
<?php endif; ?>
</td>
[?php else: ?]
<td class="column_<?php echo $column->getName() ?>" style="<?php if ($align): ?>text-align: <?php echo $align ?>;<?php endif; ?>">
   [?php echo <?php echo $this->getEditColumnListTag($column) ?> ?]
</td>   
[?php endif; ?]


<?php if ($credentials): ?>
[?php endif; ?]
<?php endif; ?>
<?php if ($old_config): ?>
[?php endif; ?]
<?php endif ?>
<?php if ($install_version): ?>
[?php endif ?]
<?php endif ?>
<?php endforeach; ?>