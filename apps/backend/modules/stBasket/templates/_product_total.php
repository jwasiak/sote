<?php use_helper('stCurrency') ?>
<?php echo st_back_price(stCurrency::calculateVat($basket_product->getPrice(), $basket_product->getVat()) * $basket_product->getQuantity(), true, true) ?>