<?php st_theme_use_stylesheet('stOrder.css') ?>

<?php $smarty->assign('disabled', $disabled) ?>

<?php $smarty->assign('label', isset($label) ? $label : null) ?>

<?php $smarty->display('order_submit_button.html') ?>
