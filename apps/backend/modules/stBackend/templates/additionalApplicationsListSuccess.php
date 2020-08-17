<?php use_helper('stAdminGenerator') ?>

<?php echo st_get_admin_head(array('stBackend/additionalApplicationsList', __('Dodatkowe aplikacje'), '/images/backend/main/icons/red/addition_application.png')) ?>

<?php use_helper('stBackend') ?>
<div class="application_shortcuts">
   <ul>
      <?php foreach ($applications as $application): $url = st_url_for($application->getRoute()) ?>
         <?php if($application->getName() != 'appProductAttributeBackend' &&  $application->getName() != 'appAdditionalDescBackend'): ?>
            <li>
               <div class="icon" style="float: left;">
                  <a target="_parent" href="<?php echo $url ?>" style="background-image: url(<?php echo get_app_icon($application->getIconPath()) ?>);"></a>
               </div>
               <div class="name">
                  <a target="_parent" href="<?php echo $url ?>"><?php echo $application->getLabel() ?></a>
               </div>
            </li>
         <?php endif; ?>
      <?php endforeach ?>
   </ul>
   <?php if(count($applications) == 2): ?>
      <div style="margin: 10px; min-height: 50px; border: 1px solid #ccc; padding: 10px;">
         <p style="font-family: Helvetica,Arial,sans-serif; font-size: 12px; padding-top: 15px;"><?php echo __('Brak zainstalowanych dodatkowych aplikacji', null, 'stBackend') ?></p>
      </div>
   <?php endif; ?>
   <div class="clr"></div>
</div>

<?php echo st_get_admin_foot() ?>