<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin') ?>            
<?php use_stylesheet('/css/backend/stInstallerWebPlugin.css?version=1'); ?>
<?php echo st_get_admin_head('stInstallerWebPlugin', __('Uaktualnienia', 
array()), __('Uaktualnij aplikacje w sklepie', 
array()),NULL) ?>  
    <div style="margin:0px 30px;">               
       <?php echo get_partial('menu');?> 
         
        
        
        <div class="st_head_txt_installer"> 
        <?php if (! empty($apps['all'])): ?>   
            <?php echo __('Zsynchronizowane aplikacje');?>    
        <?php else: ?>
            <?php echo __('Nie ma aplikacji do synchronizacji.');?>    
        <?php endif ?> 
        </div>
        
        
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <?php foreach ($apps['all'] as $app):?>        
        <?php $name=$app;?>
        <tr>
            <td>
                <?php $full_path="images/backend/main/icons/$name.png";?>    
                <?php if (is_file($full_path))
                {
                    echo '<img width="30" height="30" src="/images/backend/main/icons/'.$name.'.png"/>';
                }
                else 
                {
                    echo '<img width="30" height="30" src="/images/backend/installerweb/empty.png"/>';                
                }
                ?>    
                </td>    
                <td width="20%">
                    <?php echo $name; ?>
                </td>                
                <td> 
                    <?php echo stApplication::getAppName($name);?>
                </td>
                </tr>
         <?php endforeach ?>
         </table>
         
        
    </div>
<?php echo st_get_admin_foot() ?>