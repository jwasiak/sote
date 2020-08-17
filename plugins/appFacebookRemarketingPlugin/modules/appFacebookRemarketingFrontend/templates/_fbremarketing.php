<?php

$smarty->assign('config_fbremarketing', $fbremarketingConfig);

if ($product_card == 1) {

    $smarty->assign('product_card', $product_card);

    $smarty->assign('name', addslashes($product->getName()));

    if ($product->getDefaultCategory()){

    $smarty->assign('category', addslashes($product->getDefaultCategory()->getName()));
    
    }else{

    $smarty->assign('category', "NONE");

    }

    $smarty->assign('code', $product->getCode());
    
    $smarty->assign('price', $product->getPriceBrutto());
    
    $smarty->assign('currency', $product->getCurrency());    

}

if ($orders == 1) {

    $smarty->assign('orders', $orders);

    $smarty->assign('value', $order->getTotalAmount(true));

    $smarty->assign('currency', $order->getOrderCurrency()->getShortcut());

    $row=array();

    @$last_key = end(array_keys($order->getOrderProducts()));

    $sum = 0;

    foreach ($order->getOrderProducts() as $index => $order_products)
    {


        if ($index == $last_key)
        {
            $row[$index]['code']=$order_products->getCode();

        } else {
            
            $row[$index]['code']=$order_products->getCode().', ';

        }

        $row[$index]['quantity']=$order_products->getQuantity();

        $sum+= $row[$index]['quantity'];

    }
    
    $smarty->assign('num_items', $sum);

    $smarty->assign('results',$row); 

}

$smarty->assign('lang', $lang);

$smarty->display('fbremarketing.html');