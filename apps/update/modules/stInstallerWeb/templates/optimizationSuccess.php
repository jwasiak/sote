<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update">
	<?php echo get_partial('menu');?>
	<div id="sf_admin_container">
	    <div class="box_content">
		    <div class="st_head_txt_installer">
		        <?php echo __('Optymalizacja i czyszczenie instalacji');?>
		    </div>
	       	<?php echo progress_bar('stCleanInstallerDownload', 'stCleanInstallerDownload', 'step', stCleanInstallerDownload::getSteps());?>
	    	<?php echo progress_bar('stCleanInstallerSrc', 'stCleanInstallerSrc', 'step', stCleanInstallerSrc::getSteps());?>
		</div>
		<div class="clear"></div>
	</div>
</div>
