<?php if(!$sf_request->isXmlHttpRequest()): ?>
    <div class="st_product_options-tree x-panel x-panel-noborder x-tree" id='st_product_options-tree_edit'>
<?php endif ?>
    <?php use_helper('Object', 'Validation', 'I18N', 'Date', 'stAdminGenerator','stProductPhoto','stImageSize') ?>
    <?php init_tooltip('.help'); ?>
    <?php if(!empty($field)): ?>
        <?php echo form_remote_tag(array(
                'url' => 'stProductOptionsTreeBackend/saveProductOption?id='.(!empty($product_option) ? $product_option->getId() : $field->getId()).'&model='.$model.'&product_id='.$sf_request->getParameter('product_id'),
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
                            <?php use_helper('stTooltip') ?>                     
                            <div class="form-row" >
                                <?php echo form_error('field{name}', array('class' => 'form-error-msg')) ?>
                                <?php echo input_hidden_tag('field[culture]',$field->getCulture()) ?>
                                <label for="field_name">
                                    <?php echo __('Nazwa opcji') ?>
                                    <a href="#" class="help" title="<?php echo __('Wprowadź nazwę opcji (np. Kolor, Rozmiar)') ?>"></a>:
                                </label>                                   
                                <?php $value = object_input_tag($field, 'getName', array ('size' => 20, 'control_name' => 'field[name]'), 'opcja')  ?>
                                <?php echo $value ? $value : '&nbsp;' ?>
                                <br class="st_clear_all" />     
                            </div>
                            
                            <?php if($default_options): ?>
                            <div class="form-row">
                                <?php echo form_error('field{default_value}', array('class' => 'form-error-msg')) ?>
                                <label for="field_default_value">
                                    <?php echo __('Domyślna wartość') ?>:
                                </label>                                 

                                <?php echo select_tag('field[default_value]', options_for_select($default_options, $default_selected), array('class' => 'st_product_options_select')); ?>

                                <br class="st_clear_all" />   
                            </div> 
                            <?php endif; ?>
                            <div class="form-row" >
                                <?php echo form_error('field{name}', array('class' => 'form-error-msg')) ?>
                                <?php echo input_hidden_tag('field[culture]',$field->getCulture()) ?>
                                <label for="field_filter_type">
                                    <?php echo __('Rodzaj filtra') ?>:
                                </label>                                   
                                <?php $value = object_select_tag($field,'getProductOptionsFilterId',array('related_class'=>'ProductOptionsFilter', 'peer_method' => 'getOptionFiltersForSelect', 'class'=>'st_product_options_select', 'include_blank'=>true, 'name'=>'field[filter_type]'));  ?>
                                <?php echo $value ? $value : '&nbsp;' ?>
                                <br class="st_clear_all" />     
                            </div>
                            <?php 
                                $event = new sfEvent($field, 'stProductOptionsBackend.showField');
                                stEventDispatcher::getInstance()->filter($event,array('field'=>$field, 'html'=>'')); 
                                $args = $event->getReturnValue();
                                echo $args['html'];
                            ?>  
	                    <?php echo st_include_partial('showSubmitXToolbar') ?>

                        </div>
                    </fieldset>
                </form>            
            <?php endif; ?>
        </div>
    </div>
    
<?php if(!$sf_request->isXmlHttpRequest()): ?>
    </div>
<?php endif; ?>
