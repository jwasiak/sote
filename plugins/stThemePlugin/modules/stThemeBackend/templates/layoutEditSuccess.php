<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'VisualEffect', 'stAdminGenerator', 'stDate', 'stJQueryTools', 'stThemeBackend') ?>

<?php st_include_partial('stThemeBackend/header', array('related_object' => $theme_config->getTheme(), 'title' => __('Konfiguracja układu'), 'route' => 'stThemeBackend/layoutEdit?id='.$theme_config->getId())) ?>

<?php st_include_component('stThemeBackend', 'editMenu', array('related_object' => $theme_config->getTheme())); ?>

<div id="sf_admin_content">
<?php if ($theme_config->getTheme()->getVersion() < 2): ?>
   <div class="form-errors">
      <h2><?php echo __('Konfiguracja układu dostępna jest wyłącznie dla tematow opartych na default2') ?></h2>
   </div>       
<?php else: ?>   
   <?php st_include_partial('stThemeBackend/edit_messages', array('labels' => isset($labels) ? $labels : array())) ?>
   <?php st_include_partial('stThemeBackend/layout_edit_form', array('theme_config' => $theme_config, 'config' => $config)) ?>
<?php endif; ?>   
</div>

<?php st_include_partial('stThemeBackend/footer', array('related_object' => $theme_config->getTheme())); ?>