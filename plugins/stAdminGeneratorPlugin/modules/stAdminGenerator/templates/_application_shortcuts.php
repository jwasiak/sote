<?php $routing = sfRouting::getInstance(); ?>
<?php $module = stConfiguration::getInstance()->getDesktopModule($sf_context->getModuleName()); ?>
<?php $module_name = sfContext::getInstance()->getModuleName(); ?>
<?php $action_name = sfContext::getInstance()->getActionName(); ?>
<?php init_tooltip('.help') ?>
<?php init_tooltip('.float_right_config .tooltip, .header .menu > ul > .expandable a.relatedmodules', array('width' => 'auto', 'position' => 'bottom right')) ?>

<div class="header">

  <h2 class="float_left">
    <a href="<?php echo st_url_for($route) ?>" style="text-decoration: none; color: #555; font-size: 14px;"><?php if ($icon): ?><img src="<?php echo $icon ?>" alt="<?php echo $label ?>" /><?php endif; ?><?php echo $label ?></a>
    <?php if ($title): ?> <img class="next" src="/images/backend/beta/icons/16x16/next.png" > <?php echo $title ?><?php endif ?>
  </h2>
  
  <div class="float_right_config">
      <?php
        st_include_component("stDocBackend", "showDocLink", array('module_name' => $module_name)); 
      ?>    
  </div>

  <?php if (isset($options['culture']) && $options['culture']): ?>
    <div class="float_right"><span style="float: left; margin-right: 5px; margin-top: 3px;"><?php echo __('Język edycji', null, 'stBackendMain') ?></span><?php echo st_get_admin_culture_picker(array('url' => isset($options['route']) ? $options['route'] : $route, 'culture' => $options['culture'])) ?></div>
  <?php endif; ?>

  <?php if ($module): ?>
    <?php if ($action_name != 'configCustom' && $action_name != 'config'): ?>
      <div class="float_right_config">                    
        <a href="<?php echo st_url_for($module->getRoute()) ?>" style="text-decoration: none; color: #555;" ><?php echo __('Konfiguracja', null, 'stBackendMain') ?> <img src="/images/backend/beta/icons/22x22/config.png" style="vertical-align: middle;"></a>
      </div>
    <?php endif; ?>


  <?php elseif ($module_name == 'stProduct' && $action_name != 'config' && $action_name != 'presentationConfig' && $action_name != 'dimensionList'): ?>
    
    <div class="float_right_config">  
      <a href="/backend.php/product/config" style="text-decoration: none; color: #555;" ><?php echo __('Konfiguracja', null, 'stBackendMain') ?> <img src="/images/backend/beta/icons/22x22/config.png" style="vertical-align: middle;"></a>
    </div>
    
    <?php if($action_name == 'edit'): ?>  
    <div class="float_right_config">
        <a href="/backend.php/report/product/id/<?php echo sfContext::getInstance()->getRequest()->getParameter('id'); ?>" style="text-decoration: none; color: #555;" ><?php echo __('Raporty', null, 'stBackendMain') ?> <img src="/images/backend/beta/icons/22x22/reports.png" style="vertical-align: middle; padding-right:10px;"></a>
    </div>
    <?php endif; ?>
  
  <?php endif; ?>
</div>
<div class="clr"></div>