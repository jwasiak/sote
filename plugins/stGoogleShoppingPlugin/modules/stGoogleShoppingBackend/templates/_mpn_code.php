<?php if(GoogleShoppingPeer::isGoogleShoppingActive($product)): ?>
<?php echo st_admin_get_form_field('product[mpn_code]', __('Kod MPN'), $product->getMpnCode(), 'input_tag'); ?>    
<?php endif; ?>
