<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php use_stylesheet('/css/update/setup.css?v2'); ?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">
    <?php echo get_partial('menu');?>
    <div class="content">
        <div class="st_head_txt_installer_sync">
            <?php echo __('Test wymagań technicznych serwera');?>
		</div>
		<?php if (!$testsPassed):?>
			<div class="msg-box error">
				<span class="icon alert"></span>
				<span style="vertical-align: middle"><?php echo __('Serwer nie spełnia wymagań technicznych, aktualizacja nie jest możliwa.');?></span>
			</div>
		<?php endif; ?>
    	<div class="stSetup-require-list">
            <?php foreach ($testsStatus as $test=>$status): ?>
    	    <div class="stSetup-require-list-row" >
                <label>
                	<?php echo __($tests->getTestName($test))?>
                </label>
                <div>
                	<?php if ($status):?>
                		<?php if ($tests->getWarning($test)=== false):?>
                			<span class="icon check"></span>
                		<?php else: ?>
                			<?php echo $tests->getWarning($test); $hasWarning = true;?>
                		<?php endif;?>
                	<?php else:?>
                		<span class="icon alert"></span>
                	<?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
    	</div>
    </div>
    <div class="clear"></div>
</div>