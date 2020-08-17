<?php use_helper('I18N', 'Date', 'Text', 'Object', 'Validation', 'ObjectAdmin', 'stUpdate') ?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<div id="sf_admin_container">
    <?php include_partial('header');?>
    <div class="bg_content">
    	<div class="stSetup-left_menu">
    	   <?php include_component('stSetup', 'leftMenu', array('step'=>'dbdata')); ?>
    	</div>
    	<div id="stSetup-right_menu">	
        	<h2 class="title"><?php echo __('Budowanie bazy danych')?></h2>
        	<?php echo progress_bar('stBuildDb', 'stBuildDb', 'step', stBuildDb::getSteps()); ?>	
            <div class="stSetup-actions" id="stSetup-dbdata_actions" style="visibility: hidden;"> 
                    <?php echo st_get_update_actions_head() ?>
                    <?php echo st_get_update_action('next', __('Dalej'), 'stSetup/settings') ?>                  
                    <?php echo st_get_update_actions_foot() ?>              
            </div>
        </div>   
        <div class="clear"></div> 	
    </div>
</div>