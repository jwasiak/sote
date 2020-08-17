<?php echo st_get_admin_actions_head('style="float: left"');?>
<?php if (method_exists($theme, 'getIsSystemDefault') == false || (method_exists($theme, 'getIsSystemDefault') && !$theme->getIsSystemDefault())):?>
    <?php if ($theme->getId()):?>
        <?php echo st_get_admin_action('delete', __('Usuń', null, 'stAdminGeneratorPlugin'), 'stThemeBackend/delete?id='.$theme->getId(), array("confirm" => __("Jesteś pewien?", null, 'stAdminGeneratorPlugin'), "name" => "delete",));?>
    <?php endif; ?>
<?php endif; ?>
</ul>
<?php echo st_get_admin_actions_head('style="float: right"');?>
    <?php echo st_get_admin_action('list', __('Lista', null, 'stAdminGeneratorPlugin'), 'stThemeBackend/list', array("name" => "list",));?>
    <?php if ($theme->getId()):?>
        <?php echo st_get_admin_action('view', __('Podgląd', null, 'stThemeBackend'), '/frontend_theme.php?theme='.$theme->getName().'&theme_culture='.$theme->getBackendCulture(), array("name" => "preview",));?>
        <?php echo st_get_admin_action('download_theme', __('Pobierz temat', null, 'stThemeBackend'), 'stThemeBackend/downloadTheme?id='.$theme->getId(), array("name" => "download",));?>
    <?php endif;?>
    <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array("name" => "save",));?>
<?php echo st_get_admin_actions_foot();?>
