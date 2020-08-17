<?php if ($sf_flash->has('notice')):?>
    <div class="save-ok">
        <h2><?php echo $sf_flash->get('notice');?></h2>
    </div>
<?php endif;?>
<div id="sf_admin_content_config">
    <?php echo form_tag('stPositioningBackend/robotFileCustom', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form'));?>
        <fieldset style="padding: 10px;">
            <div class="st_fieldset-none">
                <div class="form-row">
                    <?php echo __('Plik robots.txt informuje roboty wyszukiwarek indeksujących stronę, wykorzystują w tym celu specjalny protokół (Robots Exclusion Protocol), które elementy strony mają zostać zablokowane.'); ?>
                </div>                
                <div class="form-row">
                    <?php echo textarea_tag('positioning[fileContent]', $fileContent, array('size' => '100x30', 'style' => 'width: 830px;'));?>
                    <br class="st_clear_all" />
                </div>
            </div>
        </fieldset>
        <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"');?>
            <?php echo st_get_admin_action('reset', __('Przywróć oryginalny plik'), null, array('name' => 'restore'));?>
            <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save'));?>
        <?php echo st_get_admin_actions_foot();?>
    </form>
</div>
