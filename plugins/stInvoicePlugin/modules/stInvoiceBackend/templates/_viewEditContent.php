<?php use_stylesheet("backend/stInvoiceBackend.css"); use_helper('stCurrency') ?>
<?php st_include_partial('stAdminGenerator/message') ?>
<?php echo form_tag('stInvoiceBackend/SaveEditProformaInvoice', array('name' => 'form')) ?>

<div style="width: 98.2%; border: 1px solid #ccc; padding: 10px;">
<div style="border: 1px solid #EEEEEE; margin: 0px auto; padding: 15px; width: 830px;">

   <div style="float:left; width: 400px;">
      <?php echo textarea_tag("invoice[company_description]", $invoice->getCompanyDescription(), array('size' => '54x6', 'rich' => true, 'tinymce_options' => "height:80,width:'100%' ,theme:'simple'")) ?>
   </div>

   <div style=" float:right; width: 300px;">

      <div class="st_invoice_frame" >

         <div class="st_invoice_frame_header" >
            <?php echo __('Miejsce wystawienia') ?>:
         </div>

         <div class="st_invoice_frame_content" >
            <?php echo input_tag("invoice[town]", $invoice->getTown()) ?>
         </div>

      </div>

      <div class="st_invoice_frame" >

         <div class="st_invoice_frame_header" >
            <?php echo $config->get('date_label', null, true); ?>:
         </div>

         <div class="st_invoice_frame_content" >
            <?php echo input_date_tag("invoice[date_selle]", $invoice->getDateSelle(), array('readonly' => 'true', 'size' => '8px', 'rich' => 'true', 'calendar_button_img' => '/sf/sf_admin/images/date.png')) ?>
         </div>

      </div>

      <div class="st_invoice_frame" >

         <div class="st_invoice_frame_header" >
            <?php echo __('Data wystawienia') ?>:
         </div>

         <div class="st_invoice_frame_content_last" >
            <?php echo input_date_tag("invoice[date_create_copy]", $invoice->getDateCreateCopy(), array('readonly' => 'true', 'size' => '8px', 'rich' => 'true', 'calendar_button_img' => '/sf/sf_admin/images/date.png')) ?>
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

         <div class="st_invoice_frame_content_last" >

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('firma') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_seller[company]", $invoiceUserSeller->getCompany()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('imie i nazwisko') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_seller[full_name]", $invoiceUserSeller->getFullName()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('adres') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_seller[address]", $invoiceUserSeller->getAddress()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('adres cd') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_seller[address_more]", $invoiceUserSeller->getAddressMore()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('województwo') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_seller[region]", $invoiceUserSeller->getRegion()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('kod, miasto') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_seller[code]", $invoiceUserSeller->getCode()) ?>&nbsp;<?php echo input_tag("invoice_user_seller[town]", $invoiceUserSeller->getTown()) ?></div>
               <br class="st_clear_all">
            </div>  

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('Kraj') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_seller[country]", $invoiceUserSeller->getCountry()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('NIP') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_seller[vat_number]", $invoiceUserSeller->getVatNumber()) ?></div>
               <br class="st_clear_all">
            </div>

         </div>

      </div>

   </div>

   <div style=" float:right; width: 400px;">

      <div class="st_invoice_frame" style="width: 100%;">

         <div class="st_invoice_frame_header" >
            <?php echo __('Nabywca') ?>:
         </div>

         <div class="st_invoice_frame_content_last" >

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('firma') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_customer[company]", $invoiceUserCustomer->getCompany()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('imie i nazwisko') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_customer[full_name]", $invoiceUserCustomer->getFullName()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('adres') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_customer[address]", $invoiceUserCustomer->getAddress()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('adres cd') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_customer[address_more]", $invoiceUserCustomer->getAddressMore()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('województwo') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_customer[region]", $invoiceUserCustomer->getRegion()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('kod, miasto') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_customer[code]", $invoiceUserCustomer->getCode()) ?>&nbsp;<?php echo input_tag("invoice_user_customer[town]", $invoiceUserCustomer->getTown()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('Kraj') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_customer[country]", $invoiceUserCustomer->getCountry()) ?></div>
               <br class="st_clear_all">
            </div>

            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('PESEL') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_customer[pesel]", $invoiceUserCustomer->getPesel()) ?></div>
               <br class="st_clear_all">
            </div>


            <div style="margin:2px;">
               <div style="float:left; width:100px; text-align:right;"><?php echo __('NIP') ?></div>
               <div style="text-align:left;"><?php echo input_tag("invoice_user_customer[vat_number]", $invoiceUserCustomer->getVatNumber()) ?></div>
               <br class="st_clear_all">
            </div>

         </div>

      </div>

   </div>
   <br class="st_clear_all">

   <br><br>

   <div id="st_invoice_number">
      <?php echo $config->get('invoice_label', null, true); ?>
      <?php echo input_tag("invoice[number]", $invoice->getNumber(), array("size" => "15")) ?>
   </div>

   <br>

   <table border="0" cellpadding="0" cellspacing="0" width="100%" class="st_invoice_table">
      <tr>
         <td width="10px" class="st_invoice_table_head"><?php echo __('Lp') ?></td>
         
         <td class="st_invoice_table_head"><?php echo __('Kod') ?></td>

         <td class="st_invoice_table_head"><?php echo __('Nazwa') ?></td>

         <td class="st_invoice_table_head" ><?php echo __('Ilość') ?></td>

         <td class="st_invoice_table_head"><?php echo __('j.m.') ?></td>

         <td class="st_invoice_table_head" style="background-color:#aaa"><?php echo __('Cena jed.') ?><br/><?php echo __('netto') ?></td>

         <td class="st_invoice_table_head"><?php echo __('Cena jed.') ?><br/><?php echo __('brutto') ?></td>

         <td class="st_invoice_table_head"><?php echo __('VAT') ?><br/>[%]</td>

         <td class="st_invoice_table_head" style="background-color:#aaa"><?php echo __('Wartość netto') ?></td>

         <td class="st_invoice_table_head" style="background-color:#aaa"><?php echo __('VAT') ?></td>

         <td class="st_invoice_table_head" style="background-color:#aaa"><?php echo __('Wartość brutto') ?></td>

         <td class="st_invoice_table_head">&nbsp;</td>
      </tr>

      <SCRIPT language=Javascript type="text/javascript">
        
         function isNumberKey(evt)
         {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
               return false;
        
            return true;
         }
    
    
         function checkValue(i)
         {
            
            var input1 = "x" + i;
            var input2 = "y" + i;
            var input3 = "z" + i;
            var input4 = "v" + i;
            var input5 = "C" + i;
            

            x = document.getElementById(input1).value;
            // y = document.getElementById(input2).value;
            z = document.getElementById(input3).value;
            vat = document.getElementById(input4).value;
            
            
            
            var vSplit = vat.split(":");

            v = vSplit[1];
            
                        
            if(!x){ x=0; }
            // if(!y){ y=0; }
            if(!z){ z=0; }
            if(!v){ v=0; }
            
            
            var X = parseFloat(x);
            // var Y = parseFloat(y);
            var Z = parseFloat(z);
            var V = parseFloat(v);       
            


            price_netto = Z /(1+V/100);


            total_netto = X * price_netto;

            total_brutto = Z * X;

            // if(Y!=0)
            // {
               // if(Y>99)
               // {
                  // Y=99;
               // }
// 
// 
               // discount = total_brutto * (Y/100);
               // total_brutto = total_brutto - discount;
            // }
// 
            // discount_percent = Y;
            vat_amount = total_brutto * (V/(100+V));
            
            A = total_netto.toFixed(2); 
            B = vat_amount.toFixed(2);
            C = total_brutto.toFixed(2);
            D = price_netto.toFixed(2);
            // y = discount_percent;

            
            output1 = "A" + i;
            output2 = "B" + i;
            output3 = "C" + i;
            output4 = "D" + i;
            // output5 = "y" + i;
            
            document.getElementById(output1).value = A;
            document.getElementById(output2).value = B;
            document.getElementById(output3).value = C;
            document.getElementById(output4).value = D;
            // document.getElementById(output5).value = y;
         }
        
      </SCRIPT>

      <?php $i = 0; ?>
      <?php foreach ($invoiceProducts as $product)
      { ?>
         <?php $i++; ?>
         <tr>
            <td class="st_invoice_table_td"><?php echo $i; ?></td>
            
            <td class="st_invoice_table_td"><?php echo input_tag("invoice_product[" . $i . "][code]", $product->getCode(), array("size" => "10")) ?></td>

            <td class="st_invoice_table_td"><?php echo input_tag("invoice_product[" . $i . "][name]", $product->getName(), array("size" => "25")) ?></td>

            <td class="st_invoice_table_td"><?php echo input_tag("invoice_product[" . $i . "][quantity]", $product->getQuantity(), array("size" => "5", "onkeypress" => "return isNumberKey(event)", "onkeyup" => "checkValue(" . $i . ")", "id" => "x" . $i . "")) ?></td>

            <td class="st_invoice_table_td"><?php echo input_tag("invoice_product[" . $i . "][measure_unit]", $product->getMeasureUnit(), array("size" => "5")) ?></td>

            <td class="st_invoice_table_td"><?php echo input_tag("invoice_product[" . $i . "][price_netto]", stCurrency::formatPrice($product->getPriceNetto()), array("size" => "5", "readonly" => "true", "id" => "D" . $i . "")) ?></td>

            <td class="st_invoice_table_td"><?php echo input_tag("invoice_product[" . $i . "][price_brutto]", stCurrency::formatPrice($product->getPriceBrutto()), array("size" => "5", "onkeypress" => "return isNumberKey(event)", "onkeyup" => "checkValue(" . $i . ")", "id" => "z" . $i . "")) ?></td>

            <td class="st_invoice_table_td">

               <?php echo select_tag("invoice_product[" . $i . "][vat]", options_for_select($vatArray, $product->getVatId() . ":" . $product->getVat()), array("onclick" => "checkValue(" . $i . ")", "id" => "v" . $i . "")) ?>

            </td>

            <td class="st_invoice_table_td"><?php echo input_tag("invoice_product[" . $i . "][total_price_netto]", stCurrency::formatPrice($product->getTotalPriceNetto()), array("size" => "5", "readonly" => "true", "id" => "A" . $i . "")) ?></td>

            <td class="st_invoice_table_td"><?php echo input_tag("invoice_product[" . $i . "][vat_ammount]", stCurrency::formatPrice($product->getVatAmmount()), array("size" => "5", "readonly" => "true", "id" => "B" . $i . "")) ?></td>

            <td class="st_invoice_table_td"><?php echo input_tag("invoice_product[" . $i . "][opt_total_price_brutto]", stCurrency::formatPrice($product->getOptTotalPriceBrutto()), array("size" => "8", "readonly" => "true", "id" => "C" . $i . "")) ?></td>

            <td class="st_invoice_table_td"><?php
            echo link_to(image_tag('backend/icons/delete.gif', array('alt' => __('delete'), 'title' => __('delete'))), 'stInvoiceBackend/deleteProformaInvoiceProduct?id=' . $invoice->getId() . "&product_id=" . $product->getId(), array(
                'post' => true,
                'confirm' => __('Jesteś pewien?', null, 'stAdminGeneratorPlugin'),
            ))
               ?></td>

         </tr>

         <?php echo input_hidden_tag("invoice_product[" . $i . "][product_id]", $product->getId()) ?>

      <?php } ?>

      <tr>
         <td colspan="13" align="right">
            <div id="add_row">
            <?php echo st_get_admin_actions_head() ?>
            <?php echo st_get_admin_action('add', __('Dodaj pozycję'), null, array('name' => 'addNwProduct')) ?>
            <?php echo st_get_admin_actions_foot() ?>
            </div>   

         </td>
      </tr>

   </table>

 <?php echo __('Rodzaj płatności') ?> <?php echo select_tag('invoice[payment_type]', options_for_select(
    array('none' => __('brak'), 'cash' => __('gotówką'), 'transfer_on_delivery' => __('za pobraniem'), 'transfer' => __('przelewem'), 'transfer_zagiel' => __('Żagiel - eRaty'), 'transfer_przelewy24' => __('Przelewy24'), 'transfer_polcard' => __('Polcard'), 'transfer_payu' => __('PayU'), 'transfer_moneybookers' => __('Moneybookers'), 'transfer_lukas' => __('LUKAS Raty'), 'transfer_ecard' => __('eCard'), 'transfer_dotpay' => __('Dotpay'), 'transfer_paypal' => __('Paypal')),
    array($invoice->getPaymentType())
)) ?>
    <br><br>

    <?php echo __('Maksymalny czas oczekiwania na płatność') ?> <?php echo select_tag('invoice[max_day]', options_for_select(
    array('none' => __('brak'), '7' => __('7'), '14' => __('14'), '21' => __('21'), '28' => __('28')),
    array($invoice->getMaxDay())
)) ?>

    <br><br>
    
    <?php echo textarea_tag("invoice[invoice_description]", $invoice->getInvoiceDescription(), array ( 'size' => '54x6', 'rich' => true, 'tinymce_options' => "height:80,width:'100%' ,theme:'simple'")) ?>

    <br><br>

   <div style="float:left; width: 340px; text-align:center;">

      <div class="st_invoice_frame_signature" style="width: 100%;">

         <div class="st_invoice_frame_header_signature" >
            <?php echo __('Wystawił(a)') ?>:
         </div>

         <div class="st_invoice_frame_content_signature" >
            <?php echo input_tag("invoice[seller_signature]", $invoice->getSignatureSeller()) ?>
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
            <?php echo input_tag("invoice[customer_signature]", $invoice->getSignatureCustomer()) ?>
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
<?php echo input_hidden_tag("invoice[type]", $type) ?>
<?php echo input_hidden_tag("invoice[invoice_id]", $invoice->getId()) ?>
<?php echo input_hidden_tag("invoice_user_customer[user_customer_id]", $invoiceUserCustomer->getId()) ?>
<?php echo input_hidden_tag("invoice_user_seller[user_seller_id]", $invoiceUserSeller->getId()) ?>

<?php echo st_get_admin_actions_head() ?>
<?php echo st_get_admin_action('list', __('Wróć do podglądu'), "stInvoiceBackend/viewCustom?id=" . $invoice->getId() . "&type=" . $type) ?>
<?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin')) ?>
<?php echo st_get_admin_actions_foot() ?>

</form>
