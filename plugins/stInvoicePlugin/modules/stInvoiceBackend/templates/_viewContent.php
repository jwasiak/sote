<?php use_stylesheet("backend/stInvoiceBackend.css"); ?>
<?php use_helper('stCurrency') ?>

<?php st_include_partial('stAdminGenerator/message') ?>
<?php $sf_user->getAttributeHolder()->remove('warning', 'symfony/flash') ?>

<div style="width: 98.2%; border: 1px solid #ccc; padding: 10px;">
<div style="border: 1px solid #EEEEEE; margin: 0px auto; padding: 15px; width: 830px;">

   <div style="float:left; width: 400px;">
      <?php echo $invoice->getCompanyDescription(); ?>   
   </div>

   <div style=" float:right; width: 300px;">

      <div class="st_invoice_frame" >

         <div class="st_invoice_frame_header" >
            <?php echo __('Miejsce wystawienia') ?>:
         </div>

         <div class="st_invoice_frame_content" >
            <?php echo $invoice->getTown(); ?>           
         </div>

      </div>

      <div class="st_invoice_frame" >

         <div class="st_invoice_frame_header" >
            <?php echo $config->get('date_label', null, true); ?>:
         </div>

         <div class="st_invoice_frame_content" >
            <?php echo $invoice->getDateSelle(); ?>   
         </div>

      </div>

      <div class="st_invoice_frame" >

         <div class="st_invoice_frame_header" >
             <?php echo __('Data wystawienia') ?>:
            
         </div>

         <div class="st_invoice_frame_content_last" >
            <?php echo $invoice->getDateCreateCopy(); ?>   
         </div>

      </div>

   </div>
   <br class="st_clear_all">

   <br><br>

   <div style=" float:left; width: 400px;">

      <div class="st_invoice_frame" style="width: 100%;">

         <div class="st_invoice_frame_header" >
            <?php echo __('Sprzedawca') ?>:
         </div>

         <div class="st_invoice_frame_content_last" style="text-align:left;">

            <span><?php echo $InvoiceUserSeller->getCompany(); ?></span><br>

            <?php if ($InvoiceUserSeller->getCompany() == ""): ?>
               <span><?php echo $InvoiceUserSeller->getFullName(); ?></span><br>
            <?php endif; ?>

            <span><?php echo $InvoiceUserSeller->getAddress(); ?></span><br>
            <?php if ($InvoiceUserSeller->getAddressMore() != ""): ?>
               <span><?php echo $InvoiceUserSeller->getAddressMore(); ?></span><br>
            <?php endif; ?>
            <?php if ($InvoiceUserSeller->getRegion() != ""): ?>
               <span><?php echo $InvoiceUserSeller->getRegion(); ?></span><br>
            <?php endif; ?>
            <span><?php echo $InvoiceUserSeller->getCode(); ?> <?php echo $InvoiceUserSeller->getTown(); ?> <?php echo $InvoiceUserSeller->getCountry(); ?><br>          </span>
            <span><?php echo __('NIP') ?>: <?php echo $InvoiceUserSeller->getVatNumber(); ?></span>
         </div>

      </div>

   </div>

   <div style=" float:right; width: 400px;">

      <div class="st_invoice_frame" style="width: 100%;">

         <div class="st_invoice_frame_header" >
            <?php echo __('Nabywca') ?>:
         </div>

         <div class="st_invoice_frame_content_last" style="text-align:left;">
            <?php if ($InvoiceUserCustomer->getCompany() != ""): ?>
            <span><?php echo $InvoiceUserCustomer->getCompany(); ?></span><br>
            <?php endif; ?>
            <?php if ($InvoiceUserCustomer->getCompany() == ""): ?>
               <span><?php echo $InvoiceUserCustomer->getFullName(); ?></span><br>
            <?php endif; ?>
            <span><?php echo $InvoiceUserCustomer->getAddress(); ?></span><br>
            <?php if ($InvoiceUserCustomer->getAddressMore() != ""): ?>
               <span><?php echo $InvoiceUserCustomer->getAddressMore(); ?></span><br>
            <?php endif; ?>
            <?php if ($InvoiceUserCustomer->getRegion() != ""): ?>
               <span><?php echo $InvoiceUserCustomer->getRegion(); ?></span><br>
            <?php endif; ?>
            <span><?php echo $InvoiceUserCustomer->getCode(); ?> <?php echo $InvoiceUserCustomer->getTown(); ?> <?php echo $InvoiceUserCustomer->getCountry(); ?><br></span>
            <?php if ($InvoiceUserCustomer->getVatNumber() != ""): ?>
            <span><?php echo __('NIP') ?>: <?php echo $InvoiceUserCustomer->getVatNumber(); ?></span><br>
            <?php endif; ?>
            <?php if ($InvoiceUserCustomer->getPesel() != ""): ?>
            <span><?php echo __('PESEL') ?>: <?php echo $InvoiceUserCustomer->getPesel(); ?></span><br>
            <?php endif; ?>

         </div>

      </div>

   </div>
   <br class="st_clear_all">

   <br><br>

   <div id="st_invoice_number">
      <?php echo $config->get('invoice_label', null, true); ?>
      <?php echo $invoice->getNumber(); ?>
   </div>

   <br>

   <table border="0" cellpadding="0" cellspacing="0" width="100%" class="st_invoice_table">
      <tr>
         <td width="10px" class="st_invoice_table_head"><?php echo __('Lp') ?></td>
         
         <td width="50px" class="st_invoice_table_head"><?php echo __('Kod') ?></td>

         <td width="150px" class="st_invoice_table_head"><?php echo __('Nazwa') ?></td>

         <td class="st_invoice_table_head"><?php echo __('Ilość') ?></td>

         <td class="st_invoice_table_head"><?php echo __('j.m.') ?></td>

         <td class="st_invoice_table_head"><?php echo __('Cena jed.') ?><br/><?php echo __('netto') ?></td>

         <td class="st_invoice_table_head"><?php echo __('Cena jed.') ?><br/><?php echo __('brutto') ?></td>

         <td class="st_invoice_table_head"><?php echo __('VAT') ?><br/>[%]</td>

         <td class="st_invoice_table_head"><?php echo __('Wartość netto') ?></td>

         <td class="st_invoice_table_head"><?php echo __('VAT') ?></td>

         <td class="st_invoice_table_head"><?php echo __('Wartość brutto') ?></td>
      </tr>
      <?php $i = 0; ?>
      <?php foreach ($invoiceProducts as $product)
      { ?>

         <tr>
            <td class="st_invoice_table_td" style="text-align:center;"><?php $i++; ?><?php echo $i; ?></td>
            
            <td class="st_invoice_table_td" style="text-align:left;"><?php echo $product->getCode(); ?></td>

            <td class="st_invoice_table_td" style="text-align:left;"><?php echo $product->getName(); ?></td>

            <td class="st_invoice_table_td" style="text-align:center;"><?php echo $product->getQuantity(); ?></td>

            <td class="st_invoice_table_td" style="text-align:center;"><?php echo $product->getMeasureUnit(); ?></td>

            <td class="st_invoice_table_td"><?php echo st_back_price($product->getPriceNetto()) ?></td>

            <td class="st_invoice_table_td"><?php echo st_back_price($product->getPriceBrutto()) ?></td>

            <td class="st_invoice_table_td" style="text-align:center;"><?php echo $product->getVat()->getVatName() ?></td>

            <td class="st_invoice_table_td"><?php echo st_back_price($product->getTotalPriceNetto()) ?></td>

            <td class="st_invoice_table_td"><?php echo st_back_price($product->getVatAmmount()) ?></td>

            <td class="st_invoice_table_td"><?php echo st_back_price($product->getOptTotalPriceBrutto()) ?></td>
         </tr>

<?php } ?>

   </table>
   <br>
   <?php if (!$invoice->getIsProforma()): ?>
   
   <div>
      <div style="float:right; width:550px;">
         <table border="0" cellpadding="0" cellspacing="0" width="100%" class="st_invoice_table">
            <tr>
               <td width="200px" class="st_invoice_table_head"><?php echo __('według stawki VAT') ?></td>

               <td class="st_invoice_table_head"><?php echo __('wartość netto') ?></td>

               <td class="st_invoice_table_head"><?php echo __('kwota VAT') ?></td>

               <td class="st_invoice_table_head"><?php echo __('wartość brutto') ?></td>
            </tr>
            <?php $i = 0; ?>
            <?php
            $sumTotalNetto = 0;
            $sumTotalAmmountVat = 0;
            $sumTotalBrutto = 0;
            ?>
