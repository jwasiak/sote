<?php use_helper('stTooltip'); ?>
<?php if($userId): ?>
    <?php include_tooltip(); ?>
    <div id="sf_admin_quick_panel">
        <div <?php echo get_tooltip(__('Strona główna panelu'), '3', 130) ?>><?php echo link_to(image_tag('backend/main/icons_small/home.png'),'@homepage') ?></div>
        <div <?php echo get_tooltip(__('Strona główna sklepu'), '3', 130) ?>><?php echo link_to(image_tag('backend/main/icons_small/frontend.png'),'../index.php', 'target="_blank"') ?></div> 
        <?php foreach ($ModuleName as $module): ?>
            <div> 
                <?php if(file_exists(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'main'.DIRECTORY_SEPARATOR.'icons_small'.DIRECTORY_SEPARATOR.$module->getModule().'.png')): ?>
                    <?php $name = __(stApplication::getAppName(stBackendFastMenu::getModuleName($module->getModule())),null,$module->getModule()) ?>
                    <?php $app_name = stBackendFastMenu::getModuleName($module->getModule()) ?>
                    <span <?php echo get_tooltip($name,'3' , 130) ?>><?php echo link_to(image_tag('backend/main/icons_small/'.$module->getModule()),sfRouting::getInstance()->hasRouteName($app_name . 'Default') ? '@' . $app_name . 'Default' : '@' . $app_name) ?></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>