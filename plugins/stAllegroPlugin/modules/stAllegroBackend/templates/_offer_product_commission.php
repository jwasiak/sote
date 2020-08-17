<?php use_helper('stPrice') ?>
<?php $product_commission = $config->get('offer_product_commission', array('commission' => 0, 'round_type' => 'none')); ?>
<?php echo input_tag('config[offer_product_commission][commission]', $product_commission['commission'], array('size' => 6)) ?>
<?php echo st_price_add_format_behavior('config_offer_product_commission_commission', 1) ?>
&nbsp;
<?php echo select_tag('config[offer_product_commission][round_type]', options_for_select(array(
    'none' => __('Nie zaokrąglaj'),
    'full_buck' => __('Zaokrąglaj do pełnych złotych')
), $product_commission['round_type'])) ?>