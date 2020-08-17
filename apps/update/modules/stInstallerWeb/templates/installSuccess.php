<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin') ?>

<?php echo st_get_admin_head('stInstallerWebPlugin', __('Uaktualnienia', 
array()), __('Uaktualnij aplikacje w sklepie', 
array()),NULL) ?>  
    <div style="margin:0px 30px;">               
       <?php echo get_partial('menu');?> 
           
        <?php echo $content;?>       
        
    </div>
<?php echo st_get_admin_foot() ?>