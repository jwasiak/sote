<?php if($config->get('invoice_on', stConfig::INT)==1): ?>

<?php $smarty->assign('checkbox_invoice', checkbox_tag('user_data_billing[invoice]', 1, $invoiceRequest, array('id'=>'st_form-user-invoice'))) ?> 

<?php $smarty->assign('invoice_text', __('Chcę otrzymać fakturę VAT')) ?>

<?php endif; ?>


<?php $smarty->display('invoice_request_invoice.html') ?>