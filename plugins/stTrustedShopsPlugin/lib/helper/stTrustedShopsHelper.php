<?php

function backend_buyer_protection_register_url() {
    $url = 'http://www.trustedshops.com/merchants/membership.html';
    if (sfContext::getInstance()->getUser()->getCulture() == 'pl_PL') $url = 'https://checkout.trustedshops.com/?registeredOffice=pl-PL';
    return $url;
}

function rating_widget_url($certificate) {
    return 'https://www.trustedshops.com/bewertung/widget/widgets/'.$certificate.'.gif';
}

function st_trusted_shops_backend_integration_url($certificate) {
    $language = (sfContext::getInstance()->getUser()->getCulture() == 'pl_PL') ? 'pl' : 'en';

    $packages = stPear::getInstalledPackages();

    $shopVersion = $packages['soteshop_base'];

    if (stCommunication::getIsSeven()) {
        list(, $y, $z) = explode('.', $shopVersion, 3);
        $shopVersion = '7.'.($y-3).'.'.$z;
    }  

    $pluginVersion = $packages['stTrustedShopsPlugin'];

    return 'https://www.trustedshops.com/integration/?shop_id='.$certificate->getCertificate().'&backend_language='.$language.'&shopsw=SOTE&shopsw_version='.$shopVersion.'&plugin_version='.$pluginVersion.'&context=trustbadge';
}
