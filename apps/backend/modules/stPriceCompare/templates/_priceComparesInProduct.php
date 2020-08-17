<?php echo form_tag('stProduct/priceCompareCustom?product_id='.$sf_params->get('product_id'));?>
    <?php echo st_get_admin_horizontal_look_head('style="border: 1px solid #ccc;"');?>
        <?php echo stSocketView::openComponents('stPriceCompare.showInProduct.before'); ?>
        <?php foreach ($plugin as $key => $value):?>
            <?php if ($pluginName[$key] <> 'stSkapiecPlugin'): ?>
                <?php echo st_get_admin_horizontal_element_head('style="width:250px; border: none; padding: 10px;"');?>                
                    <div id="st_application-st_price_compare-set_active_for_price_compares-div">
                        <?php echo link_to(image_tag('backend/main/icons/red/'.$pluginName[$key].'.png', array('id' => 'app_stCeneoPlugin', 'style' => 'float: left; height: 35px; width: 35px;')), '@'.$pluginName[$key]);?>
                        <p style="margin-top: 8px; margin-left: 10px; float: left; font-size: 12px;"><?php echo $key ?></p>
                        <?php echo checkbox_tag('priceCompare['.$key.']', 1, ($value)?$value->getActive():false, array('style' => 'margin-top: 10px; margin-left: 10px; float: left'));?>
                    </div>
                <?php echo st_get_admin_horizontal_element_foot();?>
            <?php endif; ?>
        <?php endforeach;?>
    <?php echo st_get_admin_horizontal_look_foot();?>
    <?php echo st_get_admin_actions_head('style="float: right"');?>
        <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, 'name=save');?>
    <?php echo st_get_admin_actions_foot();?>
</form>