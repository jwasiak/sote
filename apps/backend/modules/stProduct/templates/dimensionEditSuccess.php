<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'VisualEffect', 'stAdminGenerator', 'stDate') ?>

<?php
sfLoader::loadHelpers('stDeliveryBackend', 'stDeliveryBackend');
?>

<?php st_include_partial('stProduct/header', array('related_object' => $related_object, 'title' => $product_dimension->isNew() ? __('Dodaj nowy rozmiar', 
array(), 'stProduct') : __('Edycja rozmiaru', 
array(), 'stProduct'), 'route' => 'stProduct/dimensionEdit?id='.$product_dimension->getId())) ?>

<div id="sf_admin_content">
   <?php st_include_partial('stProduct/edit_messages', array('product_dimension' => $product_dimension, 'labels' => $labels, 'forward_parameters' => $forward_parameters)) ?>
   <?php st_include_partial('stProduct/dimension_edit_form', array('product_dimension' => $product_dimension, 'labels' => $labels, 'forward_parameters' => $forward_parameters, 'related_object' => $related_object)) ?>
</div>

<?php st_include_partial('stProduct/footer', array('related_object' => $related_object, 'forward_parameters' => $forward_parameters)) ?>