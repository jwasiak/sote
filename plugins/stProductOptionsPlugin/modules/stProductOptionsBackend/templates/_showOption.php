<?php
use_helper('stAdminGenerator', 'stJQueryTools', 'stCurrency', 'stPrice');
plupload_init();
sfLoader::loadHelpers('stProduct', 'stProduct');
init_tooltip('.image_tooltip', array('position' => array('center', 'center'), 'width' => 'auto', 'delay' => 20, 'predelay' => 20));
init_tooltip('.help');
if (isset($product_option) && isset($product))
{
    $currency = $product->getCurrency()->getShortcut();
    $price_type = $product->getCurrencyExchange() != 1 ? __('brutto') : __($product_option->getPriceType());
}
elseif (isset($product_option))
{
   $price_type = __($product_option->getPriceType());
   $currency = stCurrency::getInstance($sf_context)->get()->getShortcut();
}
?>
<?php if(!$sf_request->isXmlHttpRequest()): ?>
    <div class="st_product_options-tree x-panel x-panel-noborder x-tree" id="st_product_options-tree_edit" style="height: auto; width: auto">
<?php endif ?>
	<?php echo javascript_tag('var errors_to_clear = new Array();')?>
    <?php use_helper('Object', 'Validation', 'I18N', 'Date', 'stAdminGenerator','stProductPhoto','stImageSize') ?>
    <?php if(!empty($product_option)): ?>
        <?php echo form_remote_tag(array(
                'url' => 'stProductOptionsTreeBackend/saveProductOption?id='.(!empty($product_option) ? $product_option->getId() : $field->getId()),
                'update' => (!empty($attriubte) ? 'product_option_list' : 'field_list'),
                'complete' => "postSubmitForm(request, json, tree, ".json_encode(array('save_title'=>__('Zapisz',null,'stProductOptionsBackend')))."); jQuery(document).trigger('preloader', 'close') ")) ?>
    <div class="x-panel-bwrap">
        <div class="x-panel-tbar x-panel-tbar-noheader x-panel-tbar-noborder">
            <div class="x-toolbar x-small-editor x-my-toolbar">
                <?php echo st_include_partial('showUpSubmitXToolbar') ?>
            </div>
        </div>
        <div class="x-panel-body x-panel-body-noheader x-panel-body-noborder">
                    <?php use_helper('stTooltip') ?>    
                    <fieldset id="sf_fieldset_none" class="">     
                        <div>  
                            <?php $params = explode('/',$sf_request->getReferer()) ?>
                            <?php echo input_hidden_tag('product_option[model]', get_class($product_option)) ?>                                      

                            <div class="form-row" >
                                <?php echo form_error('product_option{value}', array('class' => 'form-error-msg')) ?>
                                <?php echo input_hidden_tag('product_option[culture]',$product_option->getCulture()) ?>
                                <label for="product_option_value">
                                    <?php echo __('Wartość') ?>
                                    <a href="#" class="help" title="<?php echo __('Wprowadź wartość opcji (np. zielony, XL)') ?>"></a>:
                                </label>                                
                                <?php $value = object_input_tag($product_option, 'getValue', array ('size' => 20, 'control_name' => 'product_option[value]'), 'wartość') ?>
                                <?php echo $value ? $value : '&nbsp;' ?>
                                <br class="st_clear_all" />     
                            </div>
                            
                            <?php $hint  = '<ul><li>'.__('+/- kwota (np. -10.25) - zwiększa lub zmniejsza cenę netto o podaną kwotę').'</li>' ?>
                            <?php $hint .= '<li>'.__('+/- ilosc % (np. +50%) - zwiększa lub zmniejsza cenę netto o podaną ilość procent').'</li>' ?>
                            <?php $hint .= '<li>'.__('kwota (np. 30.99) - ustala podaną kwotę niezależnie od ceny produktu').'</li></ul>' ?>                           
                            <div class="form-row">                            
                                    <label for="product_option_price">
                                       <?php echo __('Modyfikator ceny') ?>
                                       <?php echo $price_type ?>
                                       <a href="#" class="help" title="<?php echo htmlspecialchars($hint) ?>"></a>:
                                    </label>
                                    <div class="field">
                                        <?php echo form_error('product_option{price}', array('class' => 'form-error-msg')) ?>
                                        <?php echo input_tag('product_option[price]', $product_option->getPrice() ? $product_option->getPrice() : null, array ('size' => 20)) ?>
                                        <?php echo $currency ?>
                                    </div>
                              
                            </div>

                            <?php $hint  = '<ul><li>'.__('+/- waga (np. -10.25) - zwiększa lub zmniejsza wagę o podaną wartość').'</li>' ?>
                            <?php $hint .= '<li>'.__('+/- waga % (np. +50%) - zwiększa lub zmniejsza wagę o podaną ilość procent').'</li>' ?>
                            <?php $hint .= '<li>'.__('waga (np. 30.99) - ustala podaną wagę niezależnie od wagi produktu').'</li></ul>' ?>
                            <div class="form-row">
                                    <label for="product_option_weight">
                                       <?php echo __('Modyfikator wagi') ?>
                                       <a href="#" class="help" title="<?php echo htmlspecialchars($hint) ?>"></a>:
                                    </label>
                                    <div class="field">
                                        <?php echo form_error('product_option{weight}', array('class' => 'form-error-msg')) ?>
                                        <?php echo input_tag('product_option[weight]', $product_option->getWeight() ? $product_option->getWeight() : null, array ('size' => 20)) ?>
                                        kg
                                    </div>
                            </div>  

                            <?php if (get_class($product_option) != 'ProductOptionsDefaultValue'):?>

                            <?php if ($product_option->getProduct()->getBasicPriceUnitMeasureRelatedByBpumDefaultId()): ?>
                            <div class="form-row">
                                    <label for="product_option_pum">
                                       <?php echo __('Ilość jednostki miary') ?>
                                       <a href="#" class="help" title="<?php echo __('Całkowita miara dla jednostki produktu np. 1kg, 10m, 100l.', null, 'stProduct') ?>"></a>:
                                    </label>
                                    <div class="field">
                                        <?php echo form_error('product_option{pum}', array('class' => 'form-error-msg')) ?>
                                        <?php echo input_tag('product_option[pum]', $product_option->getPum() ? $product_option->getPum() : null, array ('size' => 20)) ?>
                                        <?php echo $product_option->getProduct()->getBasicPriceUnitMeasureRelatedByBpumDefaultId() ?>
                                    </div>
                            </div> 
                            <script type="text/javascript">
                            jQuery(function($) {
                                $('#product_option_pum').change(function() {
                                    this.value = stPrice.fixNumberFormat(this.value);
                                });
                            });
                            </script>                                                     
                            <?php endif ?>                                
                            <div class="form-row">
                                <label for="product_option_old_price">
                                    <?php echo __('Stara cena') ?>
                                    <a href="#" class="help" title="<?php echo __('Wprowadź starą cene (np. 123.45)') ?>"></a>:
                                </label>    
                                <div class="field"> 
                                    <?php echo form_error('product_option{old_price}', array('class' => 'form-error-msg')) ?>                           
                                    <?php echo input_tag('product_option[old_price]', $product_option->getOldPrice() ? $product_option->getOldPrice() : null, array ('size' => 20)) ?>
                                    <?php echo $currency ?>
                                </div>    
                            </div>
                                <?php if ($product_option->isLeaf() && $product->getStockManagment() == ProductPeer::STOCK_PRODUCT_OPTIONS): ?>

                                <div class="form-row">              
                                    <label for="product_option_stock">
                                       <?php echo __('Stan magazynowy') ?>
                                       <a href="#" class="help" title="<?php echo __('Stan magazynowy dla opcji produktu') ?>"></a>:
                                    </label> 
                                    <div class="field"> 
                                        <?php echo form_error('product_option{stock}', array('class' => 'form-error-msg')) ?>
                                        <?php echo input_tag('product_option[stock]', stPrice::round($product_option->getStock()), array ('size' => 20, 'disabled' => null === $product_option->getStock())) ?>
                                        <?php echo st_product_uom($product) ?>
                                        <label style="float: none; margin-left: 5px">
                                            <?php echo checkbox_tag('product_option[validate_stock]', 1, null !== $product_option->getStock() || $product_option->isNew()) ?>
                                            <?php echo __('Włączony') ?>
                                        </label>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($product_option->isLeaf() && get_class($product_option) != 'ProductOptionsDefaultValue'):?>
                                <?php $use_product = $product_option->getUseProduct(); ?>
                                <div class="form-row">              
                                    <label for="product_option_use_product">
                                    <?php echo __('Kod produktu') ?>:
                                    </label> 
                                    <div class="field">    
                                        <?php echo form_error('product_option{use_product}', array('class' => 'form-error-msg')) ?>
                                        <?php echo object_input_tag($product_option, 'getUseProduct', array ('size' => 48, 'control_name' => 'product_option[use_product]')) ?>
                                    </div> 
                                </div>

                                <?php echo st_admin_get_form_field('product_option[man_code]', __('Kod producenta', null, 'stProduct'), $product_option->getManCode(), 'input_tag', array('help' => __('Kod kreskowy EAN | UPC lub JAN', null, 'stProduct'), 'size' => 48)) ?>
                            <?php endif; ?>
                            <?php if (is_object($product_option->getProductOptionsField()->getProductOptionsFilter()) && $product_option->getProductOptionsField()->getProductOptionsFilter()->getFilterType() == 2): ?>
                            <div class="form-row">              
                                    <?php echo form_error('product_option{filter}', array('class' => 'form-error-msg')) ?>
                                    <label for="product_option_filter">
                                       <?php echo __('Kolor') ?>
                                    </label>  
                                    <div class="field">  
                                        <div id="color_type">
                                            <?php echo select_tag('product_option[color_type]', options_for_select(array(__("Wybierz kolor"), __("Wybierz zdjęcie")), $product_option->getUseImageAsColor())) ?>
                                        </div>
                                        <div id="color_image"<?php if (!$product_option->getUseImageAsColor()): ?> style="display: none"<?php endif ?>>
                                            <?php echo plupload_images_tag('product_option[color_image]', $product_option->getUseImageAsColor() && $product_option->getColorImagePath() ? array($product_option->getColorImagePath()) : array(), array('limit' => 1)) ?>
                                        </div>
                                        <div id="color_picker"<?php if ($product_option->getUseImageAsColor()): ?> style="display: none"<?php endif ?>>                   
                                            <?php echo st_colorpicker_input_tag('product_option[color]', !$product_option->getUseImageAsColor() && $product_option->getColor() ? $product_option->getColor() : 'ffffff') ?>
                                        </div>
                                        <script type="text/javascript">
                                        jQuery(function($) {
                                            $.cssHooks.backgroundColor = {
                                                get: function(elem) {
                                                    if (elem.currentStyle)
                                                        var bg = elem.currentStyle["backgroundColor"];
                                                    else if (window.getComputedStyle)
                                                        var bg = document.defaultView.getComputedStyle(elem,
                                                            null).getPropertyValue("background-color");
                                                    if (bg.search("rgb") == -1)
                                                        return bg;
                                                    else {
                                                        bg = bg.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
                                                        function hex(x) {
                                                            return ("0" + parseInt(x).toString(16)).slice(-2);
                                                        }
                                                        return "#" + hex(bg[1]) + hex(bg[2]) + hex(bg[3]);
                                                    }
                                                }
                                            };

                                            $('#product_option_color').change(function() {
                                                $(this).val($('#product_option_color-trigger').css('backgroundColor').slice(1));
                                            });

                                            $('#product_option_color_type').change(function() {
                                              
                                                if (this.selectedIndex > 0) {
                                                    $('#color_picker').hide();
                                                    $('#color_image').show();
                                                } else {
                                                    $('#color_picker').show();
                                                    $('#color_image').hide();                                                    
                                                }
                                            });
                                        });
                                        </script>
                                    </div>
                            </div>
                            <?php endif; ?>
                            <?php 
                                $event = new sfEvent($product_option, 'stProductOptionsBackend.showOption');
                                stEventDispatcher::getInstance()->filter($event,array('product_option'=>$product_option, 'html'=>'')); 
                                $args = $event->getReturnValue();
                                echo $args['html'];
                            ?>
                            <?php if(!empty($photos)): ?>    
                            <?php use_helper('stAsset', 'stProductImage') ?>     
                            <div class="form-row st_product_options-gallery">
                                <?php echo form_error('product_option{sf_asset_id}', array('class' => 'form-error-msg')) ?>
                                <?php echo label_for('product_option[sf_asset_id]', __('Zdjęcie').':', '')?>
                                <div class="gallery">
                                <ul>
                                    <li>
                                        <span style="background-color: #fff; display: table-cell; vertical-align: middle"><?php echo __('Brak') ?></span>
                                        <?php echo radiobutton_tag('product_option[sf_asset_id]', null, null === $product_option->getsfAssetId()) ?>
                                    </li>
                                <?php foreach ($photos as $photo): $image_path = st_product_image_path($photo, 'small'); ?>
                                    <li> 
                                       <span class="image_tooltip" title="&lt;img src=&quot;<?php echo $image_path ?>&quot; /&gt;" style="background-image: url(<?php echo $image_path ?>)"></span>
                                       <?php echo radiobutton_tag('product_option[sf_asset_id]', $photo->getId(), $photo->getId()==$product_option->getsfAssetId())?>
                                    </li>
                                <?php endforeach;?>
                                </ul>
                                <div class="clr"></div>
                                </div>
                            </div>
                            <?php endif; ?>     

                            <?php echo st_include_partial('showSubmitXToolbar') ?>
                        </div>
                    </fildset>
                </form>            
        </div>
    </div>
            <?php endif; ?>
<?php if(!$sf_request->isXmlHttpRequest()): ?>
    </div>
<?php endif; ?>
<script type="text/javascript">
jQuery(function($) {
    function fixModificator() {
        var input = $(this);
        var val = $.trim(input.val()).replace(/[^-+,%0-9\.]/ig,'');

        var prefix = val[0] == '+' || val[0] == '-' ? val[0] : '';

        var suffix = val.substr(-1) == '%' ? '%' : '';

        var value = val.replace(',', '.').replace(/[^0-9\.]/ig,'');

        input.val(prefix+value+suffix);
    }

    $('#product_option_price').change(fixModificator);
    $('#product_option_weight').change(fixModificator);
    $('#product_option_validate_stock').change(function() {
        $('#product_option_stock').attr('disabled', !this.checked);
    });
});
</script>