<?php foreach ($taxProducts as $taxProduct)
{ ?>

               <tr>
                  <td class="st_invoice_table_td" style="text-align:left;">
                     <?php if ($taxProduct['is_default'] == 1): ?>
                        <?php echo __('Podstawowy podatek VAT') ?> <?php echo $taxProduct['vat_name'] ?>
                     <?php else: ?>
      <?php echo __('Podatek VAT') ?> <?php echo $taxProduct['vat_name'] ?>
   <?php endif; ?>

                  </td>

                  <td class="st_invoice_table_td" style="text-align:right;"><?php echo st_back_price($taxProduct['total_netto']) ?></td>

                  <td class="st_invoice_table_td" style="text-align:right;"><?php echo st_back_price($taxProduct['total_ammount_vat']) ?></td>

                  <td class="st_invoice_table_td" style="text-align:right;"><?php echo st_back_price($taxProduct['total_brutto']) ?></td>
               </tr>

               <?php
               $sumTotalNetto += stCurrency::formatPrice($taxProduct['total_netto']);
               $sumTotalAmmountVat += stCurrency::formatPrice($taxProduct['total_ammount_vat']);
               $sumTotalBrutto += stCurrency::formatPrice($taxProduct['total_brutto']);
               ?>
<?php } ?>

            <tr>
               <td class="st_invoice_table_td" style="border-color: #fff; text-align:right;"><?php echo __('Razem') ?>:</td>

               <td class="st_invoice_table_td" style="border-color: #fff; text-align:right;"><?php echo st_back_price($sumTotalNetto) ?></td>

               <td class="st_invoice_table_td" style="border-color: #fff; text-align:right;"><?php echo st_back_price($sumTotalAmmountVat) ?></td>

               <td class="st_invoice_table_td" style="border-color: #fff; text-align:right;"><?php echo st_back_price($sumTotalBrutto) ?></td>
            </tr>

         </table>
         <br>
      </div>
      <br class="st_clear_all">
      <?php endif ?>
      <div class="st_invoice_frame" style="float:right; width:450px;">
         <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 16px">
