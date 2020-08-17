<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>

<?php echo st_get_admin_head('stSklepy24Plugin', __('Generowanie pliku xml'), __('Zarządzanie porównywarką cen Sklepy24'), NULL) ?>
    <?php st_include_component('stSklepy24Backend', 'listMenu', array('forward_parameters' => $forward_parameters, 'sklepy24' => null)) ?>
  

    <div id="sf_admin_header">
        <?php echo stSocketView::openComponents('stSklepy24Backend.generateCustom.Header'); ?>
    </div>
    
    <div id="sf_admin_content">
        <?php echo stSocketView::openComponents('stSklepy24Backend.generateCustom.Content'); ?>
    </div>
    
    <div id="sf_admin_footer">
        <?php echo stSocketView::openComponents('stSklepy24Backend.generateCustom.Footer'); ?>
    </div>
<br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>