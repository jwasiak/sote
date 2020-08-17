<?php if (array_key_exists($config->get('product_view'),$template_files)): ?>
    <?php $select_option=$config->get('product_view');?>
<?php else:?>
    <?php $select_option='default';?>
<?php endif;?>

<?php echo select_tag('config[product_view]', options_for_select($template_files,$select_option));?>
