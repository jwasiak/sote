<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>

<?php echo st_get_admin_head('stOferciakPlugin', __('Generowanie pliku xml'), __('Zarządzanie porównywarką cen Oferciak'), NULL) ?>
    <?php st_include_component('stOferciakBackend', 'listMenu', array('forward_parameters' => $forward_parameters, 'oferciak' => null)) ?>
  

    <div id="sf_admin_header">
        <?php echo stSocketView::openComponents('stOferciakBackend.generateCustom.Header'); ?>
    </div>
    
    <div id="sf_admin_content">
        <?php echo stSocketView::openComponents('stOferciakBackend.generateCustom.Content'); ?>
    </div>
    
    <div id="sf_admin_footer">
        <?php echo stSocketView::openComponents('stOferciakBackend.generateCustom.Footer'); ?>
    </div>
<br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>