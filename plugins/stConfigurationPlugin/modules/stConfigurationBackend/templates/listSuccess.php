<?php use_helper('stAdminGenerator'); ?>

<?php echo st_get_admin_head('stConfigurationPlugin', __('Wybierz jeden z modułów konfiguracyjnych')) ?>
<div class="application_groups" id="application_configuration">
<?php foreach ($configuration->getDesktopModules() as $group => $applications): ?>
   <div class="fieldset">
      <h2><?php echo __($group) ?></h2>
      <div class="content">
         <?php st_include_partial('stBackend/application_shortcuts', array('applications' => $applications)) ?>
      </div> 
   </div>
<?php endforeach; ?>
</div>
<?php echo st_get_admin_foot() ?>