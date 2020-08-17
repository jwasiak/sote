[?php init_tooltip('#admin_config_form .help') ?]
[?php echo form_tag('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'Config', 'config') ?>?culture='.$config->getCulture(), array(
  'id'        => 'admin_config_form',
  'name'      => 'admin_config_form',
  'class'     => 'admin_form',
  'multipart' => true,
)) ?]
<?php $first = true ?>

<?php foreach ($this->getColumnCategories('config.display') as $category): 
$category_old_config = $this->getParameterValue("config.old_config.".$category); 
$category_install_version = $this->getParameterValue("config.hide_install_version.".$category);
?>
<?php if ($category_install_version): ?>
  [?php if (!stSoteshop::checkInstallVersion('<?php echo $category_install_version ?>')): ?]
<?php endif ?>
<?php if ($category_old_config): ?>
  [?php if (!stTheme::hideOldConfiguration()): ?]
<?php endif ?>
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
?>
<?php 
$effect_id="sf_fieldset_".preg_replace('/[^a-z0-9_]/', '_', strtolower($category_name))."_slide"; 
$visual_content="array('afterShow'=>__('pokaż'),'afterHide'=>__('ukryj'))";
?>
<fieldset id="sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($category_name)) ?>" class="<?php if ($collapse): ?> collapse<?php endif; ?>">
<?php if ($category != 'NONE'): ?>
<h2>[?php echo __('<?php echo $category_name ?>', null, "<?php echo $this->getParameterValue("config.i18n.".$category_name, $this->getModuleName()) ?>") ?]</h2>
<?php endif; ?>
<div class="content" id="<?php echo $effect_id ?>">
<?php $hides = $this->getParameterValue('config.hide', array()) ?>
<?php foreach ($this->getColumns('config.display', $category) as $name => $column): ?>
<?php if (in_array($column->getName(), $hides)) continue ?>
<?php if ($column->isPrimaryKey()) continue ?>
<?php $credentials = $this->getParameterValue('config.fields.'.$column->getName().'.credentials') ?>
<?php $i18n_catalogue = $this->getParameterValue("config.fields.".$column->getName().".i18n", $this->getModuleName()); ?>
<?php $params = $this->getParameterValue('config.fields.'.$column->getName().'.params') ?>
<?php $required = $this->getParameterValue('config.fields.'.$column->getName().'.required', $column->isNotNull()) ?>
<?php $old_config = $this->getParameterValue('config.fields.'.$column->getName().'.old_config') ?>
<?php $install_version = $this->getParameterValue('config.fields.'.$column->getName().'.hide_install_version') ?>
<?php if ($install_version): ?>
  [?php if (!stSoteshop::checkInstallVersion('<?php echo $install_version ?>')): ?]
<?php endif ?>
<?php if ($old_config): ?>
  [?php if (!stTheme::hideOldConfiguration()): ?]
<?php endif ?>
<?php if ($credentials): $credentials = str_replace("\n", ' ', var_export($credentials, true)) ?>
[?php if ($sf_user->hasCredential(<?php echo $credentials ?>)): ?]
<?php endif; ?>
<?php if ($this->getParameterValue("config.fields.".$column->getName().".hide_row") == true):  ?>
<?php else: ?>
    <div class="row row_<?php echo $column->getName() ?>">
    <?php if ($this->getParameterValue("config.fields.".$column->getName().".hide_label") == true):  ?>

    <?php else: ?>
            <label for="config_<?php echo $column->getName() ?>"<?php if ($column->isNotNull() || $this->getParameterValue("config.fields.".$column->getName().".required")): ?> class="required" <?php endif; ?>>
              [?php echo rtrim(__($labels['config{<?php echo $column->getName() ?>}'], array(), '<?php echo $i18n_catalogue ?>'), ':'); ?]<?php if ($help = $this->getParameterValue("config.fields.".$column->getName().".help", '')): ?> <a href="#" class="help" title="[?php echo __('<?php echo $help ?>', null, '<?php echo $i18n_catalogue ?>') ?]"></a><?php endif; ?>
            </label>
            <div class="field[?php if ($sf_request->hasError('config{<?php echo $column->getName() ?>}')): ?] form-error[?php endif; ?]">
    <?php endif; ?>
<?php endif; ?>
[?php if ($sf_request->hasError('config{<?php echo $column->getName() ?>}')): ?]
            [?php echo form_error('config{<?php echo $column->getName() ?>}', array('class' => 'form-error-msg')) ?]
[?php endif; ?]
[?php echo <?php echo $this->getColumnFormTag($column,'config'); ?>; ?]        
<?php if ($this->getParameterValue("config.fields.".$column->getName().".hide_row") == true):  ?>
<?php else: ?>   
    <?php if ($this->getParameterValue("config.fields.".$column->getName().".hide_label") == true):  ?>

    <?php else: ?>
            </div>
            <div class="clr"></div>
    <?php endif; ?>
        </div>
<?php endif ?>
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
</div>
</fieldset>
<?php if ($category_old_config): ?>
  [?php endif; ?]
<?php endif ?>
<?php if ($category_install_version): ?>
[?php endif; ?]
<?php endif ?>
<?php endforeach; ?>

<div id="config_actions">[?php st_include_partial('<?php echo $this->getCustomActionName('', '_') ?>config_actions', array('config' => $config, 'forward_parameters' => $forward_parameters)) ?]</div>
</form>

<script type="text/javascript">
jQuery(function($) {
    $(document).ready(function() {
        $('#config_actions').stickyBox();
    });
});
</script>
