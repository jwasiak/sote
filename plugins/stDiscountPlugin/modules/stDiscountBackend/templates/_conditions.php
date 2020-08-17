<?php echo input_tag ('discount[conditions][from_amount]', stPrice::round($discount->getCondition('from_amount', 0)), array('size' => 7, 'class' => 'support')) ?> <?php echo stCurrency::getDefault()->getShortcut() ?>
           
<?php echo st_price_add_format_behavior('discount_conditions_from_amount'); ?>