<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator', 'stProgressBar') ?>


<?php st_include_partial('stSearchBackend/header', array('related_object' => null, 'title' => __('Optymalizacja', 
array(), 'stSearchBackend'), 'route' => 'stSearchBackend/newConfig')) ?>

<?php st_include_component('stSearchBackend', 'configMenu', array('forward_parameters' => array())) ?>
    
<div id="sf_admin_content">
    <?php st_include_partial('stSearchBackend/config_messages', array('labels' => array(), 'forward_parameters' => array())) ?>
    <p style="clear: both;"><?php echo __("Generowanie wyników wyszukiwania, pozwoli na lepsze wyszukiwanie produktów w sklepie")?></p>
    <?php echo progress_bar('stSearch_optimize', 'stSearchOptimize', 'optimize', $productCount); ?>
</div>
    
<?php st_include_partial('stSearchBackend/footer', array('related_object' => null, 'forward_parameters' => array())) ?>
