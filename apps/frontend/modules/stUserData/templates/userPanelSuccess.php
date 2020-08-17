<?php
use_helper('Validation', 'stUrl', 'stOrder', 'stProductOptions', 'stProductImage', 'stDelivery');

sfLoader::loadHelpers('stProduct', 'stProduct');

st_theme_use_stylesheet('stUser.css');

$smarty->assign('config_newsletter', $newsletterConfig);
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('user_panel_icon', st_theme_image_tag('user_panel_icon.png'));
$smarty->assign('my_account', link_to(__('Moje konto'), 'stUserData/userPanel'));
$smarty->assign('user_panel_menu', st_get_component('stUserData', 'userPanelMenu'));
$smarty->assign('user_email', sfContext::getInstance()->getUser()->getUsername());

$smarty->assign('user_discounts', $user_discounts);

if (isset($user_order)) {
    $smarty->assign('user_order', $user_order);
}

if ($userDataBilling) {

    $smarty->assign('billing_company', $userDataBilling->getCompany());
    $smarty->assign('billing_vat_number', $userDataBilling->getVatNumber());
    $smarty->assign('billing_full_name', $userDataBilling->getFullName());
    $smarty->assign('billing_address', $userDataBilling->getAddress());
    $smarty->assign('billing_address_more', $userDataBilling->getAddressMore());
    $smarty->assign('billing_region', $userDataBilling->getRegion());
    $smarty->assign('billing_code', $userDataBilling->getCode());
    $smarty->assign('billing_town', $userDataBilling->getTown());
    $smarty->assign('billing_country', $userDataBilling->getCountries());
    $smarty->assign('billing_phone', $userDataBilling->getPhone());
    $smarty->assign('billing_pesel', $userDataBilling->getPesel());

    $billing_edit_url = st_url_for('stUserData/editProfile?userDataType=billing&userDataId=' . $userDataBilling->getId() . '&showEditProfileForm=true');

    if ($userDataBilling->getAddress() != "") {
        $smarty->assign('billing_edit_url', $billing_edit_url);
    } else {
        $smarty->assign('billing_edit_url', "");
    }
}

if ($userDataDelivery) {
    $smarty->assign('delivery_company', $userDataDelivery->getCompany());
    $smarty->assign('delivery_full_name', $userDataDelivery->getFullName());
    $smarty->assign('delivery_address', $userDataDelivery->getAddress());
    $smarty->assign('delivery_address_more', $userDataDelivery->getAddressMore());
    $smarty->assign('delivery_region', $userDataDelivery->getRegion());
    $smarty->assign('delivery_code', $userDataDelivery->getCode());
    $smarty->assign('delivery_town', $userDataDelivery->getTown());
    $smarty->assign('delivery_country', $userDataDelivery->getCountries());
    $smarty->assign('delivery_phone', $userDataDelivery->getPhone());

    $delivery_edit_url = st_url_for('stUserData/editProfile?userDataType=delivery&userDataId=' . $userDataDelivery->getId() . '&showEditProfileForm=true');

    if ($userDataDelivery->getAddress() != "") {
        $smarty->assign('delivery_edit_url', $delivery_edit_url);
    } else {
        $smarty->assign('delivery_edit_url', "");
    }

}

$results = array();

