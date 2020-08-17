<?php
/**
 * SOTESHOP/stBasket
 *
 * Ten plik należy do aplikacji stBasket opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBasket
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stBasketHelper.php 17022 2012-02-08 13:04:02Z marcin $
 */

use_helper('stProductImage', 'stCurrency', 'stProductOptions', 'stTheme');
use_javascript('stPrice.js');

/**
 * Zwraca HTML zawierający listę produktów w postaci zdjęć
 *
 * @param      stBasket    $basket
 * @return       string      HTML
 */
function st_basket_order_product_list(stBasket $basket, $header = '')
{
    $content = '';

    $basket_products = $basket->getItems();

    if ($basket_products)
    {
        foreach ($basket_products as $basket_product)
        {
            $basket_product->productValidate();
            $content .= content_tag('li', st_product_image_tag($basket_product, 'icon'));
        }

        $content = content_tag('ul', $content) . content_tag('p', __('Kwota:') . content_tag('strong', st_basket_total_amount($basket, true)));

        return content_tag('p', $header) . content_tag('div', $content, 'class=st_basket-list-order-product');
    }
    else
    {
        return $header;
    }
}

/**
 * Zwraca js dla pokazywania przycisków +/- danego produktu w koszyku
 *
 * @param   BasketProduct $product          Product koszyka
 * @return       string      js
 */
function st_basket_js_num_buttons_show($product)
{
    $product_id = $product->getItemId();

    $js = "jQuery('#st_basket-product-num-button-plus-$product_id').css({visibility: 'visible'});";
    $js .= "jQuery('#st_basket-product-num-button-minus-$product_id').css({visibility: 'visible'})";

    return $js;
}

/**
 * Zwraca js dla ukrywania przycisków +/- danego produktu w koszyku
 *
 * @param   BasketProduct $product          Product koszyka
 * @return       string      js
 */
function st_basket_js_num_buttons_hide($product)
{
    $product_id = $product->getItemId();

    $js = "jQuery('#st_basket-product-num-button-plus-$product_id').css({visibility: 'hidden'});";
    $js .= "jQuery('#st_basket-product-num-button-minus-$product_id').css({visibility: 'hidden'})";

    return $js;
}

/**
 * Zwraca sformatowaną całkowitą kwotę koszyka
 *
 * @param stBasket $basket Koszyk
 * @param bool $with_tax Uwzględnij VAT
 * @return float Całkowita kwota koszyka
 */
function st_basket_total_amount(stBasket $basket, $with_tax = false)
{
    return st_currency_format($basket->getTotalAmount($with_tax, true));
}

function st_basket_product_options($namespace, Product $product, $selected_options = array())
{
    if ($product->getOptHasOptions() <= 1)
    {
        return null;
    }

    st_theme_use_stylesheet('stProductOptionsPlugin.css');

    $url = st_url_for('@stProductOptionsFrontend?action=ajaxNewUpdateProduct&product_id='.$product->getId());

    $id = $product->getId();

    $js =<<< JS
<script type="text/javascript">
//<![CDATA[
function change_color(field, option_id) {
    jQuery('#'+field).val(option_id);
}
jQuery(function($) {   
    var options = $('.st_product_options_select');

    options.change(function() {
        
        var form = $(this.form);

        var basket_form = $('#{$namespace}_$id');

        if (basket_form.length) {
            basket_form.find('[type=submit]').attr('disabled', true);
        }

        parameters = form.serializeArray();

        options.attr('disabled', true);

        parameters.push({ name: "namespace", value: "$namespace" });

        parameters.push({ name: "change_field", value: $(this).attr('id').replace('st_product_options_', '') });

        var doc = $(document);

        doc.trigger('beforeOptionsChange');

        $.post("$url", parameters, function() {
            options.removeAttr('disabled');   
            doc.trigger('afterOptionsChange');         
        });
    });
});
//]]>
</script>
JS;

    return st_product_options_get_form($product, $selected_options ? $selected_options : stNewProductOptions::getSelectedOptions($product)).$js;
}

function st_basket_add_quantity($namespace, Product $product, $options = array())
{
    static $loaded = false;

    if ($product->getConfiguration()->get('show_basket_quantity') && !stBasket::isHidden($product))
    {  
        if (!$loaded)
        {
            sfLoader::loadHelpers(array('stProduct'), 'stProduct');

            $loaded = true;
        }   
            
        $version = stTheme::getInstance(sfContext::getInstance())->getVersion();

        $name = $namespace.'['.$product->getId().'][quantity]';

        $label = isset($options['label']) ? label_for($name, __($options['label'], null, 'stBasket')) : '';

        $uom = st_product_uom($product);

        if ($product->getStepQty())
        {
            return $label.st_product_quantity_list($name, $product, $product->getMinQty(), array('class' => 'basket_add_quantity form-control')).'<span class="uom">'.$uom.'</span>';            
        }
        else
        {     
            return $label.input_tag($name, stPrice::round($product->getMinQty(), $product->getStockInDecimals()), array(
                'class' => $version < 7  ? 'basket_add_quantity' : 'basket_add_quantity form-control',
                'size' => isset($options['size']) ? $options['size'] : 3, 
                'maxlength' => 5,
                'data-max' => $product->getStock(),
                'data-min' => $product->getMinQty(),
                'onchange' => 'this.value = stPrice.fixNumberFormat(this.value, '.$product->getStockInDecimals().');'
            )).'<span class="uom">'.$uom.'</span>';  
        }  
    }

    return '';
}

