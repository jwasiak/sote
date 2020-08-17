<?php if ($order->getsfGuardUserId()): ?>
<?php echo st_external_link_to($order->getsfGuardUser()->getUsername(), 'user/edit?id=' . $order->getsfGuardUserId()) ?>
<?php else: ?>
<?php echo $order->getOptClientEmail() ?>
<?php endif; ?>

<?php echo $order->getOrderLanguage() ? image_tag('/'.sfConfig::get('sf_upload_dir_name').'/stLanguagePlugin/'.$order->getOrderLanguage()->getActiveImage(), array('style' => 'vertical-align: middle; margin-left: 5px')) : '' ?>