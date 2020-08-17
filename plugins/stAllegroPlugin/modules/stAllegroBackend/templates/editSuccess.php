<?php use_helper('stAdminGenerator', 'stAllegroParameter', 'stAllegroDelivery', 'stPartial', 'stAsset');?>
<?php use_stylesheet('backend/stAllegroPlugin.css?v5');?>
<?php use_javascript('tinymce/tinymce.min.js?v='.sfRichTextEditorTinyMCE::VERSION); ?>
<?php use_stylesheet('backend/stTinyMCEPlugin.css?v='.sfRichTextEditorTinyMCE::VERSION); ?>
<?php
$product_id = '';

if ($sf_request->getParameter('product_id'))
{
    $product_id = $product->getId();
    st_include_partial('stProduct/header', array('title' =>  __($sf_request->getParameter('id') ? 'Edycja oferty - %%no%%' : 'Dodaj nową ofertę', array('%%no%%' => $sf_request->getParameter('id')), 'stAllegroBackend'), 'related_object' => $product, 'route' => null));
    st_include_component('stProduct', 'editMenu', array('related_object' => $product));
} 
else 
{
    st_include_partial('stAllegroBackend/header', array('title' =>  __('Edycja oferty - %%no%%', array('%%no%%' => $sf_request->getParameter('id')), 'stAllegroBackend')));
    st_include_component('stAllegroBackend', 'listMenu');  
}
?> 

<div id="sf_admin_content">
    <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels)) ?>
    <form action="<?php echo isset($offer->id) ? url_for('@stAllegroPlugin?action=edit&id='.$offer->id . '&product_id=' . $product_id) : url_for('@stAllegroPlugin?action=edit&product_id=' . $product_id) ?>" id="st-allegro-offer" class="admin_form" method="post">
        <?php echo input_hidden_tag('offer[images]', json_encode(isset($offer->images) ? $offer->images : array())) ?>
        <fieldset>
            <div class="content">
                <?php if (isset($offer->id)): ?>
                    <?php echo st_admin_get_form_field('offer[product]', __("Powiązany produkt"), $product, '_offer_product', array('offer' => $offer, 'required' => true)) ?>
                <?php endif ?>
                <?php echo st_admin_get_form_field('offer[name]', __("Tytuł"), $offer->name, 'input_tag', array('maxlength' => 50, 'size' => 60, 'required' => true)) ?>
                <?php echo st_admin_get_form_field('offer[category]', __("Kategoria"), $offer, '_offer_category', array('maxlength' => 50, 'size' => 60, 'required' => true, 'product' => $product)) ?>
                <?php //echo st_admin_get_form_field('offer[ean]', __("EAN"), $offer->ean, 'input_tag', array('maxlength' => 18, 'size' => 60)) ?>
            </div>
        </fieldset>
        <?php if ($product && $product->getOptHasOptions() > 1): ?>
            <fieldset>
                <h2><?php echo __('Opcje produktu') ?></h2>
                <div class="content">
                    <?php echo st_get_component('stProductOptionsBackend', 'optionPicker', array('product' => $product, 'namespace' => 'auction[product_options]', 'selected' => $auction->getProductOptionsArray())) ?>   
                </div>
            </fieldset>
        <?php endif ?>
        <div id="st-allegro-offer-form-container">
            <?php if (isset($offer->category) && $offer->category->id): ?>
                <?php echo st_get_component('stAllegroBackend', 'offerForm', array('offer' => $offer, 'product' => $product)) ?>
            <?php endif ?>
        </div>
    </form>

    <div id="st-allegro-offer-add-image-overlay" class="popup_window">
        <div class="close">
            <img src="/images/backend/beta/gadgets/close.png" alt="" />
        </div>
        <h2>
            <?php echo __('Dodaj zdjęcia produktu', null, 'stAllegroBackend');?>
        </h2>
        <div class="preloader_48x48" style="position: absolute; top: 0; left: 0; height: 100%; width: 100%; background-color: rgba(255, 255, 255, 0.7); z-index: 1;"></div>
        <div class="content" style="min-height: 170px"></div>
    </div>
</div>

<?php st_allegro_parameter_javascript_init(); ?>

<?php st_include_partial('stAllegroBackend/footer');?>

<script id="add-offer-image-tpl" type="text/x-template">
    <div class="image" data-value="##image##">
        <div class="image-overlay">
            <a href="#" class="delete" data-action="delete"><img src="/jQueryTools/plupload/images/remove.png?v2"></a>
        </div>
        <div class="thumbnail" style="background-image: url(##image##)"></div>
    </div>
</script>


<script>
jQuery(function($){
    var price = <?php echo $product->getPriceBrutto() ?>;
    var stock = <?php echo $product->getStock() ?>;
    var commission = <?php echo json_encode($config->get('offer_product_commission', array())) ?>;

    // imageContainer.find('.add-image').before("<div>testowa</div>");

    $('.st_product_options_picker').on('options_change', function(event, productPrice, productStock, manCode, options) {
        if (undefined !== productStock) {
            stock = productStock;
        }

        if (undefined !== productPrice) { 
            price = Number(productPrice);
        }

        $('#offer_stock_available').val(stock);
        if (price && commission.commission > 0) {
            price = price + price * (Number(commission.commission) / 100);
            if (commission.round_type == 'full_buck') {
                price = Math.round(price);
            }
        }
        $('#offer_selling_mode_price_amount').val(price.toFixed(2));
        $('#st-allegro-edit-stock-product').html(stock);
        $('#offer_parameters_string_225693').val(manCode);
    });

    var addImageOverlay = $('#st-allegro-offer-add-image-overlay').overlay({
        closeOnClick: true,
        closeOnEsc: true,
        top: "5%", 
        speed: 0,
        oneInstance: false,
        load: false,
        closeSpeed: 0,
        mask: {
            color: '#444',
            loadSpeed: 0,
            closeSpeed: 0,
            opacity: 0.5,
            zIndex: 30000
        }, 
        onLoad: function() {
            var url = "<?php echo url_for('@stAllegroPlugin?action=ajaxUploadOfferImages') ?>";
            
            var content = addImageOverlay.find('.content');

            if (!content.html().length) {
                addImageOverlay.find('.preloader_48x48').show();
                $.get(url, { product: <?php echo $product->getId() ?> }, function(response) {
                    content.html(response);
                    addImageOverlay.find('.preloader_48x48').hide();
                });
            }
        }
    });
});

</script>
