<?php
/**
 * SOTESHOP/stProductOptionsPlugin
 *
 * Ten plik należy do aplikacji stProductOptionsPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProductOptionsPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 16886 2012-01-27 10:43:53Z piotr $
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

/**
 * Akcje modułu stProductOptionsTemplateFrontend
 *
 * @package stProductOptionsPlugin
 * @subpackage stProductOptionsFrontend
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 */

class stProductOptionsFrontendActions extends stActions
{
    public function executeChangeOptionFromGallery()
    {
        $product_id = $this->getRequestParameter('product_id');
        $image_id = $this->getRequestParameter('image_id');
        $options = $this->getRequestParameter('st_product_options', array());

        $this->product = ProductPeer::retrieveByPK($product_id);

        if (null === $this->product)
        {
            return sfView::HEADER_ONLY;
        }

        $c = new Criteria();

        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product_id);

        $c->add(ProductOptionsValuePeer::SF_ASSET_ID, $image_id);

        if (ProductOptionsValuePeer::doCount($c) > 0)
        {
            if ($options)
            {
                $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, array_keys($options), Criteria::IN);
            }

            $config = stConfig::getInstance('stProduct');

            if ($config->get('hide_options_with_empty_stock') && $this->product->getStockManagment() == ProductPeer::STOCK_PRODUCT_OPTIONS)
            {
               $c->add(ProductOptionsValuePeer::STOCK, sprintf('(%1$s IS NULL OR %1$s > 0)', ProductOptionsValuePeer::STOCK), Criteria::CUSTOM);
            }

            $c->addDescendingOrderByColumn(ProductOptionsValuePeer::DEPTH);

            $c->add(ProductOptionsValuePeer::LFT, ProductOptionsValuePeer::RGT.' - '.ProductOptionsValuePeer::LFT.' = 1', Criteria::CUSTOM);

            $option = ProductOptionsValuePeer::doSelectOne($c);

            if (null === $option)
            {
                $c->remove(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID);

                $c->remove(ProductOptionsValuePeer::LFT);

                $option = ProductOptionsValuePeer::doSelectOne($c);
            }

