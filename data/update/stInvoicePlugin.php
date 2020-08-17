<?php
try {
   if (version_compare($version_old, '1.1.0.19', '<'))
   {
        $context = sfContext::getInstance();

        $invoiceConfig = stConfig::getInstance($context, 'stInvoiceBackend');

        $invoiceConfig->set('seller_full_name', $invoiceConfig->get('seller_name')." ".$invoiceConfig->get('seller_surname'));

        $seller_flat = '';
        if($invoiceConfig->get('seller_flat')!="")
        {
            $seller_flat = "/".$invoiceConfig->get('seller_flat');
        }

        $invoiceConfig->set('seller_address', $invoiceConfig->get('seller_street')." ".$invoiceConfig->get('seller_house').$seller_flat);

        $invoiceConfig->save(true);
   }
   
   
} catch (Exception $e) {}