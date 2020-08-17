<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>

<?php echo st_get_admin_head('stCeneoPlugin', __('Generowanie pliku xml'), __('Zarządzanie porównywarką cen Ceneo'), null) ?>
    <?php st_include_component('stCeneoBackend', 'listMenu', array('forward_parameters' => $forward_parameters, 'ceneo' => null)) ?>
  

    <div id="sf_admin_header">
        <?php echo stSocketView::openComponents('stCeneoBackend.generateCustom.Header'); ?>
    </div>
    
    <div id="sf_admin_content">
        <?php echo stSocketView::openComponents('stCeneoBackend.generateCustom.Content'); ?>
    </div>
    
    <div id="sf_admin_footer">
        <?php echo stSocketView::openComponents('stCeneoBackend.generateCustom.Footer'); ?>
    </div>
<br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>