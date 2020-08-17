<?php use_helper('stProgressBar');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=2');?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">
    <?php echo get_partial('menu_home',array('selected'=>'upgradeList'));?>
    <div class="content">
    	<h2 class="title">
            <?php echo __('Pobierz', null, 'stInstallerWeb');?>
        </h2>
	    <div class="content_update_box">      
	        <h2 class="subhead_txt_module">
                <?php echo __('Pobieranie aktualizacji');?>
            </h2>
	        <?php echo progress_bar('stPackageDownloader', 'stPackageDownloader', 'step', stPackageDownloader::getSteps()); ?>
	        <div class="clear"></div>
	    </div>
	</div>
</div>