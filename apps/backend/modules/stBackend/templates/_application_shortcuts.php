<?php use_helper('stBackend') ?>
<div class="application_shortcuts">
   <ul>
      <?php 
         $check_file = sfConfig::get('sf_plugins_dir'). DIRECTORY_SEPARATOR. 'stIfirmaPlugin';
         foreach ($applications as $application): 
         $url = st_url_for($application->getRoute()); 
         /* Aplikacje do ukrycia */
         if (in_array($application->getName(), array('stPointsBackend', 'stAddThisBackend')) && stTheme::hideOldConfiguration()) continue;   
         if ($application->getRoute()=='stInvoiceBackend/ifirmaConfig' && !file_exists($check_file)) continue;
      ?>         
            <li>
               <div class="icon" style="float: left;">
                  <a target="_parent" href="<?php echo $url ?>" style="background-image: url(<?php echo get_app_icon($application->getIconPath()) ?>);"></a>
               </div>
               <div class="name">
                  <a target="_parent" href="<?php echo $url ?>"><?php echo $application->getLabel() ?></a>
               </div>
            </li>
      <?php endforeach ?>
   </ul>
   <div class="clr"></div>
</div>