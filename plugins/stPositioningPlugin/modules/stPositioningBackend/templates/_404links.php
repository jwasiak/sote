<?php if ($sf_flash->has('notice')):?>
    <div class="save-ok">
        <h2><?php echo $sf_flash->get('notice');?></h2>
    </div>
<?php endif;?>
<div id="sf_admin_content_config">
    <?php echo form_tag('stPositioningBackend/404linksCustom', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form'));?>
        <fieldset style="padding: 10px;">
                <div class="form-row">
                    <?php echo __('Przekieruj linki, które prowadzą do stron 404 sklepu na linki z ofertą. Przykład: /stary_link http://domenasklepu.pl/nowy_link'); ?>
                </div>       
                <div class="form-row">
                    <?php echo textarea_tag('404links[fileContent]', $fileContent, array('size' => '100x30', 'style' => 'width: 830px;'));?>
                    <br class="st_clear_all" />
                </div>
        </fieldset>
        <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"');?>
            <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save'));?>
        <?php echo st_get_admin_actions_foot();?>
    </form>
</div>
