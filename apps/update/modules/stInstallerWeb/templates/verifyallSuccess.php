<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">                   
    <?php echo get_partial('menu_tools',array('selected'=>'verifyall'));?>
	<div class="content">    
	    <div class="content_update_box">
		    <h2 class="title"><?php echo __('Weryfikacja systemu', null, 'stInstallerWeb');?></h2>                      
	        <?php echo progress_bar('Verify', 'stAppVerifyall', 'step', stAppVerifyall::getCount());?> 
	    </div>
   	</div>
   	<div class="clear"></div>
</div>