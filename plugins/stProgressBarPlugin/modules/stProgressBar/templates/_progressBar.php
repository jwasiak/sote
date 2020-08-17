<div id="progress_bar">
	<span class="bar_title"><?php echo (@$title=='')?__('Pasek postępu:', null, 'stProgressBar'):$title; ?></span>
	<div class="stPrograssBar-main-div">
	    <div class="stProgressBar-progress-div" style="width: <?php echo $complete ?>%;">
	        <div class="stProgressBar-text-div">
	            <?php echo $complete ?>%
	        </div>
	    </div>
	</div>
	<?php echo (!empty($msg))?$msg:$sf_flash->get('stProgressBar-'.$name); ?>
</div>
