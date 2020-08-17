<?php use_helper('stBackend') ?>
<?php if (isset($column)): ?>
<div class="add-gadget-placeholder" <?php if ($gadgets): ?> style="display: none;"<?php endif; ?>>
   <a class="add-gadget" href="#<?php echo get_gadget_column_id($dashboard->getId(), $column) ?>" rel="#gadgets_directory">
      <img src="/images/backend/beta/gadgets/add_gray.png" alt="" />
   </a>
</div>
<?php endif; ?>
<?php foreach ($gadgets as $gadget): 
$id = $gadget->getId();
$i18n_catalogue = $gadget->getConfigurationParameter('i18n', 'stBackend');
 ?>
   <div class="gadget" id="gadget-<?php echo $id ?>">

      <h2 class="moveable"><?php echo __($gadget->getTitle(), null, $i18n_catalogue) ?></h2>
      <ul class="menu">
         <li class="config">
            <a href="#"><img src="/images/backend/beta/icons/22x22/config.png"/></a>
            <ul class="dropdown_menu">
               <?php if ($gadget->getConfigurationParameter('refresh')): ?>
                  <li><a class="action refresh" href="#gadget-<?php echo $id ?>"><?php echo __('Odśwież', null, 'stBackend') ?></a></li>
               <?php endif; ?>
               <li><a class="action edit" href="#gadget-<?php echo $id ?>"><?php echo __('Edytuj', null, 'stBackend') ?></a></li>
               <?php if ($gadget->checkCredentials('removable')): ?>
               <li><a class="action delete" href="#gadget-<?php echo $id ?>"><?php echo __('Usuń', null, 'stBackend') ?></a></li>
               <?php endif ?>
            </ul>
         </li>
      </ul>
      <?php if (!$gadget->getIsMinimized()): ?>
         <div class="content preloader_160x24">
            <?php echo get_gadget_source($gadget) ?>
         </div>
      <?php endif; ?>
   </div>
   <?php if ($gadget->getRefreshBy() > 0): ?>
      <script type="text/javascript">
         jQuery(function($) {
            initGadgetRefresh($('#gadget-<?php echo $id ?>'), <?php echo $gadget->getRefreshBy() * 1000 ?>);
         });
      </script>
   <?php endif; ?>
<?php endforeach; ?>
