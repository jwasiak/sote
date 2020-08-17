[?php echo form_tag('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'Save', 'save') ?><?php $class_name = $this->getClassName(); if (method_exists(new $class_name(), 'setCulture')): ?>?culture=' . $<?php echo $this->getSingularName() ?>->getCulture().'<?php echo $this->getForwardParametersForUrl('$', '&') ?><?php else: ?><?php echo $this->getForwardParametersForUrl('$', '?') ?><?php endif; ?>, array(
  'id'        => 'admin_edit_form',
  'name'      => 'admin_edit_form',
  'class'     => 'admin_form',
  'multipart' => true,
<?php foreach ($this->getColumnCategories('edit.display') as $category):  ?>
<?php foreach ($this->getColumns('edit.display', $category) as $name => $column): ?>
<?php if (false !== strpos($this->getParameterValue('edit.fields.'.$column->getName().'.type'), 'admin_double_list')): ?>
  'onsubmit'  => 'double_list_submit(); return true;'
<?php break 2; ?>
<?php endif; ?>
<?php endforeach; ?>
<?php endforeach; ?>
)) ?]

<?php foreach ($this->getPrimaryKey() as $pk): ?>
[?php echo object_input_hidden_tag($<?php echo $this->getSingularName() ?>, 'get<?php echo $pk->getPhpName() ?>') ?]
<?php endforeach; ?>

<?php $first = true ?>
<?php foreach ($this->getColumnCategories('edit.display') as $category): 
$category_install_version = $this->getParameterValue("edit.hide_install_version.".$category);
$category_old_config = $this->getParameterValue("edit.old_config.".$category); ?>
<?php if ($category_install_version): ?>
  [?php if (!stSoteshop::checkInstallVersion('<?php echo $category_install_version ?>')): ?]
<?php endif ?>
<?php if ($category_old_config): ?>
  [?php if (!stTheme::hideOldConfiguration()): ?]
<?php endif ?>
<?php if (!$this->getColumns('edit.display', $category)) continue ?>
<?php
  if ($category[0] == '-')
  {
    $category_name = substr($category, 1);
    $collapse = true;

    if ($first)
    {
      $first = false;
      echo "[?php use_javascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype') ?]\n";
      echo "[?php use_javascript(sfConfig::get('sf_admin_web_dir').'/js/collapse') ?]\n";
    }
  }
  else
  {
    $category_name = $category;
    $collapse = false;
  }

  $fieldset_id = strtr(stPropelSeoUrlBehavior::makeSeoFriendly($category_name), '-', '_');
?>
<?php
$effect_id="sf_fieldset_".preg_replace('/[^a-z0-9_]/', '_', strtolower($category_name))."_slide";
$visual_content="array('afterShow'=>__('pokaż'),'afterHide'=>__('ukryj'))";
?>

<fieldset id="sf_fieldset_<?php echo $fieldset_id ?>" [?php if ($sf_user->getParameter('<?php echo $fieldset_id ?>', false, 'soteshop/stAdminGenerator/hidden')): ?] style="display: none"[?php endif ?]>
<?php if ($category != 'NONE'): ?>
<h2>[?php echo __('<?php echo $category_name ?>', null, '<?php echo $this->getParameterValue("edit.i18n.".$category_name, $this->getModuleName()) ?>') ?]</h2>
<?php endif; ?>
<div class="content" id="<?php echo $effect_id ?>">
<?php $hides = $this->getParameterValue('edit.hide', array()) ?>
<?php foreach ($this->getColumns('edit.display', $category) as $name => $column): ?>
<?php if (in_array($column->getName(), $hides)) continue ?>
<?php if ($column->isPrimaryKey() && !$column->isForeignKey()) continue ?>
<?php $credentials = $this->getParameterValue('edit.fields.'.$column->getName().'.credentials') ?>
<?php $i18n_catalogue = $this->getParameterValue("edit.fields.".$column->getName().".i18n", $this->getModuleName()); ?>
<?php $only_for = $this->getParameterValue('edit.fields.'.$column->getName().'.only_for'); ?>
<?php $hide_on_create = $this->getParameterValue('edit.fields.'.$column->getName().'.hide_on_create'); ?>
<?php $hide_on_edit = $this->getParameterValue('edit.fields.'.$column->getName().'.hide_on_edit'); ?>
<?php $old_config = $this->getParameterValue('edit.fields.'.$column->getName().'.old_config') ?>
<?php $install_version = $this->getParameterValue('edit.fields.'.$column->getName().'.hide_install_version'); ?>
<?php if ($install_version): ?>
  [?php if (!stSoteshop::checkInstallVersion('<?php echo $install_version ?>')): ?]
