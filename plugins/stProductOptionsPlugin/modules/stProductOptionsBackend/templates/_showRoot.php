<?php if(!$sf_request->isXmlHttpRequest()): ?>
    <div class="st_product_options-tree x-panel x-panel-noborder x-tree" id="st_product_options-tree_edit">
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
                    <fieldset id="sf_fieldset_none" class="">     
                        <div>  
                            <?php $params = explode('/',$sf_request->getReferer()) ?>
                            <?php echo input_hidden_tag('product_option[model]', get_class($product_option)) ?>    
                            <?php echo input_hidden_tag('product_option[root]', 1) ?>                                  

                            <div class="form-row" >
                                <?php echo form_error('product_option{price_type}', array('class' => 'form-error-msg')) ?>
                                <?php echo label_for('product_option[price_type]', __('Modyfikatory cen podawane w wartości').':', '') ?>
								<?php $selected = $product_option->getPriceType() ? $product_option->getPriceType() : $price_type ?>
                                <?php if ($product_option instanceof ProductOptionsValue && $product_option->getProduct()->getCurrencyExchange() != 1) { $selected = 'brutto'; } ?>
                                <?php echo input_hidden_tag('product_option[culture]',$product_option->getCulture()) ?>
                                <?php $value = select_tag('product_option[price_type]', options_for_select(array('brutto' => __('Brutto'), 'netto' => __('Netto')), $selected), array('control_name' => 'product_option[price_type]', 'disabled' => $product_option instanceof ProductOptionsValue && $product_option->getProduct()->getCurrencyExchange() != 1)) ?>
                                <?php echo $value ? $value : '&nbsp;' ?>
                                <br class="st_clear_all">
                            </div>
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
