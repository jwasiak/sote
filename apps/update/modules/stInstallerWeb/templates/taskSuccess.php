<?php use_helper('I18N', 'Date', 'Text', 'Object', 'Validation', 'ObjectAdmin') ?>            
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">              
       <?php echo get_partial('menu');?> 
       <div class="content">
        
                <div class="st_head_txt_installer">   
                Symfony tasks
                </div>       
                Run task:
                <?php echo form_tag('stInstallerWeb/task')?>
                <?php echo input_tag('task','','size=60') ?>    
                </form>                      
                                           
                <?php if (! empty($task)) :?>
                <b><?php echo $task ?></b><br />
                <pre>

        <?php echo $content;?> 
                
        --
        <?php echo $error;?>      
                </pre>
                <?php endif ?>       
        </div>
        <div class="clear"></div>                         
</div>