<?php if ($invoice->getIsProforma() && $invoice->hasDiscount() && $invoice->getTotalDiscountAmount() > 0): ?>
            <tr>
               <td><?php echo __('Razem') ?>:</td>
               <td style="text-align: right"><?php echo st_back_price($invoice->getTotalAmount(false))." ".$shortcut ?></td>
            </tr>
            <tr>
               <td><?php echo __('Rabat', null, 'stOrder') ?>:</td>
               <td style="text-align: right">-<?php echo st_back_price($invoice->getTotalDiscountAmount())." ".$shortcut ?></td>
            </tr>            
<?php endif ?>
            <tr class="st_invoice_frame_header" style="font-weight: bold;">
               <td style="text-align: left"><?php echo __('Razem do zapłaty') ?>:</td>
               <td style="text-align: right"><?php echo st_back_price($invoice->getTotalAmount())." ".$shortcut; ?></td>
            </tr>
         </table>
         <?php if($culture=='pl_PL'): ?>
         <div class="st_invoice_frame_content_last" style="text-align:left;">
            <?php echo __('Słownie') ?>: &nbsp; <?php
            $ammountArr1 = explode('.', $invoice->getTotalAmount());

            $ammountArr2 = explode('.', number_format($invoice->getTotalAmount(), 2));

            echo ( @stInvoice::getAmmountWord($ammountArr1[0]) . " " . $shortcut . " " . $ammountArr2[1] . '/100' );
            ?>
         </div>
         <?php endif; ?>
      </div>

      <div class="st_invoice_frame" style="float:left; width:400px;">
         <table cellspacing="0" cellpadding="0">
            <?php if ($status->getPaidAmount() > 0): ?>
               <tr>
                  <td><b><?php echo __("Zapłacono"); ?>:</b></td>
                  <td style="padding-left: 10px"><?php echo st_back_price($paid_amount)." ".$shortcut ?></td>
               </tr>
               <tr>
                  <td><b><?php echo __("Pozostało do zapłaty"); ?>:</b></td>
                  <td style="padding-left: 10px"><b><?php echo st_back_price($unpaid_amount)." ".$shortcut ?></b></td>
               </tr>
            <?php else: ?>
               <tr>
                  <td><b><?php echo __("Do zapłaty"); ?>:</b></td>
                  <td style="padding-left: 10px"><?php echo st_back_price($paid_amount)." ".$shortcut ?></td>
               </tr>
            <?php endif; ?>
         </table>
         <div style="float:left;">
            <?php if($invoice->getPaymentType()!="none"): ?>
               
               <?php echo __("płatność"); ?>
               
                <?php if($invoice->getPaymentType()=="cash"): ?>
                  <?php echo __("gotówką"); ?>
               <?php endif; ?>
               
               <?php if($invoice->getPaymentType()=="transfer_on_delivery"): ?>
                  <?php echo __("za pobraniem"); ?>
               <?php endif; ?>
               
               <?php if($invoice->getPaymentType()=="transfer"): ?>
                  <?php echo __("przelewem"); ?>
               <?php endif; ?>
               
               <?php if($invoice->getPaymentType()=="transfer_zagiel"): ?>
                  <?php echo __("Żagiel - eRaty"); ?>
               <?php endif; ?>
               
              <?php if($invoice->getPaymentType()=="transfer_przelewy24"): ?>
                  <?php echo __("Przelewy24"); ?>
               <?php endif; ?>
               
               <?php if($invoice->getPaymentType()=="transfer_polcard"): ?>
                  <?php echo __("Polcard"); ?>
               <?php endif; ?>
               
              <?php if($invoice->getPaymentType()=="transfer_payu"): ?>
                  <?php echo __("PayU"); ?>
               <?php endif; ?>
               
              <?php if($invoice->getPaymentType()=="transfer_moneybookers"): ?>
                  <?php echo __("Moneybookers"); ?>
               <?php endif; ?>
               
               <?php if($invoice->getPaymentType()=="transfer_lukas"): ?>
                  <?php echo __("LUKAS Raty"); ?>
               <?php endif; ?>
               
               <?php if($invoice->getPaymentType()=="transfer_ecard"): ?>
                  <?php echo __("eCard"); ?>
               <?php endif; ?>
               
               <?php if($invoice->getPaymentType()=="transfer_dotpay"): ?>
                  <?php echo __("Dotpay"); ?>
               <?php endif; ?>
               
              <?php if($invoice->getPaymentType()=="transfer_paypal"): ?>
                  <?php echo __("Paypal"); ?>
               <?php endif; ?>
               
            <?php endif; ?>

            <?php if($invoice->getMaxDay()!="none"): ?>
            <?php echo __("termin płatności"); ?> <?php echo $invoice->getMaxDay() ?> <?php echo __("dni"); ?>
            <?php endif; ?>
         </div>
      </div>  

      <br class="st_clear_all">    
    <br>
     <?php echo $invoice->getInvoiceDescription(); ?>  


   <br><br>

   <div style="float:left; width: 340px; text-align:center;">

      <div class="st_invoice_frame_signature" style="width: 100%;">

         <div class="st_invoice_frame_header_signature" >
            <?php echo __('Wystawił(a)') ?>:
         </div>

         <div class="st_invoice_frame_content_signature" >
            <?php echo $invoice->getSignatureSeller(); ?>   
            <br><br><br><br>
         </div>

      </div>

      <div style="font-size:9px">
         <?php echo __('Podpis osoby upoważnionej do wystawiania faktury VAT') ?>
      </div>

   </div>

   <div style="float:right; width: 340px; margin-right:6px; text-align:center;">

      <div class="st_invoice_frame_signature" style="width: 100%;">

         <div class="st_invoice_frame_header_signature" >
            <?php echo __('Odebrał(a)') ?>:
         </div>

         <div class="st_invoice_frame_content_signature" >
            <?php echo $invoice->getSignatureCustomer(); ?>   
            <br><br><br><br>
         </div>

      </div>

      <div style="font-size:9px">
         <?php echo __('Podpis osoby upoważnionej do odbioru faktury VAT') ?>
      </div>
   </div>
   
   <br class="st_clear_all">
   </div>
