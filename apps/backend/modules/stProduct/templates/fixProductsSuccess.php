<?php use_helper('I18N', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin', 'stDate', 'stProgressBar') ?>

<?php echo st_get_admin_head('stProduct', __('Lista produktów', 
array()), __('Zarządzanie produktami w sklepie.', 
array()), array (
  0 => 'stCategory',
  1 => 'stProducer',
  2 => 'stProductGroup',
  3 => 'stReview',
)) ?>       
<div style="text-align: center; margin: 0px auto; width: 200px;">
<?php echo progress_bar('stFixProducts', 'stFixProducts', 'fixProducts', stFixProducts::countProducts()); ?>
</div>
<?php echo st_get_admin_foot() ?>