<?php endif ?>
<?php if ($old_config): ?>
[?php if (!stTheme::hideOldConfiguration()): ?]
<?php endif ?>
<?php if ($hide_on_create || $only_for == 'edit'): ?>
[?php if ($<?php echo $this->getSingularName() ?>->getPrimaryKey()): ?]
<?php elseif ($hide_on_edit || $only_for == 'create'): ?>
[?php if ($<?php echo $this->getSingularName() ?>->isNew()): ?]
<?php endif; ?>
[?php if (!$sf_user->getParameter('hide', false,'<?php echo $this->getModuleName() ?>/edit/fields/<?php echo $column->getName() ?>')): ?]
<?php if ($credentials): $credentials = str_replace("\n", ' ', var_export($credentials, true)) ?>
[?php if ($sf_user->hasCredential(<?php echo $credentials ?>)): ?]
<?php endif; ?>
<?php if ($this->getParameterValue("edit.fields.".$column->getName().".hide_row") == true):  ?>
<?php else: ?>
  <div class="row row_<?php echo $column->getName() ?>">
  <?php if ($this->getParameterValue("edit.fields.".$column->getName().".hide_label") == true):  ?>
  <?php else: ?>

    <label for="<?php echo $this->getSingularName() ?>_<?php echo $column->getName() ?>"<?php if ($this->getParameterValue("edit.fields.".$column->getName().".required", $column->isNotNull())): ?> class="required" <?php endif; ?>>
      [?php echo __($labels['<?php echo $this->getSingularName() ?>{<?php echo $column->getName() ?>}'], array(), '<?php echo $i18n_catalogue ?>'); ?]<?php if ($help = $this->getParameterValue("edit.fields.".$column->getName().".help", '')): ?> <a href="#" class="help" title="[?php echo htmlspecialchars(__('<?php echo $help ?>', null, '<?php echo $i18n_catalogue ?>')) ?]"></a><?php endif; ?>
    </label>
    <div class="field[?php if ($sf_request->hasError('<?php echo $this->getSingularName() ?>{<?php echo $column->getName() ?>}')): ?] form-error[?php endif; ?]">
  <?php endif; ?>

  [?php if ($sf_request->hasError('<?php echo $this->getSingularName() ?>{<?php echo $column->getName() ?>}')): ?]
      [?php echo form_error('<?php echo $this->getSingularName() ?>{<?php echo $column->getName() ?>}', array('class' => 'form-error-msg')) ?]
  [?php endif; ?]
<?php endif; ?>

<?php if ($related_class = $this->getParameterValue("edit.fields." . $column->getName() . ".related_class")): ?>
<?php $this->changeModelClass($related_class) ?>
[?php $<?php echo $this->getSingularName() ?> = new <?php echo $related_class ?>() ?]
<table cellspacing="0" class="st_record_list">
    <thead>
        <tr>
<?php $related_fields = $this->getColumns("edit.fields." . $column->getName() . ".related_fields.display") ?>
<?php foreach ($related_fields as $related_column): ?>
            <th>[?php echo __('<?php echo $this->getParameterValue('edit.fields.' . $column->getName() . '.related_fields.' . $related_column->getName() . '.name', $related_column->getName()) ?>') ?]</th>
<?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
<?php foreach ($related_fields as $related_column): ?>
            <td>[?php $value = <?php echo $this->getRelatedColumnEditTag($column, $related_column); ?>; echo $value ? $value : '&nbsp;' ?]</td>
<?php endforeach; ?>
<?php $this->restoreModelClass() ?>
        <tr>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="<?php echo count($related_fields); ?>">
                [?php echo st_get_admin_actions_head('style="margin: 0px; float: right"') ?]
                    [?php echo st_get_admin_action('add', __('Dodaj'), null, array("onclick" => "window.alert('test'); return false;")) ?]
                [?php echo st_get_admin_actions_foot() ?]
            </th>
        </tr>
    </tfoot>
</table>

<?php else: ?>
 [?php echo <?php echo $this->getColumnEditTag($column); ?>; ?] 
<?php endif; ?>

<?php if ($this->getParameterValue("edit.fields.".$column->getName().".hide_row") == true):  ?>
<?php else: ?>
  <?php if ($this->getParameterValue("edit.fields.".$column->getName().".hide_label") == true):  ?>
  <?php else: ?>
    <div class="clr"></div>
    </div>
  <?php endif ?>
  </div>
<?php endif ?>
<?php if ($credentials): ?>
[?php endif; ?]
<?php endif; ?>
[?php endif; ?]
<?php if ($hide_on_edit || $hide_on_create || $only_for): ?>
[?php endif; ?]
<?php endif; ?>
<?php if ($old_config): ?>
[?php endif; ?]
<?php endif ?>
<?php if ($install_version): ?>
[?php endif; ?]
<?php endif ?>

<?php endforeach; ?>
</div>
</fieldset>
<?php if ($category_old_config): ?>
  [?php endif; ?]
<?php endif ?>
<?php if ($category_install_version): ?>
[?php endif; ?]
<?php endif ?>
<?php endforeach; ?>

<div id="edit_actions">[?php st_include_partial('<?php echo $this->getCustomActionName('','_') ?>edit_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'forward_parameters' => $forward_parameters)) ?]</div>

</form>

<script type="text/javascript">
jQuery(function($) {
    $(document).ready(function() {
        $('#edit_actions').stickyBox();
    });

});
</script>
