<?php use_helper('stAdminGenerator', 'stProgressBar');?>
<?php use_stylesheet('backend/stProgressBarPlugin/stProgressBarPlugin.css');?>
<?php use_stylesheet('backend/stAllegroPlugin.css');?>
<?php st_include_partial('stAllegroBackend/header', array('title' => __('Import zamówień'), 'culture' => null, 'route' => 'stAllegroBackend/importOrder'));?>
<?php st_include_component('stAllegroBackend', 'listMenu');?>

<div id="sf_admin_content">
    <?php if($count > 0): ?>
        <?php echo progress_bar('stAllegroPluginImportOrder', 'stAllegroOrderBar', 'importOrder', $count); ?>
    <?php else:?>
        <div style="min-height: 50px; border: 1px solid #ccc; padding: 10px;">
            <p style="text-align: center; font-family: Helvetica,Arial,sans-serif; font-size: 12px; padding-top: 15px;"><?php echo __("Brak nowych zamówień do importu");?></p>
        </div>
    <?php endif;?>
</div>

<?php st_include_partial('stAllegroBackend/footer', array('related_object' => null));?>