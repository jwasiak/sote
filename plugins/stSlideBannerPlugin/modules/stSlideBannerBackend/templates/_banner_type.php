

<select include_blank="" id="slide_banner_banner_type" name="slide_banner[banner_type]">
    
<option class="none" value="0" <?php if($slide_banner->getBannerType()==0){ echo " selected";} ?>><?php echo __('responsive / desktop') ?></option>
<option class="none" value="1" <?php if($slide_banner->getBannerType()==1){ echo " selected";} ?>><?php echo __('Tylko desktop') ?></option>
<option class="none" value="2" <?php if($slide_banner->getBannerType()==2){ echo " selected";} ?>><?php echo __('Tylko responsive') ?></option>    
    
</select>