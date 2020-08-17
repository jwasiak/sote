<?php if($product->getOptHasOptions()>1): ?>
    <?php use_stylesheet('backend/stProductOptionsPlugin.css')?>
    <?php echo st_get_admin_actions_head('id = "st_edit_stock_action"') ?>
        <?php echo st_get_admin_action('edit', __('Edytuj', null, 'stProduct'), 'stProduct/optionsStockList?id='.$product->getId()) ?>
    <?php echo st_get_admin_actions_foot() ?>
    
    <?php echo use_helper('Javascript') ?>
    <?php echo javascript_tag(" var old_value = {$old_stock};
                                $('product_stock').disabled = $('product_is_depository').checked;
                                if ($('product_is_depository').checked) {
                                    $('st_edit_stock_action').show();
                                } else {
                                    $('st_edit_stock_action').hide();
                                }
                                Event.observe(window, 'load', function() {
                                    Event.observe('product_is_depository', 'change',function(event) {
                                        $('product_stock').disabled = $('product_is_depository').checked;
                                        if ($('product_is_depository').checked) {
                                            old_value = $('product_stock').value;
                                            $('product_stock').value = {$options_stock};
                                            $('st_edit_stock_action').show();
                                        } else {
                                            $('product_stock').value = old_value;
                                            $('st_edit_stock_action').hide();
                                        }
                                    })
                                });")?>
<?php endif; ?>