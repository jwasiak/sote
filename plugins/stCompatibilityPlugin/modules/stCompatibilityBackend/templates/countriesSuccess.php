<?php use_helper('I18N', 'stAdminGenerator', 'stJQueryTools', 'stPrice');?>
<?php echo st_get_admin_head('stCompatibilityPlugin', __('Konfiguracja'));?>
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message');?>
        <div id="sf_admin_content_config">
<?php echo form_tag('stCompatibilityBackend/countries', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form'));?>
<?php echo input_hidden_tag("section", $section) ?>
    <?php foreach ($countries as $countrie => $value): ?>
        <div style="float:left; width: 25%; margin-bottom: 20px;">
        <div style="background: #EEEEEE; margin-right: 10px; padding: 3px;">
            
            <?php if($countrie=="AS"){
                $labele = __("Azja");
            }elseif($countrie=="E"){
                $labele = __("Europa");
            }elseif($countrie=="UE"){
                $labele = __("Unia Europejska");
            }elseif($countrie=="AF"){
                $labele = __("Afryka");
            }elseif($countrie=="NA"){
                $labele = __("Ameryka Północna");
            }elseif($countrie=="SA"){
                $labele = __("Ameryka Południowa");
            }elseif($countrie=="AO"){
                $labele = __("Arktyka");
            }
            ?>
            
            <input type="checkbox" id="selectall_<?php echo $countrie; ?>" />
            <?php echo $labele; ?>
        </div>
        
        <div style="overflow:scroll; height: 290px; width: 100%">
        <table width="100%">    
     
        <?php foreach ($value as $count => $country_info): ?>    
            <tr>
                <td><input class="case_<?php echo $countrie; ?>" name="country[<?php echo $count; ?>]" type="checkbox" value="1" <?php if(isset($country_info['is_selected'])): echo 'checked'; endif; ?> /></td>
                <td><?php echo $country_info['name']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>    
    </div></div>
    <script type="text/javascript">
    jQuery(function ($)
    {
        $(document).ready(function()
        {
              // add multiple select / deselect functionality
        $("#selectall_<?php echo $countrie; ?>").click(function () {
              $('.case_<?php echo $countrie; ?>').attr('checked', this.checked);
        });
     
        // if all checkbox are selected, check the selectall checkbox
        // and viceversa
        $(".case_<?php echo $countrie; ?>").click(function(){
     
            if($(".case_<?php echo $countrie; ?>").length == $(".case_<?php echo $countrie; ?>:checked").length) {
                $("#selectall_<?php echo $countrie; ?>").attr("checked", "checked");
            } else {
                $("#selectall_<?php echo $countrie; ?>").removeAttr("checked");
            }
     
        });
        });
    });
    </script>
    
    <?php endforeach; ?>
    <div class="st_clear_all"></div>
    <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"');?>
        <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save'));?>
    <?php echo st_get_admin_actions_foot();?>
</form>
</div></div>
<?php echo st_get_admin_foot();?>