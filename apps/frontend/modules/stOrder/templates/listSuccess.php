<?php st_theme_use_stylesheet('stUser.css') ?>

<?php st_theme_use_stylesheet('stOrder.css') ?>

<?php $smarty->assign('user_panel_icon', st_theme_image_tag('user_panel_icon.png')) ?>

<?php $smarty->assign('my_account', link_to(__('Moje konto'), 'stUserData/userPanel')) ?>

<?php $smarty->assign('user_panel_menu',  st_get_component('stUserData', 'userPanelMenu')) ?>

<?php if ($pager->getNbResults()): ?>  

    <?php $smarty->assign('pager', st_get_partial('stOrder/pager', array('order_pager' => $pager, 'smarty' => $smarty))) ?>
    
    <?php $smarty->assign('pager_results', st_get_partial('stOrder/orders_list', array('orders' => $pager->getResults(), 'smarty' => $smarty))) ?>
    
<?php endif; ?>

<?php $smarty->display('order_list.html') ?>