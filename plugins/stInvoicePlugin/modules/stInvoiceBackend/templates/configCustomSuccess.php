<?php
// auto-generated by sfPropelAdmin
// date: 2013/01/10 15:35:55
?>
<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>

<?php st_include_partial('stInvoiceBackend/header', array('title' => __('Konfiguracja', 
array(), 'stInvoiceBackend'), 'culture' => $invoiceDefault->getCulture(), 'route' => 'stInvoiceBackend/configCustom')) ?>

<?php
?>

<?php st_include_component('stInvoiceBackend', 'customMenu', array('forward_parameters' => $forward_parameters)) ?>
  

<div id="sf_admin_header">
   <?php echo stSocketView::openComponents('stInvoiceBackend.configCustom.Header'); ?>
</div>
    
<div id="sf_admin_content">
   <?php st_include_partial('stInvoiceBackend/custom_messages', array('forward_parameters' => $forward_parameters)) ?>
   <?php echo stSocketView::openComponents('stInvoiceBackend.configCustom.Content'); ?>
</div>
    
<div id="sf_admin_footer">
   <?php echo stSocketView::openComponents('stInvoiceBackend.configCustom.Footer'); ?>
</div>
<?php st_include_partial('stInvoiceBackend/footer', array('forward_parameters' => $forward_parameters)) ?>