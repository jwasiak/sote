<?php $bannerConfig = stConfig::getInstance(sfContext::getInstance(), 'stSlideBannerBackend'); ?>

<?php if($bannerConfig->get('banner_version')!=2): ?>
<script type="text/javascript">
jQuery(function ($)
{
    $(document).ready(function()
    {           
        $( "#sf_fieldset_zach__cenie_do_podj__cia_akcji__cta_call_to_action__" ).hide();
        
        $( "#sf_fieldset_zach__cenie_do_podj__cia_akcji__cta_call_to_action__ #mceu_4-button" ).hide();        
        $( "#sf_fieldset_zach__cenie_do_podj__cia_akcji__cta_call_to_action__ #mceu_5-button" ).hide();        
        
    });
});
</script>
<?php endif; ?>    

<select include_blank="" id="slide_banner_banner_description_position" name="slide_banner[banner_description_position]">
    
<option class="none" value="0" <?php if($slide_banner->getBannerDescriptionPosition()==0){ echo " selected";} ?>><?php echo __('Ciemny') ?></option>
<option class="none" value="1" <?php if($slide_banner->getBannerDescriptionPosition()==1){ echo " selected";} ?>><?php echo __('Jasny') ?></option>    
    
</select>