<?php use_helper('stBackend') ?>
<?php $i18n_catalogue = $gadget->getConfigurationParameter('i18n', 'stBackend'); ?>
<div class="close" style="position: absolute; right: -20px; text-align: right; top: -20px; width: 100%;"><a href="#"><img src="/images/frontend/theme/default2/buttons/close.png" alt="<?php echo __('Zamknij', null, 'stBackend') ?>" /></a></div>
<h2><?php echo __('Konfiguracja gadżetu', null, 'stBackend') ?></h2>
<div class="content">
   <form class="admin_form" action="<?php echo st_url_for('@stDashboard?action=ajaxEditGadget') ?>?id=<?php echo $gadget->getId() ?>&dashboard_id=<?php echo $gadget->getDashboardId() ?>" method="post">
   	<div class="row">
   		<label for="gadget_configuration_title"><?php echo __('Nazwa gadżetu', null, 'stBackend') ?>:</label>
         <div class="field">
            <input type="text" value="<?php echo __($gadget->getTitle(), null, $i18n_catalogue) ?>" id="edit_gadget_title" name="gadget_configuration[title]" />
         </div>
   		<div class="clr"></div>
   	</div>
   <?php if ($gadget->getConfigurationParameter('refresh')): ?>
      <div class="row">
         <label for="gadget_configuration_color"><?php echo __('Odświeżaj', null, 'stBackend') ?>:</label>
         <div class="field">
            <?php echo gadget_refresh_rates_tag('gadget_configuration[refresh_by]', $gadget) ?>
         </div>
         <div class="clr"></div>
      </div>
   <?php endif; ?>
      <ul class="admin_actions">
   	  <li class="action-save"><input type="submit" value="<?php echo __('Zapisz', null, 'stBackend') ?>" /></li>
      </ul>
      <div class="clr"></div>
   </form>
</div>