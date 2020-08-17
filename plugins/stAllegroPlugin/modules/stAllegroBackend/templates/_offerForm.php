<?php use_helper('stAdminGenerator', 'stAllegro', 'stAllegroParameter', 'stAllegroDelivery', 'stPartial');?>

<fieldset>
    <h2><?php echo __('Format sprzedaży') ?></h2>
    <div class="content">
        <?php echo st_admin_get_form_field('offer[selling_mode][price][amount]', __("Cena"), $offer->sellingMode->price ? $offer->sellingMode->price->amount : 0, 'input_tag', array(
            'class' => 'number-type update-pricing-fee-preview', 
            'required' => true,
            'size' => 10, 
            'data-precision' => 2, 
            'data-min' => 0, 
            'data-max' => 10000000, 
            'postfix' => $offer->sellingMode->price ? $offer->sellingMode->price->currency : 'PLN'
        )) ?>
        <?php echo input_hidden_tag('offer[selling_mode][price][currency]', isset($offer->sellingMode) && $offer->sellingMode->price ? $offer->sellingMode->price->currency : 'PLN'); ?>
        <?php echo st_admin_get_form_field('offer[stock]', __("Ilość"), $offer->stock, '_edit_stock', array('maxlength' => 50, 'size' => 60, 'required' => true, 'product' => $product)) ?>
        <?php echo st_admin_get_form_field('offer[publication][duration]', __("Czas trwania"), isset($offer->publication) ? $offer->publication->duration : null, 'st_allegro_duration_time_select_tag', array('required' => true, 'disabled' => isset($offer->publication) && $offer->publication->status != 'INACTIVE')) ?>
    </div>
</fieldset>
<fieldset>
    <h2><?php echo __('Dostawa i płatność') ?></h2>
    <div class="content">
        <?php echo st_admin_get_form_field('offer[delivery][shipping_rates][id]', __("Cennik dostawy"), isset($offer->delivery) && $offer->delivery->shippingRates ? $offer->delivery->shippingRates->id : null, 'st_allegro_shippin_rates_select_tag', array('required' => true)) ?>
        <?php echo st_admin_get_form_field('offer[delivery][handling_time]', __("Czas wysyłki"), isset($offer->delivery) ? $offer->delivery->handlingTime : null, 'st_allegro_delivery_times_select_tag', array('required' => true)) ?>
        <?php echo st_admin_get_form_field('offer[payments][invoice]', __("Opcje faktury"), isset($offer->payments) ? $offer->payments->invoice : null, 'st_allegro_payments_invoice_select_tag', array('required' => true)) ?>
    </div>
</fieldset>
<fieldset>
    <h2><?php echo __('Zdjęcia') ?></h2>
    <div class="content">
        <div class="row">
            <?php echo st_get_partial('stAllegroBackend/offer_images', array('images' => isset($offer->images) ? $offer->images : array(), 'product' => $product, 'name' => 'offer[images]')) ?>
        </div>
    </div>                
</fieldset>
<fieldset>
    <h2><?php echo __('Opis') ?></h2>
    <div class="content">
        <?php echo st_get_partial('stAllegroBackend/description', array('value' => $offer->description->sections, 'name' => 'offer[description]')) ?>
    </div>
</fieldset>
<fieldset>
    <h2><?php echo __('Cechy przedmiotu') ?></h2>
    <div class="content">
        <?php echo st_get_component('stAllegroBackend', 'categoryParameters', array('offer' => $offer, 'name' => 'offer[parameters]', 'product' => $product)) ?>
    </div>
</fieldset>
<fieldset>
    <h2><?php echo __('Warunki oferty') ?></h2>
    <div class="content">
        <?php echo st_admin_get_form_field('offer[after_sales_services][return_policy][id]', __("Warunki zwrotów"), isset($offer->afterSalesServices) && $offer->afterSalesServices->returnPolicy ? $offer->afterSalesServices->returnPolicy->id : null, 'st_allegro_return_policy_select_tag') ?>
        <?php echo st_admin_get_form_field('offer[after_sales_services][implied_warranty][id]', __("Reklamacje"), isset($offer->afterSalesServices) && $offer->afterSalesServices->impliedWarranty ? $offer->afterSalesServices->impliedWarranty->id : null, 'st_allegro_implied_warranty_select_tag') ?>
        <?php echo st_admin_get_form_field('offer[after_sales_services][warranty][id]', __("Gwarancje"), isset($offer->afterSalesServices) && $offer->afterSalesServices->warranty ? $offer->afterSalesServices->warranty->id : null, 'st_allegro_warranty_select_tag') ?>
    </div>
</fieldset>
<fieldset>
    <h2><?php echo __('Opcje promowania') ?></h2>
    <div class="content">
        <?php echo st_admin_get_form_field('offer[promotion][emphasized_highlight_bold_package]', __("Pakiet promowania"), "true", 'checkbox_tag', array("checked" => isset($offer->promotion) ? $offer->promotion->emphasizedHighlightBoldPackage : false, 'class' => 'update-pricing-fee-preview')) ?>
        <?php echo st_admin_get_form_field('offer[promotion][emphasized]', __("Wyróżnienie"), "true", 'checkbox_tag', array("checked" => isset($offer->promotion) ? $offer->promotion->emphasized : false, 'class' => 'update-pricing-fee-preview')) ?>
        <?php echo st_admin_get_form_field('offer[promotion][bold]', __("Pogrubienie"), "true", 'checkbox_tag', array("checked" => isset($offer->promotion) ? $offer->promotion->bold : false, 'class' => 'update-pricing-fee-preview')) ?>
        <?php echo st_admin_get_form_field('offer[promotion][highlight]', __("Podświetlenie"), "true", 'checkbox_tag', array("checked" => isset($offer->promotion) ? $offer->promotion->highlight : false, 'class' => 'update-pricing-fee-preview')) ?>
        <?php echo st_admin_get_form_field('offer[promotion][department_page]', __("Oferta promowania na stronie kategorii"), "true", 'checkbox_tag', array("checked" => isset($offer->promotion) ? $offer->promotion->departmentPage : false, 'class' => 'update-pricing-fee-preview')) ?>
    </div>
