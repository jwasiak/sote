<?php

function st_paypal_checkout_express_add_link($namespace, Product $product) {
    $config = stConfig::getInstance('stPaypal');
    if ($config->get('express') && $config->get('configuration_verified')) {
        $context = sfContext::getInstance();

        st_theme_use_stylesheet('stPaypal.css');

        if ($message = $context->getUser()->getAttribute('express_checkout_error', null, 'stPaypal')) {
            $context->getUser()->setAttribute('express_checkout_error', null, 'stPaypal');

            $errorContent = <<<ERROR
            <div id="paypal_express_checkout_error">
                {$message}.
            </div>
ERROR;
        }

        if ($product->getPriceBrutto() <= 0 || !stBasket::isEnabled($product) || stBasket::isHidden($product)) {
            $context->getUser()->setAttribute('express_checkout_error', null, 'stPaypal');
            if (!empty($message))
                return $errorContent;
            else 
                return false;
        }

        $id = $product->getId();
        $url = st_url_for('@stPaypalBuyProduct?product_id='.$id);
        $image_url = 'https://www.paypal.com/' . stPaypal::getButtonLocaleByCulture($context->getUser()->getCulture()).'/i/btn/btn_xpressCheckout.gif';
        $image_alt = __('Zapłać w systemie PayPal', null, 'stPaypalFrontend');

        $content =<<< HTML
        <div id="paypal_express_checkout">
            <a id="{$namespace}_{$id}_paypal_checkout_express" href="$url">
                <img src="$image_url" alt="$image_alt" />
            </a>
        </div>
        <script type="text/javascript">    
        //<![CDATA[
        jQuery(function($) {
            $('#{$namespace}_{$id}_paypal_checkout_express').click(function() {
                var quantity = $('#{$namespace}_{$id}_quantity'); 

                if (quantity.length && quantity.val() == 0) {
                    quantity.val(quantity.get(0).defaultValue);
                }          

                var quantity_value = quantity.length ? quantity.val() : {$product->getMinQty()};

                var serialized = $('#{$namespace}_$id').serialize(); 

                if (!serialized && $("#st_update_product_options_form").length > 0) {
                    serialized = 'option_list='+$.map($('#st_update_product_options_form').serializeArray(), function(option) { return option.value;}).join('-');
                }
              
                if (serialized) {
                    serialized += '&quantity='+quantity_value;
                } else {
                    serialized += 'quantity='+quantity_value;
                }
                var link = $(this);
                var href = link.attr('href')+'?'+serialized;
                link.attr('href', href); 
            });
        });
        //]]>
        </script>
HTML;
        return $errorContent.$content;
    }

    return false;
}