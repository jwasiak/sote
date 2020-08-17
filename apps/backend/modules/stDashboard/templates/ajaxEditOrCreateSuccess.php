<?php use_helper('stBackend') ?>
<div class="close" style="position: absolute; right: -20px; text-align: right; top: -20px; width: 100%;"><a href="#"><img src="/images/frontend/theme/default2/buttons/close.png" alt="<?php echo __('Zamknij', null, 'stBackend') ?>" /></a></div>
<h2><?php echo $dashboard->isNew() ? __('Dodaj pulpit', null, 'stBackend') : __('Edycja pulpitu', null, 'stBackend') ?></h2>
<div class="content">
   <form class="admin_form" action="<?php echo st_url_for('@stDashboard?action=ajaxEditOrCreate') ?>?id=<?php echo $dashboard->getId() ?>" method="post">
      <div class="row">
         <label for="dashboard_configuration_default"><?php echo __('Domyślny', null, 'stBackend') ?>:</label>
         <div class="field">
            <?php if (!$dashboard_count): ?>
               <input type="hidden" value="1" name="dashboard_configuration[default]" />
            <?php endif; ?>
            <?php echo checkbox_tag('dashboard_configuration[default]', true, $dashboard->getIsDefault(), array('disabled' => $dashboard->getIsDefault())) ?>
         </div>
         <div class="clr"></div>
      </div>      
      <div class="row">
         <label for="dashboard_configuration_label"><?php echo __('Nazwa', null, 'stBackend') ?>:</label>
         <div class="field">
            <?php echo input_tag('dashboard_configuration[label]', $dashboard->isNew() ? __('Nowy pulpit', null, 'stBackend') : $dashboard->getLabel(), array('required' => 'required', 'maxlength' => 32, 'size' => 32)) ?>
         </div>
         <div class="clr"></div>
      </div>
      <div class="row">
         <label for="dashboard_configuration_layout"><?php echo __('Układ', null, 'stBackend') ?>:</label>
         <div class="field">
            <?php echo get_dashboard_layout_tag('dashboard_configuration[layout]', $dashboard) ?>
         </div>
         <div class="clr"></div>
      </div>
      <ul class="admin_actions">
         <?php if ($dashboard->isNew()): ?>
            <li class="action-add"><input type="submit" value="<?php echo __('Dodaj', null, 'stBackend') ?>" /></li>
         <?php else: ?>
            <li class="action-save"><input type="submit" value="<?php echo __('Zapisz', null, 'stBackend') ?>" /></li>
         <?php endif; ?>
      </ul>
      <div class="clr"></div>
   </form>
</div>