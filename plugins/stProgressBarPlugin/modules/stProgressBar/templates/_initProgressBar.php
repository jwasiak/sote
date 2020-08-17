<?php use_helper('stProgressBar'); ?>
<?php use_stylesheet('backend/stProgressBarPlugin/stProgressBarPlugin.css?v3'); ?>
<div id="stProgressBar-<?php echo $name ?>" class="progress-bar">
    <div id="progress-bar">
        <span class="bar_title"><?php echo (@$title=='')?__('Pasek postępu:', null, 'stProgressBar'):$title; ?></span>
        <div class="stPrograssBar-main-div">
            <div>
                <div class="stProgressBar-text-div">0.0%</div>
            </div>
        </div>
    </div>
    <div id="stProgressBar-<?php echo trim($name); ?>message">
        <?php echo (!empty($msg))?$msg:$sf_flash->get('stProgressBar-'.$name); ?>
    </div>
</div>
