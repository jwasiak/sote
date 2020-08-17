<?php
// auto-generated by sfPropelAdmin
// date: 2019/09/24 12:55:00
?>

<?php use_helper('I18N', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin', 'stDate') ?>



<?php
?>

<?php st_include_partial('stInvoiceBackend/header', array('related_object' => $related_object, 'title' => __('Faktury proforma.', 
array(), 'stInvoiceBackend'), 'route' => 'stInvoiceBackend/proformaList')) ?>

<?php st_include_component('stInvoiceBackend', 'listMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object)) ?>

<?php echo st_get_component('stSecurityBackend','showUncryptInvoiceCustomer'); ?>
<?php echo st_get_component('stSecurityBackend','showUncryptInvoiceSeller'); ?>

<div id="sf_admin_content">
    <?php st_include_partial('stInvoiceBackend/list_messages', array('pager' => $pager, 'forward_parameters' => $forward_parameters, 'labels' => $labels)) ?>
    <?php $list_actions = st_get_partial('proforma_list_actions', array('pager' => $pager, 'forward_parameters' => $forward_parameters)) ?> 

    <div style="display: table; width: 100%; clear: both;">     
    <?php if ($pager->getNbResults() > 10 || $filters): ?>
    <?php st_include_partial('stInvoiceBackend/proforma_list_filters', array('filters' => $filters, 'forward_parameters' => $forward_parameters)) ?>   
    <?php endif; ?>
    <?php echo form_tag('stInvoiceBackend/proformaList', array('id' => 'record_list_form', 'class' => 'admin_form')) ?>
        <?php echo input_hidden_tag('page', $pager->getPage()) ?>   
     
    <?php if ($pager->getNbResults() || $filters): ?>
    <?php st_include_partial('stInvoiceBackend/proforma_list_pager', array('pager' => $pager, 'forward_parameters' => $forward_parameters, 'url' => st_url_for('stInvoiceBackend/proformaList'), 'prefix' => 'head')) ?>    
    <?php st_include_partial('stInvoiceBackend/proforma_list', array('pager' => $pager, 'forward_parameters' => $forward_parameters, 'invoice_action_select_options' => $invoice_action_select_options)) ?>
    <?php else: ?>
    <?php st_include_partial('stInvoiceBackend/proforma_list_empty_message', array('pager' => $pager, 'forward_parameters' => $forward_parameters)) ?>
    <?php endif; ?>    
    <div id="list_actions">
    <?php if ($pager->getNbResults() || $filters): ?>  
        <div class="float_left"><?php st_include_partial('stInvoiceBackend/proforma_list_select_control', array('pager' => $pager, 'forward_parameters' => $forward_parameters, 'invoice_action_select_options' => $invoice_action_select_options)) ?></div>       
    <?php endif; ?>       
        <?php echo $list_actions ?>
    </div>
    </form>

    </div>
    <div class="clr"></div>
</div>

<?php st_include_partial('stInvoiceBackend/footer', array('related_object' => $related_object)) ?>
<script type="text/javascript">
jQuery(function($) {
      $('#list_actions').stickyBox();
});
</script>