            if ($option)
            {
                $options = array();

                $c = new Criteria();

                foreach ($option->getPath() as $o)
                {
                    if (!$o->isRoot())
                    {
                       $options[$o->getProductOptionsFieldId()] = $o->getId();
                    }
                }

                $options[$option->getProductOptionsFieldId()] = $option->getId();

                $this->getRequest()->setParameter('st_product_options', $options);

                $this->getRequest()->setParameter('change_field', $option->getProductOptionsFieldId());
            }
        }

        return $this->executeAjaxNewUpdateProduct();
    }


    public function executeUpdateProductOptions()
    {
        $tmp = json_decode($this->getRequestParameter('json'));
        $this->fields = $tmp->new_form;
        $this->smarty = new stSmarty('stProductOptionsFrontend');
    }

    public function executeAjaxNewUpdateProduct()
    {
        $product = ProductPeer::retrieveByPK($this->getRequestParameter('product_id'));

        if (null === $product)
        {
            return $this->forward404();
        }

        $this->product = $product;

        $options = $this->getRequestParameter('st_product_options', array());

        $selected_field = $this->getRequestParameter('change_field');

        $selected_ids = array();

        foreach ($options as $field_id => $option_id)
        {
            $selected_ids[$field_id] = $option_id;

            if ($field_id == $selected_field)
            {
                break;
            }
        }

        $selected_values = array();

        $index = 0;

        foreach ($options as $id)
        {
            $option = ProductOptionsValuePeer::retrieveByPK($id);
            
            if ($option)
            {
                $selected_values[$index][trim($option->getOptValue())] = true;
            }

            $index++;
        }

        sfLoader::loadHelpers(array('Helper','stCurrency', 'stUrl', 'stProductImage', 'stProduct'), 'stProduct');

        $selected_options = $selected_ids ? stNewProductOptions::updateProduct($product, $selected_ids, $selected_values) : array();

        if ($this->hasRequestParameter('image_id'))
        {
            stNewProductOptions::updateProductImage($product, $this->getRequestParameter('image_id'));

            if ($product->getDefaultAssetImage())
            {
                $product->getDefaultAssetImage()->setCulture($this->getUser()->getCulture());
            }
        }

        $smarty = new stSmarty('stBasket');

        if ($this->getController()->getTheme()->getVersion() < 3)
        {
            $this->responseUpdateElement('st_product_options-modify-basket', array(
                    'module' => 'stProductOptionsFrontend',
                    'component' => 'modifyBasketView',
                    'params' => array(
                            'product' => $product,
                            'selected_options' => $selected_options,
                            'smarty' => $smarty,
                            'info' => true)), false);
        }
        else
        {
            $namespace = $this->getRequestParameter('namespace');

            sfLoader::loadHelpers(array('stBasket'));

            $this->responseUpdateElement('basket_product_options_container', st_basket_product_options($namespace, $product, $selected_options));

            $basket_form_id = $namespace.'_'.$product->getId();

            $this->responseEvalJs('jQuery("#'.$basket_form_id.' input[name=option_list]").val("'.implode('-', $selected_options).'")');

            if (stBasket::isEnabled($product))
            {
                $this->responseEvalJs('jQuery(\'#'.$basket_form_id.'\').find(\'input, button\').removeAttr(\'disabled\')');
            }
        }

        $this->responseUpdateElement('#product_set_discounts', array(
            'module' => 'stDiscountFrontend',
            'component' => 'discountProductSetList',
            'params' => array('product' => $product)
        ));

        $this->responseUpdateElement('.product_code', $product->getCode());

        $this->responseUpdateElement('.product_man_code', $product->getManCode());

        if(stTheme::is_responsive()){

            if ($product->getManCode())
            {
                $this->responseEvalJs("$('.product_man_code').closest('.product_man_code_container').removeClass('hidden')");
            }
            else
            {
                $this->responseEvalJs("$('.product_man_code').closest('.product_man_code_container').addClass('hidden')");
            }

        }

        $this->responseUpdateElement('#st_depository_stock_amount-value', $product->getStock());

        $this->responseUpdateElement('#st_depository_stock_amount .stock', $product->getStock());

        $this->responseUpdateElement('#product-weight', $product->getWeight());

        $this->responseUpdateElement('#st_availability_info', array(
                'module' => 'stAvailabilityFrontend',
                'component' => 'availability',
                'params' => array('product' => $product, 'check_xml' => true)
                    ),false);

        $this->responseUpdateElement('#question-container', array(
            'module' => 'stQuestionFrontend',
            'component' => 'showQuestion',
            'params' => array('product' => $product, 'is_ajax' => true)
        ));

        $old_price_brutto = $product->getOldPriceBrutto(true) > 0 ? st_currency_format($product->getOldPriceBrutto(true)) : '';
        $old_price_netto = $product->getOldPriceNetto(true) > 0 ? st_currency_format($product->getOldPriceNetto(true)) : '';

        $this->responseUpdateElement('#st_product_options-old_price', $old_price_brutto);

        $this->responseUpdateElement('#st_product_options-old_price_net', $old_price_netto);

        if ($product->getConfiguration()->get('price_view') == 'only_gross' || $product->getConfiguration()->get('price_view') == 'gross_net')
        {
            $this->responseUpdateElement('.prices .old_price', $old_price_brutto);
        }
        else
        {
            $this->responseUpdateElement('.prices .old_price', $old_price_netto);
        }

        $this->responseUpdateElement('#st_product_options-price-netto', st_currency_format($product->getPriceNetto(true)));

        $price_brutto = st_currency_format($product->getPriceBrutto(true));

$price_brutto_js =<<<PRICE_BRUTTO_JS
jQuery(function($) {
    var price = '$price_brutto';
    var container = $('#st_product_options-price-brutto');

    if (container.length) {
        if (container.html().indexOf('*') !== -1) {
            container.html(price+'*');
        } else {
            container.html(price);
        }
    }
});
PRICE_BRUTTO_JS;

        $this->responseEvalJs($price_brutto_js);

        if ($product->getConfiguration()->get('show_basic_price') && $product->hasBasicPrice())
        {
            $this->responseUpdateElement('#basic-price-netto', st_currency_format($product->getBasicPriceNetto(true)));
            $this->responseUpdateElement('#basic-price-brutto', st_currency_format($product->getBasicPriceBrutto(true)));
            $this->responseUpdateElement('#basic-price-quantity', st_product_basic_price_quantity($product));
            $this->responseUpdateElement('#basic-price-for-quantity', st_product_basic_price_for_quantity($product));
        }

        if ($product->hasDiscount())
        {
            $this->responseUpdateElement('#st_product_options-discount-netto', st_currency_format($product->getDiscountNetto(true)));

            $this->responseUpdateElement('#st_product_options-discount-brutto', st_currency_format($product->getDiscountBrutto(true)));

            $this->responseUpdateElement('#st_product_options-catalogue-netto', st_currency_format($product->getPriceNetto(true, false)));

            $this->responseUpdateElement('#st_product_options-catalogue-brutto', st_currency_format($product->getPriceBrutto(true, false)));
        }

        $product_image_url = st_product_image_path($product, 'large');

        $product_image_url_large = st_product_image_path($product, 'big');

        $product_image_url_thumb = st_product_image_path($product, 'gallery');

        $product_image_large_description = str_replace(array("\r\n", "\n"), '', trim($product->getOptImageDescription()));

        $product_image_large_description = addslashes(htmlspecialchars($product_image_large_description, ENT_QUOTES, 'UTF-8'));

        if ($this->getController()->getTheme()->getVersion() < 7)
        {
$image_js =<<<IMG_JS
jQuery(function($) {
    $('#st_product-default-image').attr('src', '$product_image_url');

    $('#st_product-default-image-link')
        .attr('href', '$product_image_url_large')
        .attr('title', '$product_image_large_description');
});
IMG_JS;

            $this->responseEvalJs($image_js);

            if ($this->getController()->getTheme()->getVersion() >= 2)
            {
$js =<<<JS
jQuery(function($) {
    var link = $('#st_product-default-image-link');
    if (link.length) {
        link.removeData('jqzoom');
        link.jqzoom({
            zoomType: 'innerzoom',
            lens:true,
            preloadImages: true,
            zoomWidth: 260,
            zoomHeight: 260,
            showEffect : 'fadein',
            hideEffect: 'fadeout'
        });
    }
});
JS;
                $this->responseEvalJs($js);
            }
        }
        else
        {
            $image_id = $product->getDefaultAssetImage() ? $product->getDefaultAssetImage()->getId() : 0;
            $this->addResponseSetResponsiveImage($image_id, $product_image_url, $product_image_url_large, $product_image_url_thumb, $product_image_large_description);
        }

        $ret = $this->renderResponse();

        if (!$ret)
        {
            $this->getResponse()->setStatusCode(404);
            return sfView::HEADER_ONLY;
        }

        return $ret;
    }

    public function addResponseSetResponsiveImage($image_id, $product_image_url, $product_image_url_large, $product_image_url_thumb, $product_image_large_description)
    {
        $name = addslashes($this->product->getName());
        $product_image_large_description = addslashes($product_image_large_description);
$js =<<<JS
jQuery(function($) {
    var current = $('#product-photo');
    var currentImg = current.find('img');
    var replace = $('#product-gallery li[data-id='+$image_id+']');

    if (replace.length) {
        replace.attr('data-src', current.attr('data-src'));
        replace.data('src', current.data('src'));
        replace.attr('data-id', current.data('id'));
        replace.data('id', current.data('id'));
        replace.attr('data-desc', current.attr('data-desc'));
        replace.attr('data-sub-html', current.attr('data-sub-html'));
        replace.find('img')
            .attr('src', current.data('gallery') ? current.data('gallery') : currentImg.attr('src'))
            .attr('title', $(current.attr('data-sub-html')).find('p').text());
    }

    current.attr('data-id', $image_id);
    current.data('id', $image_id);
    current.attr('data-src', '$product_image_url_large');
    current.attr('data-sub-html', '<div class="custom-html"><h4>$name</h4><p>$product_image_large_description</p></div>');
    current.attr('data-desc', '$product_image_large_description');
    current.find('img').attr('title', '$product_image_large_description');
    current.data('gallery', '$product_image_url_thumb');

    current.data('src', '$product_image_url_large');
    currentImg.attr('src', '$product_image_url');
    $(window).resize();
});
JS;
            $this->responseEvalJs($js);
    }

}