function st_basket_url(Product $product)
{
    return st_secure_url_for('@stBasketAdd?product_id='.$product->getId().'&quantity='.$product->getMinQty());
}

function st_basket_add_link($namespace, Product $product, $options = array())
{
    static $js_ajax_attached = false;
    static $js_attached = false;

    if (stBasket::isHidden($product))
    {
        return '';
    }

    $important = isset($options['important']) ? ' important' : '';

    $arrow = isset($options['arrow']) ? 'arrow_'.$options['arrow'] : '';

    $has_options = $product->getOptHasOptions() > 1;

    $url = $has_options ? st_url_for('stProduct/show?url='.$product->getUrl()) : st_basket_url($product);

    if (stTheme::getInstance(sfContext::getInstance())->getVersion() < 7)
    {  
        if ($has_options)
        {
            $url = st_url_for('stProduct/show?url='.$product->getUrl());

            $label = __(isset($options['basket_label']) ? $options['basket_label'] : 'wybierz opcje produktu', null, 'stProductOptionsFrontend');

            return '<a rel="nofollow" href="'.$url.'">'.$label.'</a>';  
        }
        else
        {
            $url = st_basket_url($product);

            $label = __(isset($options['options_label']) ? $options['options_label'] : 'dodaj do koszyka', null, 'stBasket');  
        }  

        if (stBasket::isEnabled($product))
        {
            $content = '<a rel="nofollow" id="'.$namespace.'_'.$product->getId().'" class="roundies basket_add_link'.$important.'" href="'.$url.'"><span class="'.$arrow.'">'.$label.'</span></a>';
        }   
        else
        {
            $content = '<a rel="nofollow" id="'.$namespace.'_'.$product->getId().'" class="roundies basket_add_link basket_disabled'.$important.'" href="'.$url.'"><span class="'.$arrow.'">'.$label.'</span></a>';
        }  
    } 
    else 
    {
        if ($has_options)
        {
            $url = st_url_for('stProduct/show?url='.$product->getUrl());

            $label = __(isset($options['options_label']) ? $options['options_label'] : 'Wybierz opcje produktu', null, 'stProductOptionsFrontend');

            return '<a rel="nofollow" class="btn btn-shopping-cart" href="'.$url.'">'.$label.'</a>';  
        }
        else
        {
            $url = st_basket_url($product);

            $label = __(isset($options['label']) ? $options['label'] : 'Do koszyka', null, 'stBasket');  
        }  

        if (stBasket::isEnabled($product))
        {
            $content = '<a rel="nofollow" id="'.$namespace.'_'.$product->getId().'" class="btn btn-shopping-cart basket_add_link" href="'.$url.'">'.$label.'</a>';
        }   
        else
        {
            $content = '<div class="relative btn-disable"><a rel="nofollow" id="'.$namespace.'_'.$product->getId().'" class="btn btn-shopping-cart basket_add_link disabled" href="'.$url.'">'.$label.'</a><span class="disabled-info btn btn-shopping-cart">'.__('Niedostępny', null, 'stBasket').'</span></div>';
        }          
    }

    if (!$js_ajax_attached && stConfig::getInstance('stBasket')->get('ajax'))
    {
        $js_ajax_attached = true;
        
        return $content.init_ajax_basket('.basket_add_link', 'click', null);
    }

    if (!$js_attached && !stConfig::getInstance('stBasket')->get('ajax'))
    {
        $js_attached = true;
        
        return $content.get_init_basket('.basket_add_link', 'click', null); 
    }

    return $content;
}

