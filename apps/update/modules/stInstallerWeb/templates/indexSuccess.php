<?php //use_helper('I18N', 'Date', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin') ?>            
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
    <div style="margin:0px 30px;">               
       <?php echo get_partial('menu');?> 
           
        <?php echo $content;?>       
        
    </div>
<?php //echo st_get_admin_foot() ?>