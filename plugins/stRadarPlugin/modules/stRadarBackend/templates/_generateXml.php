<?php use_helper('stProgressBar'); ?>
<?php if($generate): ?>
    <div id="generateXml">
        <?php echo progress_bar('stRadarGenerateXml', 'stRadar', 'generate', $steps); ?>
    </div>
<?php else: ?>
    <?php echo st_get_admin_actions_head('style="float: left"') ?>
        <?php echo st_get_admin_action('file', __('Generuj plik xml'), 'radar/generateCustom?generate=1', array ('name' => 'sample_file')) ?>
    <?php echo st_get_admin_actions_foot() ?>
<?php endif; ?>