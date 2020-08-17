<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin') ?>    
<?php use_helper('stProgressBar'); ?> 
        
<?php use_stylesheet('/css/backend/stInstallerWebPlugin.css?version=1'); ?>
<?php echo st_get_admin_head('stInstallerWebPlugin', __('Uaktualnienia', 
array()), __('Uaktualnij aplikacje w sklepie', 
array()),NULL) ?>  
    <div style="margin:0px 30px;">               
       <?php echo get_partial('menu');?> 
       
       <div class="st_head_txt_installer">   
       <?php echo __('Wyczyszczenie cache'); ?>
       </div>                            
         
       
       <pre><?php 
       print_r($content);
       print_r($error);
       ?></pre>                  
       
    </div>
<?php echo st_get_admin_foot() ?>


