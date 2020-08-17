<?php use_helper('I18N', 'Text', 'stAdminGenerator', 'Object', 'ObjectAdmin', 'stDate', 'stProductImage','stCurrency','stWidgets') ?>
<?php $route = sfRouting::getInstance(); ?>

    
<?php echo st_open_widget('Apps', __('Aplikacje')) ?>
   <?php $count = 0; ?>
   <?php foreach ($apps1 as $id => $title): ?>
       <?php $count = $count + 1; ?>
       <?php $route_name = '@' . $id ?>
       <?php $routeName = $route->hasRouteName($id . 'Default') ? $route_name . 'Default' : $route_name; ?>
       <?php $routeInfo = $route->getRouteByName($routeName); ?>
       <?php $moduleName = $routeInfo[4]['module']; ?>
       <div class="img_icons_main">
           <div class="box_icons_main">
               <?php echo link_to(image_tag('backend/main/icons/'.$id, array(
               'id'    => 'app_'.$id,
               'class' => 'qpanel_apps',
               'width' => '56px',
               'height' => '56px',
               
               )), $routeName) ?>
               <div class="font_normal_main">
                   <?php echo link_to("<nobr>".__($title, null, $moduleName)."</nobr>", $routeName); ?>
               </div>               
           </div>
       </div>
   <?php endforeach; ?>
<?php echo st_close_widget();?>
