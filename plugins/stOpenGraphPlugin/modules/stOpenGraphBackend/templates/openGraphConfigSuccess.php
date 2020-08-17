
<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>

<?php echo st_get_admin_head('stOpenGraphPlugin', __('Konfiguracja'), array('shortcuts' => array (), 'culture' => $config->getCulture(), 'route' => 'stOpenGraphConfigBackend/openGraphConfig')) ?>

    

	<?php if ($sf_flash->has('notice')): ?>
        <div class="save-ok">
        <h2><?php echo __($sf_flash->get('notice'), null, 'stAdminGeneratorPlugin') ?></h2>
        </div>
    <?php endif; ?>
    
    <div id="sf_admin_content">
    
    <?php echo form_tag('stOpenGraphBackend/openGraphConfig?culture='.$config->getCulture(), array("enctype"=>"multipart/form-data")) ?>

    <div class="fieldset">
        <h2><?php echo __('Konfiguracja dla strony głównej sklepu') ?></h2>
            
        <div class="content">                        

            
            <div class="form-row">
              <label><?php echo __('Zdjęcie promujące sklep') ?>: <a class="help" title="<?php echo __('Minimalny rozmiar: 200x200px. Zalecany rozmiar: 600x315px lub 1200x630px.') ?>" href="#"></a></label>
              <div class="content">
              <?php echo input_file_tag("og[image]", ""); ?><br/>
              <?php if ($config->get('image', null, true)!=""): ?>
              <img src="/uploads<?php echo $config->get('image', null, true); ?>" alt="" style="width: 250px; margin-top: 7px;" ><br/>
              <?php echo link_to(__('Usuń zdjęcie'),'stOpenGraphBackend/deleteImage?image&culture='.$config->getCulture())?>                   
              <br class="st_clear_all">
              <?php endif; ?>          
              </div>          
            </div>
            
            <div class="form-row">
              <label><?php echo __('Tytuł promujący sklep') ?>:</label>
              <div class="content">
                <?php echo input_tag('og[title]',$config->get('title', null, true), array("size"=>"80")) ?>                  
               <br class="st_clear_all">
              </div>
            </div>
            
            <div class="form-row">
              <label><?php echo __('Opis promujący sklep') ?>:</label>
              <div class="content">
               <?php echo textarea_tag("og[text]", $config->get('text', null, true), array ( 'size' => '80x6')) ?>
               <br class="st_clear_all">
              </div>
            </div>  
            
                        
        </div>        
    </div>      
    
    <div id="list_actions" >
                         
            <ul class="admin_actions" style="margin-top: 10px;">     
            <?php echo st_get_admin_actions_head() ?>        
                <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin')) ?>                
            <?php echo st_get_admin_actions_foot() ?>
            </ul>
            <div class="clr"></div>            
    </div>



</form>
</div>

<?php echo st_get_admin_foot() ?>

<script type="text/javascript">
jQuery(function($) {
      $('#list_actions').stickyBox();
});
</script>