if (isset($orders)) {
    foreach ($orders as $order) {
        
        //print_r($orders);

        if ($order->getIsConfirmed() == 0 && $order->getOrderStatusId() == 1) {

        } else {

            $row['number'] = link_to($order->getNumber(), '@stOrderListShowForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode());


            $created_at = explode(" ", $order->getCreatedAt());
            $date = explode("-", $created_at[0]);

            $row['created_at'] = $date[2] . "-" . $date[1] . "-" . $date[0];

            $row['status'] = st_order_status($order->getOrderStatus());

            $row['total_amount'] = st_order_total_amount($order);

            $row['is_paid'] = $order->getIsPayed() ? "<span class='green'>" . __('tak') . "</span>" : "<span class=''>" . __('nie') . "</span>";

            if ($order->getIsConfirmed() == 1) {

                $row['is_confirmed'] = "<span class='green'>" . __('tak') . "</span>";

                $row['is_confirmed_orders'] = 1;

                $smarty->assign('confirmed_orders', 1);

            } else {

                $row['is_confirmed'] = link_to(__('potwierdź'), '@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode() . '&register=0' . '&cancel=0', array("class" => "green")) . " / " . link_to(__('anuluj'), '@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode() . '&register=0' . '&cancel=1', array("class" => "red"));

                $row['is_confirmed_orders'] = 0;

                $smarty->assign('unconfirmed_orders', 1);

            }

            $row['review'] = st_get_component('stReview', 'addReviewList', array('order' => $order, 'smarty' => $smarty, 'results' => $results));

            $row['invoice'] = st_get_component('stInvoicePdf', 'orderInvoice', array('order' => $order));

            $results[] = $row;

        }

    }
}

$smarty->assign('results', $results);


if (isset($lastOrder) && $lastOrder) {

    $smarty->assign('last_order', $lastOrder);
    $smarty->assign('last_order_order_number', $lastOrder->getNumber());
    $smarty->assign('last_order_status', st_order_status($lastOrder->getOrderStatus()));
    $created_at = explode(" ", $lastOrder->getCreatedAt());
    $date = explode("-", $created_at[0]);
    $smarty->assign('last_order_created_at', $date[2] . "-" . $date[1] . "-" . $date[0] . " " . $created_at[1]);

    $results = array();

    foreach ($lastOrder->getOrderProducts() as $order_product) {
        $row['code'] = $order_product->getCode();

        $row['validate'] = $order_product->productValidate();

        if ($row['validate']) {
            $row['photo'] = st_link_to(st_product_image_tag($order_product, 'thumb'), 'stProduct/show?url=' . $order_product->getProduct()->getFriendlyUrl());
        } else {
            $row['photo'] = st_product_image_tag(null, 'thumb');
        }

        if ($order_product->productValidate()) {
            $row['name_show'] = st_link_to($order_product->getName(), 'stProduct/show?url=' . $order_product->getProduct()->getFriendlyUrl());
        } else {
            $row['name_show'] = $order_product->getName();
        }

        if ($order_product->hasPriceModifiers()) {
            $row['name_show'] = content_tag('div', $row['name_show'], array('class' => 'st_product_name_with_options')) . st_product_options_get_view($order_product);
        }

        $row['price'] = st_order_price_format($order_product->getPriceNetto(true), $currency);

        $row['vat'] = $order_product->getVat();

        $row['price_true'] = st_order_price_format($order_product->getPriceBrutto(true), $currency);

        if ($order_product->getPointsValue() * $order_product->getQuantity() == 0) {
            $row['points_value'] = "";
            $row['points_sum_value'] = "";
        } else {
            $row['points_value'] = $order_product->getPointsValue();
            $row['points_sum_value'] = $order_product->getPointsValue() * $order_product->getQuantity();
        }

        $row['is_item_by_points'] = $order_product->getProductForPoints();

        if ($order_product->getProductForPoints()) {
            $points_value += $order_product->getPointsValue() * $order_product->getQuantity();
        }

        $row['quantity'] = $order_product->getQuantity();

        $row['uom'] = st_product_uom($order_product->getProduct());

        $total_amount = $order_product->getTotalAmount(true, true);

        $row['total_amount'] = st_order_price_format($total_amount, $currency);

        $results[] = $row;
    }

    $smarty->assign('results', $results);

    $smarty->assign('last_order_total_product_price', st_order_product_total_amount($lastOrder));

    $smarty->assign('last_order_delivery_number', $lastOrder->getOrderDelivery()->getNumber());

    $smarty->assign('last_order_delivery_name', $lastOrder->getOrderDelivery()->getName());

    $smarty->assign('last_order_delivery_cost', st_order_price($lastOrder->getOrderDelivery()->getCost(true), $currency));

    $smarty->assign('last_order_total_amount', st_order_total_amount($lastOrder));

    if ($lastOrder->getOrderPayment() && $lastOrder->getOrderPayment()->getPaymentType()) {
        $smarty->assign('payment_name', $lastOrder->getOrderPayment()->getPaymentType()->getName());
    }

    $smarty->assign('is_paid', $lastOrder->getIsPayed() ? __('tak') : __('nie'));

}

$smarty->display('userdata_user_panel.html');