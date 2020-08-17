<?php

// standard

$smarty->assign('ecommerce_check', $ecommerce_check);

$smarty->assign('analytics', $analytics);

$smarty->assign('analytics_part2', $analytics_part2);

$smarty->assign('analytics_part3', $analytics_part3);

// e-commerce

if ($ecommerce_check == 1){

	$smarty->assign('order_id', $order->getId());

	$smarty->assign('host', $host);

	$smarty->assign('order_amount', $order->getTotalAmount(true));

	$smarty->assign('delivery_cost', $order_delivery->getCostBrutto());

	$smarty->assign('currency',$order->getOrderCurrency()->getShortcut());

	$smarty->assign('user_town', $user->getTown());

	$smarty->assign('country_name', $country_name);

	$row=array();

	foreach ($order->getOrderProducts() as $index => $order_products){

	    $options = '';

	    foreach ($order_products->getPriceModifiers() as $modifier){

	        $options .= $modifier['label']."/";
	    }

	    if ($options){

	        $last = substr($options, -1);
	        if ($last == "/")
	        {
	            $options = substr($options, 0, -1);
	        }
	        $options_name = "[".$options."]";

	        $options_code = "-".$options;

	    }else{

	        $options_name = '';

	        $options_code = '';
		}

	    $row[$index]['order_id']=$order->getId();

	    if ($type_id == 'product_id'){ 

	    $row[$index]['product_code']=$order_products->getProductId();

		}elseif($type_id == 'product_code'){

		 $row[$index]['product_code']=$order_products->getCode();

		}

	    $row[$index]['product_name']=$order_products->getName();

	    $row[$index]['product_options'] = $options_name;

	    $row[$index]['product_category'] = '';

		if ($order_products->getProduct()->getDefaultCategory()){

	    	$row[$index]['product_category'] = $order_products->getProduct()->getDefaultCategory()->getName();

		}

	    $row[$index]['brand'] = '';

	    if ($order_products->getProduct()->getProducer()){
		
			$row[$index]['brand'] = $order_products->getProduct()->getProducer()->getName();
	    
	    }
	

	    $row[$index]['product_price']=stCurrency::calculateBruttoFromNetto($order_products->getPrice(), $order_products->getVat());

	    $row[$index]['product_quantity']=$order_products->getQuantity();
	}

	$smarty->assign('results',$row);

}

$smarty->display('google_standard.html');
?>
