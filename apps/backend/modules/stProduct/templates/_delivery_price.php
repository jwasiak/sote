<?php echo input_tag('product[delivery_price]', stPrice::round($product->getDeliveryPrice()), array('size' => 8)) ?> <?php echo __(ucfirst($product->getConfiguration()->get('delivery_price_type', 'netto'))) ?>

<?php echo st_price_add_format_behavior('product_delivery_price') ?>