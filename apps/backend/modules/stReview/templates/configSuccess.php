<?php use_helper('I18N', 'stAdminGenerator', 'stJQueryTools', 'stPrice'); ?>
<?php st_include_partial('stReview/header', array('title' => __('Konfiguracja'), 'culture' => $config -> getCulture(), 'route' => 'stReview/config')); ?>
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message'); ?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('stReview/config?culture=' . $config -> getCulture(), array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form')); ?>
                
                    <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Ustawienie wysyłania maili') ?></h2>
                        </div>
                    </div>    
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <label for="config[auto_send]"><?php echo __('Wysyłaj przy zmianie statusu'); ?><a class="help" title="<?php echo __('Wiadomości będą automatycznie wysyłane po zmianie statusu zamówienia.') ?>" href="#"></a></label>
                            <?php echo checkbox_tag('config[auto_send]', true, $config -> get('auto_send')); ?>                            
                            <br class="st_clear_all" />
                        </div>
                        
                        <div class="form-row">
                             <?php echo label_for('config[order_status_type]', __('Dla statusu zamówienia'), ''); ?>
                             <?php echo select_tag('config[order_status_type]', options_for_select($select_options, $config->get("order_status_type")), array('class' => 'support')) ?>                             
                            <br class="st_clear_all" />
                        </div>
               
                        <div class="form-row">
                             <label for="config_send_type"><?php echo __('Wysyłaj dla'); ?><a class="help" title="<?php echo __('W przypadku większej ilości produktów w zamówieniu, automatyczna prośba o recenzę będzie wysyłana do jednego produktu.') ?>" href="#"></a></label>                             
                             <select class="support" id="config_send_type" name="config[send_type]">
                                <option value="1" <?php if($config -> get('send_type')==1): ?> selected="selected" <?php endif; ?>><?php echo __('Dla najdroższego produktu'); ?></option>
                                <option value="2" <?php if($config -> get('send_type')==2): ?> selected="selected" <?php endif; ?>><?php echo __('Dla pierwszego'); ?></option>
                            </select>                             
                            <br class="st_clear_all">
                        </div>
               
                        
                        <div class="form-row">
                                <?php echo label_for('config[description]', __('Treść wiadomości'), ''); ?>
                                <?php echo textarea_tag('config[description]', $config -> get('description', null, true), array('size' => '100x3')); ?>                                
                                <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
      
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"'); ?>
                    <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save')); ?>
                <?php echo st_get_admin_actions_foot(); ?>
            </form>
        </div>
    </div>
    <br class="st_clear_all" />
<?php echo st_get_admin_foot(); ?>


<script type="text/javascript">
jQuery(function($) {
  checkActive();  
  $('#config_auto_send').change(function() {
    checkActive();
  });
  
  function checkActive(){
    if($('#config_auto_send').attr('checked')){
        $( "#config_order_status_type" ).prop( "disabled", false );
        
    }else{
        $( "#config_order_status_type" ).prop( "disabled", true );
        
    }  
  }
  
});
</script>