</div>

<?php echo st_get_admin_actions_head() ?>

<li class="action-add"><input type="button" onclick="document.location.href='<?php echo "/backend.php/invoicePdf/id/".$invoice->getId()."/download/true" ?>'" value="<?php echo __('Pobierz') ?>" style="background-image: url(/images/backend/icons/pdf_download_icon.png)"></li>
<li><?php echo st_get_admin_culture_picker(array('url' => 'stInvoicePdf/show?id='.$invoice->getId().'&download=true', 'culture' => sfContext::getInstance()->getUser()->getCulture() )); ?></li>

<?php echo st_get_admin_action('list', __('Pokaż zamówienie'), "stOrder/edit?id=" . $invoice->getOrderId()) ?>

<?php if ($invoiceType == "proforma"): ?>
   <?php echo st_get_admin_action('add', __('Wystaw fakture'), "stInvoiceBackend/makeConfirmInvoice?id=" . $invoice->getId() . '&type=proforma') ?>
<?php endif; ?>

<?php if ($invoiceType == "request"): ?>
   <?php echo st_get_admin_action('add', __('Wystaw fakture'), "stInvoiceBackend/makeConfirmInvoice?id=" . $invoice->getId() . '&type=request') ?>
<?php endif; ?>

<?php echo st_get_admin_action('edit', __('Edytuj'), "stInvoiceBackend/viewEditCustom?id=" . $invoice->getId() . '&type=' . $invoiceType) ?>

<?php echo st_get_admin_actions_foot() ?>