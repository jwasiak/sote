<?php st_theme_use_stylesheet('stUser.css') ?>

<?php $smarty->assign('user_panel_icon', st_theme_image_tag('user_panel_icon.png')) ?>

<?php $smarty->assign('my_account', link_to(__('Moje konto'), 'stUserData/userPanel')) ?>

<?php $smarty->assign('user_panel_menu',  st_get_component('stUserData', 'userPanelMenu')) ?>

<?php if ($pager->getNbResults()): ?>  

    <?php $smarty->assign('pager', $pager->getNbResults()) ?>
    
    <?php $smarty->assign('pager_results', st_get_partial('stPointsFrontend/points_list', array('points' => $pager->getResults(), 'smarty' => $smarty))) ?>
    
<?php endif; ?>

<?php
$config_points = stConfig::getInstance('stPointsBackend');
$config_points -> setCulture(sfContext::getInstance() -> getUser() -> getCulture());
?>
<?php $smarty -> assign('user_points', stPoints::getLoginStatusPoints()); ?>

<?php $smarty -> assign('release_points', stPoints::isReleasePointsSystemForUser()); ?>

<?php $smarty -> assign('points_shortcut', $config_points -> get('points_shortcut', null, true)); ?>

<?php $smarty -> assign('points_release_value', $config_points -> get('points_release_value')); ?>

<?php $smarty->display('points_list.html') ?>