function st_basket_add_button($namespace, Product $product, $options = array())
{
    if (stBasket::isHidden($product))
    {
        return '';
    }    

    $url = st_basket_url($product);

    $product_options = '';

    if (isset($options['product_set_discount']))
    {
        $product_set_discount = $options['product_set_discount'];
    }

    if (isset($options['options']))
    {
        $product_options = implode('-', $options['options']);
    }
    elseif ($product->getOptHasOptions())
    {
        $product_options = implode('-', stNewProductOptions::getSelectedOptions($product));
    }

    $label = __(isset($options['label']) ? $options['label'] : 'dodaj do koszyka', null, 'stBasket');

    $important = isset($options['important']) ? ' important' : '';

    $arrow = isset($options['arrow']) ? 'arrow_'.$options['arrow'] : '';

    $id = $product->getId();

    if (stTheme::getInstance(sfContext::getInstance())->getVersion() < 7)
    {
        if (stBasket::isEnabled($product))
        {
            $button = '<button class="roundies'.$important.'" type="submit"><span class="'.$arrow.'">'.$label.'</span></button>';
        }
        else
        {
            $button = '<button class="roundies'.$important.'" type="submit" disabled="disabled"><span class="'.$arrow.'">'.$label.'</span></button>';
        }
    }
    else
    {
        if (stBasket::isEnabled($product))
        {
            $button = '<button class="btn btn-shopping-cart" type="submit">'.$label.'</button>';
        }
        else
        {
            $button = '<div class="relative btn-disable"><button class="btn btn-shopping-cart" type="submit" disabled="disabled">'.$label.'</button><span class="disabled-info btn btn-shopping-cart">'.__('Niedostępny', null, 'stBasket').'</span></div>';
        }        
    }

    $content =<<< HTML
    <form data-product="$id" id="{$namespace}_$id" class="basket_add_button" action="$url" method="post">
        <div>
            <input type="hidden" name="product_set_discount" value="$product_set_discount" />
            <input type="hidden" name="option_list" value="$product_options" />
            $button
        </div>
    </form>
HTML;

   
    if (stConfig::getInstance('stBasket')->get('ajax'))
    {
        return $content.get_init_ajax_basket("#{$namespace}_$id", 'submit', null);
    }
    else
    {
        return $content.get_init_basket("#{$namespace}_$id", 'submit', null);
    }
}

function get_init_basket($css_selector, $on = 'click', $css_quantity_selector = '#quantity')
{
   if (null === $css_quantity_selector)
   {
      $css_quantity_selector = '';
   }

   $js =<<<JS
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
   $(document).ready(function() {
      $("body").on("$on", "$css_selector", function(event) {
         var quantity_selector = '$css_quantity_selector';
         var url = '';
         var parameters = {};

         if (event.type == 'submit') {
            var form = $(this);

            if (!quantity_selector) { 
               quantity_selector = '#' + form.attr('id') + '_quantity';
            } 
            
            var url = form.attr('action');

         } else if (event.type == 'click') {
            var link = $(this);

            if (link.hasClass('basket_disabled')) {
                return false;
            }

            if (!quantity_selector) { 
               quantity_selector = '#' + link.attr('id') + '_quantity';
            } 

            var url = link.attr('href');
         }

         var quantity = $(quantity_selector);

         if (quantity.length) {
            if (quantity.val() == 0) {
               quantity.val(quantity.get(0).defaultValue);
            }

            var url_params = url.split('/');
            url_params[url_params.length-1] = quantity.val();
            url = url_params.join('/');
         }   

         if (event.type == 'submit') {
            form.attr('action', url);
         } else {
            link.attr('href', url); 
         }
                     
      });
   });
});
//]]>
</script>    
JS;

   return $js;   
}

function get_init_ajax_basket($css_selector, $on = 'click', $css_quantity_selector = '#quantity')
{
   $js =<<<JS
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
   $(document).ready(function() {
      
      $("body").on("$on", "$css_selector", function(event) {
         var quantity_selector = '$css_quantity_selector';
         var url = '';
         var parameters = [];

         if (event.type == 'submit') {
            var form = $(this);

            url = form.attr('action');

            if (!quantity_selector) { 
               quantity_selector = '#' + form.attr('id') + '_quantity';
            } 
         
            parameters = form.serializeArray();

         } else if (event.type == 'click') {
            var link = $(this);

            if (link.hasClass('basket_disabled')) {
                event.stopImmediatePropagation();
                return false;
            }

            url = link.attr('href');

            if (!quantity_selector) { 
               quantity_selector = '#' + link.attr('id') + '_quantity';
            }           
         }

         var quantity = $(quantity_selector); 

         if (quantity.length && quantity.val() == 0) {
               quantity.val(quantity.get(0).defaultValue);
         }          

         if (quantity.length) {
            parameters.push({ name: "quantity", value: quantity.val() });
         }         

         if (window.location.protocol != 'https:') {
            url = url.replace('https://', 'http://'); 
         }

         var body = $('body').css({ cursor: 'wait' });
         var div = $('<div></div>');
         div.css({ 'height': body.height(), 'width': body.width(), position: 'absolute', 'z-index': 10000, background: 'transparent', cursor: 'wait' });
         body.prepend(div);

         $.post(url, parameters, function(html) {
            var html = $(html);
            $('body').append(html);
            div.remove();
            body.css({ cursor: 'auto' });
         }, 'html');
         event.preventDefault();
         event.stopImmediatePropagation();
      });
   });
});
//]]>
</script>    
JS;

   return $js;
}

function init_ajax_basket($css_selector, $on = 'click', $quantity_selector = '#quantity')
{
    echo get_init_ajax_basket($css_selector, $on, $quantity_selector); 
}

?>