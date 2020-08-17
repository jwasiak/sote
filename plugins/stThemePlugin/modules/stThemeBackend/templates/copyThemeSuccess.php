<?php use_helper('stAdminGenerator', 'stProgressBar') ?>

<?php st_include_partial('stThemeBackend/header', array('related_object' => $theme, 'title' => __('Zastosuj konfigurację'), 'route' => 'stThemeBackend/edit?id='.$theme->getId())) ?>

<?php st_include_component('stThemeBackend', 'editMenu', array('related_object' => $theme)); ?>

<div id="sf_admin_content">
    <?php echo progress_bar('stThemeCopy_'.$copy_theme.'_'.$theme->getId().'_'.$theme_name, 'stThemeCopyProgressBar', 'step', stThemeCopyProgressBar::getSteps());?>
    <?php echo st_get_admin_actions_head('style="float: right; visibility: hidden;" id="theme-progressbar-button"');?>
        <?php echo st_get_admin_action('save', __('Dalej'), 'stThemeBackend/edit?id='.$theme->getId(), array("name" => "save",));?>
    <?php echo st_get_admin_actions_foot();?>
</div>

<?php st_include_partial('stThemeBackend/footer', array('related_object' => $theme)); ?>