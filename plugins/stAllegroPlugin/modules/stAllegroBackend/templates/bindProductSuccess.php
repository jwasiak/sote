<?php use_helper('stAdminGenerator', 'stAllegro', 'stPartial');?>
<?php use_stylesheet('backend/stAllegroPlugin.css?v3');?>
<?php use_stylesheet('backend/stProductOptionsPicker.css') ?>

<?php st_include_partial('stAllegroBackend/header', array('title' =>  __('Powiąż produkt z ofertą - ' . $offer->name . ' (' . $offer->id . ')', null, 'stAllegroBackend')));?>
<?php st_include_component('stAllegroBackend', 'listMenu'); ?>   

<style>
.token-input-dropdown-backend .product_token .image > div {
    height: 30px;
    width: 30px;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
}

.token-input-dropdown-backend .product_token .image {
    display: inline-block;
    vertical-align: middle;
    margin-right: 5px;
}

.token-input-dropdown-backend .product_token .code {
    color: #888;
}
</style>

<div id="sf_admin_content">
    <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels)) ?>
    <form action="<?php echo url_for('@stAllegroPlugin?action=bindProduct&id='. $offer->id) ?>" id="st-allegro-offer" class="admin_form" method="post">
        <fieldset>
            <div class="content">
                <?php echo st_admin_get_form_field('bind[product]', __("Produkt"), $auction->getProduct() ? array(array('id' => $auction->getProduct()->getId(), 'name' => $auction->getProduct()->getName(), 'code' => $auction->getProduct()->getCode())) : null, 'st_allegro_product_search', array(
                    'required' => true,
                    'tokenizer' => array(
                        'onAdd' => ' function (item) { 
                            $(document).trigger("preloader", "show");
                            $.get("'.st_url_for('stAllegroBackend/ajaxGetProductOptionsPicker').'", { id: item.id }, function(response) {
                                 var container = $("#st-allegro-product-options-container");
                                 if (response.length > 0) {
                                    container.find(".content").html(response);
                                    container.show();
                                 } else {
                                     container.hide();
                                 }
                                
                                 $(document).trigger("preloader", "close");
                            });
                        }',
                        'onDelete' => 'function() {  $("#st-allegro-product-options-container").hide();  }',
                    )
                )) ?>
            </div>
        </fieldset>
       
        <fieldset id="st-allegro-product-options-container"<?php if (!$auction->getProduct() || $auction->getProduct()->getOptHasOptions() <= 1): ?>style="display: none"<?php endif ?>>
            <h2><?php echo __('Opcje produktu') ?></h2>
            <div class="content">
                <?php echo $auction->getProduct() && $auction->getProduct()->getOptHasOptions() > 1 ? st_get_component('stProductOptionsBackend', 'optionPicker', array('product' => $auction->getProduct(), 'namespace' => 'bind[product_options]', 'selected' => $auction->getProductOptionsArray())) : '' ?>   
            </div>
        </fieldset>
        <div id="edit_actions">
            <?php if (!$auction->isNew()): ?>
                <div style="float: left">
                    <?php echo st_get_admin_actions(array(
                        array('type' => 'list', 'label' => __('Wróć do oferty'), 'action' => '@stAllegroPlugin?action=edit&id=' . $auction->getAuctionId()),
                    )); ?>            
                </div>
            <?php endif ?>
            <div style="float: right">
                <?php echo st_get_admin_actions(array(
                    array('type' => 'save', 'label' => __('Powiąż')),
                )); ?>
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>

<?php st_include_partial('stAllegroBackend/footer');?>

<script>
    jQuery(function($) {
        $('.st_product_options_picker').on('before_options_change', function() {
            $(document).trigger("preloader", "show");
        });

        $('.st_product_options_picker').on('options_change', function() {
            $(document).trigger("preloader", "close");
        });
    });
</script>
