<?php $smarty->assign('comment', textarea_tag("description", $description, array ('id' => 'description', 'style' => 'width: 100%; height: 100px'))) ?>

<?php st_theme_use_stylesheet('stOrder.css') ?>

<?php $errors = $sf_request->getErrors() ?>
<?php $block = 0 ?>
<?php foreach($errors as $error => $msg): ?>
    <?php if(preg_match('/basket/', $error)) $block = 1; ?>
<?php endforeach;?>

<?php $smarty->assign('disabled', $block) ?>

<?php $smarty->assign('description_submit', submit_tag(
                                ($block ? __('Popraw zamówienie') : __('Przejdź do potwierdzenia')),
                                    array('name'=>'submit_save',
                                        'disabled' => ($block ?  'disabled' : '')))) ?>
            
<?php $smarty->display('order_description.html') ?>