</fieldset>
<fieldset>
    <h2><?php echo __('Podsumowanie') ?></h2>
    <div class="content">
        <div id="st-allegro-pricing-free-preview-container" class="row">
            <?php echo st_get_component('stAllegroBackend', 'pricingFeePreview', array(
                'category' => $offer->category->id,
                'quantity' => $offer->stock->available,
                'price' => $offer->sellingMode->price->amount,
                "bold" => isset($offer->promotion) ? $offer->promotion->bold : false,
                "highlight" => isset($offer->promotion) ? $offer->promotion->highlight : false,
                "departmentPage" => isset($offer->promotion) ? $offer->promotion->departmentPage : false,
                "emphasized" => isset($offer->promotion) ? $offer->promotion->emphasized : false,
                "emphasizedHighlightBoldPackage" => isset($offer->promotion) ? $offer->promotion->emphasizedHighlightBoldPackage : false,
                "offerId" => isset($offer->id) ? $offer->id : null,
                "status" => isset($offer->publication) ? $offer->publication->status : null, 
            )) ?>
        </div>
    </div>
</fieldset>


<div id="edit_actions">
    <div style="float: left">
        <?php
            $actions = array(
                array('type' => 'list', 'label' => __('Lista'), 'action' => '@stAllegroPlugin?action=list&product_id=' . $sf_request->getParameter('product_id')),
            );

            if (!$sf_request->getParameter('product_id'))
            {
                $actions[] = array('type' => 'edit', 'label' => __('Edycja produktu'), 'action' => '@stProduct?action=edit&id=' . $product->getId());
            }
            else
            {
                $actions[] = array('type' => 'list', 'label' => __('Lista wszystkich ofert'), 'action' => '@stAllegroPlugin?action=list');
            }

            echo st_get_admin_actions($actions); 
        ?>
    </div>
    <div style="float: right">
        <?php 
            $actions = array();

            $actions[] = array('type' => 'save', 'label' => __('Zapisz'));

            if (!isset($offer->publication) || $offer->publication->status == 'INACTIVE')
            {
                if (isset($offer->id))
                {
                    $actions = array_merge(array(array('type' => 'delete', 'label' => __('Usuń'), 'action' => '@stAllegroPlugin?action=delete&id=' . $sf_request->getParameter('id') . '&product_id=' . $sf_request->getParameter('product_id'), 'params' => array('confirm' => __('Jesteś pewien, że chcesz usunąć szkic')))), $actions);
                }

                $actions[] = array('type' => 'save', 'label' => __('Wystaw'), 'params' => array('name' => 'publish'));
            }

            if (isset($offer->publication) && ($offer->publication->status == 'ACTIVE' || $offer->publication->status == 'ENDED'))
            {
                $actions = array_merge(array(array('type' => 'duplicate', 'label' => __('Wystaw podobną'), 'action' => '@stAllegroPlugin?action=duplicate&id=' . $sf_request->getParameter('id') . '&product_id=' . $sf_request->getParameter('product_id'))), $actions);
            }

            if (isset($offer->publication) && $offer->publication->status == 'ENDED')
            {
                $actions[] = array('type' => 'save', 'label' => __('Wznów'), 'params' => array('name' => 'publish'));
            }

            if (isset($offer->publication) && $offer->publication->status == 'ACTIVE')
            {
                $actions = array_merge(array(array('type' => 'delete', 'label' => __('Zakończ'), 'action' => '@stAllegroPlugin?action=end&id=' . $sf_request->getParameter('id') . '&product_id=' . $sf_request->getParameter('product_id'), 'params' => array('confirm' => __('Jesteś pewien, że chcesz zakończyć ofertę')))), $actions);
            }

            echo st_get_admin_actions($actions); 
        ?>
    </div>
    <div class="clr"></div>
</div>

<script type="text/javascript">
jQuery(function($) {
    $(document).ready(function() {
        $('#edit_actions').stickyBox();
        <?php if ($product->isNew()): ?>
            $('.st_product_options_picker').trigger('options_change');
        <?php endif ?>
        $('.update-pricing-fee-preview').change(function() {
            var form = $(this).closest('form');
            $.post('<?php echo url_for('@stAllegroPlugin?action=ajaxFeePreviewUpdate&id=' .  (isset($offer->id) ? $offer->id : 0)) . '&status=' . (isset($offer->publication) ? $offer->publication->status : '') ?>', form.serialize(), function(response) {
                $('#st-allegro-pricing-free-preview-container').html(response);
            });
        });
    });
});
</script>

<?php st_allegro_parameter_javascript_init('#st-allegro-offer-form-container') ?>