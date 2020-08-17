<?php use_helper('I18N', 'Text', 'stAdminGenerator', 'Object', 'ObjectAdmin', 'stDate', 'stProductImage','stCurrency','stWidgets') ?>
<div id="main_nav">

<?php $route = sfRouting::getInstance(); ?>

    <?php if(@$apps): ?>
    <div id="qpanel_main">
        <div id="qpanel_list">
            <?php foreach ($apps as $id => $title): ?>
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
            <div class="img_icons_main">
               <div class="box_icons_main">
                <?php echo st_link_to(image_tag('backend/main/icons/stUpdate.png', array(
                    'id'    => 'app_stUpdate',
                    'class' => 'qpanel_apps'
                    )), 'stInstallerWeb/index', array('for_app' => 'update'))?>
                <div class="font_normal_main">
                    <?php echo st_link_to(__('Uaktualnienia'), 'stInstallerWeb/index', array('for_app' => 'update')); ?>
                </div>
            </div>
            </div>
        </div>
    </div>
    <?php else: ?>
   <div id="sf_admin_container">

      <div id="column1" class="column" style="width: 49%; float: left;">

         <?php // echo st_get_component("stBackendMain",'desktopIcons') ?>

         <div id="last-order-widget">
            <?php echo st_get_component("stOrder",'lastOrderWidget') ?>
         </div>
         
      <div style="clear: both;"></div>
      </div>

      <div id="column2" class="column" style="width: 50%; float: left;">

         <div id="product-last-order-widget">
            <?php echo st_get_component("stOrder",'productLastOrderWidget') ?>
         </div>

         <div id="register-user-widget">
         <?php echo st_get_component("stUser",'registerUserWidget') ?>
         </div>

         <div style="clear: both;"></div>
      </div>

   <div style="clear: both;"></div>
   </div>
   <?php endif; ?>

</div>