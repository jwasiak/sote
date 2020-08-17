<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'VisualEffect', 'stAdminGenerator', 'stDate', 'stJQueryTools', 'stThemeBackend') ?>

<?php st_include_partial('stThemeBackend/header', array('related_object' => $theme_config->getTheme(), 'title' => __('Zastosuj konfigurację'), 'route' => 'stThemeBackend/applyChanges?id='.$theme_config->getId())) ?>

<?php st_include_component('stThemeBackend', 'editMenu', array('related_object' => $theme_config->getTheme())); ?>

<div id="sf_admin_content">
<?php if ($theme_config->getTheme()->getVersion() < 2): ?>
   <div class="form-errors">
      <h2><?php echo __('Konfiguracja wygladu dostępna jest wyłącznie dla tematow opartych na default2') ?></h2>
   </div>   
<?php elseif (!$editor_config->validate()): ?>
   <div class="form-errors">
      <h2><?php echo __('Konfiguracja wygladu nie została jeszcze dodana dla tego tematu') ?></h2>
   </div>      
<?php else: ?>   
   <?php st_include_partial('stThemeBackend/edit_messages', array('labels' => isset($labels) ? $labels : array())) ?>
   <div class="form-errors">
      <h2><?php echo __('Zmiany w konfiguracji palety kolorów i grafiki zostaną zastosowane') ?></h2>
   </div>
   <?php echo st_get_admin_actions_head() ?>   
   <?php echo st_get_admin_action('save', __('Zastosuj'), 'stThemeBackend/applyChanges?id='.$theme_config->getId().'&save=1') ?>                 
   <?php echo st_get_admin_actions_foot() ?>      
<?php endif; ?>
</div>

<?php st_include_partial('stThemeBackend/footer', array('related_object' => $theme_config->getTheme())); ?>

<script type="text/javascript">
jQuery(function($) {
    $(document).ready(function() {
        $('#edit_actions').stickyBox();
    });

});
</script>