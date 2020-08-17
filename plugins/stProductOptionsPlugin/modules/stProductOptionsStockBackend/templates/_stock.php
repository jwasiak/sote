<?php 
use_helper('stPrice');
echo  input_tag('product_options_value['.$product_options_value->getId().'][stock]', $product_options_value->getStock(), array(
    'size' => 10,
    'tabindex' => $product_options_value->getId(),
    'class' => 'stock_value',
    'style' => 'text-align: center; vertical-align: middle; margin-right: 5px', 'disabled' => null === $product_options_value->getStock()));
echo checkbox_tag('product_options_value['.$product_options_value->getId().'][stock_enabled]', 1, null !== $product_options_value->getStock(), array('class' => 'stock_enabled'));
?>
<input type="hidden" name="product_options_value[<?php echo $product_options_value->getId() ?>][disabled]" value="<?php echo intval(null === $product_options_value->getStock()) ?>" />
