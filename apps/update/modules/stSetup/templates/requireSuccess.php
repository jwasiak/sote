<?php use_helper('I18N', 'Date', 'Text', 'Object', 'Validation', 'ObjectAdmin', 'stUpdate') ?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<div id="sf_admin_container">
    <?php include_partial('header');?>
    <div class="bg_content">
    	<div class="stSetup-left_menu">
    	   <?php include_component('stSetup', 'leftMenu', array('step'=>'require')); ?>
    	</div>
    	<div id="stSetup-right_menu">
        	<h2 class="title"><?php echo __('Wymagania techniczne') ?></h2>

        	<div class="stSetup-require-list">
                <?php foreach ($testsStatus as $test=>$status): ?>
        	    <div class="stSetup-require-list-row">
                    <label>
                    	<?php echo __($tests->getTestName($test))?>
                    </label>
                    <div>
                    	<?php if ($status):?>
                    		<?php if ($tests->getWarning($test)=== false):?>
                    			<img src='/images/update/icons/plus.png' alt=''/>
                    		<?php else: ?>
                    			<?php echo $tests->getWarning($test); $hasWarning = true;?>
                    		<?php endif;?>
                    	<?php else:?>
                    	<img src='/images/update/icons/delete.gif' alt=''/>
                    	<?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
        	</div>
          	<?php if (!$testsPassed):?>
          		<img src='/images/update/icons/warn.png' alt=''/>
          		<strong><?php echo __("Wymagania instalacji nie są spełnione, proszę o kontakt z administratorem serwera.");?></strong>
          	<?php endif; ?>
            <div class="stSetup-actions">
                    <?php echo st_get_update_actions_head() ?>
                    <?php echo st_get_update_action('previous', __('Wstecz'), 'stSetup/license') ?>
                    <?php if ($testsPassed): ?>
                        <?php echo st_get_update_action('next', __('Dalej'), 'stSetup/database') ?>
                    <?php endif; ?>
                    <?php echo st_get_update_actions_foot() ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>