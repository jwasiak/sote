<?php use_helper('stProgressBar'); ?>
<?php if($generate): ?>
    <div id="generateXml">
        <?php echo progress_bar('stBazzarGenerateXml', 'stBazzar', 'generate', $steps); ?>
    </div>
<?php else: ?>
    <?php echo st_get_admin_actions_head('style="float: left"') ?>
        <?php if($checkedConfig): ?>
            <?php echo st_get_admin_action('file', __('Generuj plik xml'), 'bazzar/generateCustom?generate=1', array ('name' => 'sample_file')) ?>
        <?php else: ?>
            <?php echo __('Porównywarka cen nie została skonfigurowana.') ?>
        <?php endif; ?>            
    <?php echo st_get_admin_actions_foot() ?>
<?php endif; ?>