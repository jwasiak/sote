<?php use_stylesheet("backend/stInvoiceBackend.css?v1"); ?>

<?php echo form_tag('stInvoiceBackend/SaveConfigContent?culture='.$config->getCulture()) ?>

<div style="width: 98.2%; border: 1px solid #ccc; padding: 10px; margin-top: 10px;">
<div style="margin: 0px auto; padding: 15px; width: 830px;">

<?php echo checkbox_tag('invoiceDefault[invoice_on]', 1, $config->get('invoice_on')) ?>&nbsp;<?php echo label_for('invoiceDefault[invoice_on]', __('Sklep wystawia faktury VAT.')) ?>
<br />
<?php echo checkbox_tag('invoiceDefault[proforma_on]', 1, $config->get('proforma_on')) ?>&nbsp;<?php echo label_for('invoiceDefault[proforma_on]', __('Sklep wystawia proformy.')) ?>
<br />
<?php echo checkbox_tag('invoiceDefault[shop_currency]', 1, $config->get('shop_currency')) ?>&nbsp;<?php echo label_for('invoiceDefault[shop_currency]', __('Faktury wystawiane są w walucie wybranej przez klienta sklepu.')) ?>
<br />
<?php echo checkbox_tag('invoiceDefault[vat_eu]', 1, $config->get('vat_eu')) ?>&nbsp;<?php echo label_for('invoiceDefault[vat_eu]', __('Umożliwiaj wystawianie faktur dla kontrahentów posiadających VAT UE')) ?>
<br />
<?php echo checkbox_tag('invoiceDefault[show_product_code]', 1, $config->get('show_product_code')) ?>&nbsp;<?php echo label_for('invoiceDefault[show_product_code]', __('Pokaż kod produktu na fakturze.')) ?>
</div>


<div style="border: 1px solid #EEEEEE; margin: 0px auto; padding: 15px; width: 830px;">

    <div style="float:left; width: 400px;">
       <?php echo textarea_tag("invoiceDefault[company_description]", $config->get('company_description'), array ( 'size' => '54x6', 'rich' => true, 'tinymce_options' => "height:80,width:'100%' ,theme:'simple'")) ?>
    </div>
    
    <div style=" float:right; width: 300px;">
    
        <div class="st_invoice_frame" >
     
            <div class="st_invoice_frame_header" >
                <?php echo __('Miejsce wystawienia') ?>:
            </div>
            
            <div class="st_invoice_frame_content" >
                <?php echo input_tag("invoiceDefault[town]", $config->get('town'), array("size"=>"55px"))?>
            </div>
        
            <div class="st_invoice_frame_content" >
               
               <?php echo input_tag("invoiceDefault[date_label]", $config->get('date_label', null, true), array("size"=>"42px"))?>
               <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
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
            
            <div class="row">
                <div class="label"><?php echo __('firma') ?>: </div>
                <div class="field"><?php echo input_tag("invoiceDefault[seller_company]", $config->get('seller_company'))?></div>
            <br class="st_clear_all">
            </div>
           
            <div class="row">
                <div class="label"><?php echo __('imie i nazwisko') ?>: </div>
                <div class="field"><?php echo input_tag("invoiceDefault[seller_full_name]", $config->get('seller_full_name'))?></div>
            <br class="st_clear_all">
            </div>
            
            <div class="row">
                <div class="label"><?php echo __('adres') ?>: </div>
                <div class="field"><?php echo input_tag("invoiceDefault[seller_address]", $config->get('seller_address'))?></div>
            <br class="st_clear_all">
            </div>

            <div class="row">
                <div class="label"><?php echo __('adres cd') ?>: </div>
                <div class="field"><?php echo input_tag("invoiceDefault[seller_address_more]", $config->get('seller_address_more'))?></div>
            <br class="st_clear_all">
            </div>

            <div class="row">
                <div class="label"><?php echo __('województwo') ?>: </div>
                <div class="field"><?php echo input_tag("invoiceDefault[seller_region]", $config->get('seller_region'))?></div>
            <br class="st_clear_all">
            </div>
            
            <div class="row">
                <div class="label"><?php echo __('kod, miasto') ?>: </div>
                <div class="field"><?php echo input_tag("invoiceDefault[seller_code]", $config->get('seller_code'))?><?php echo input_tag("invoiceDefault[seller_town]", $config->get('seller_town'))?></div>
            <br class="st_clear_all">
            </div>
            
            <div class="row">
                <div class="label"><?php echo __('Kraj') ?>: </div>
                <div class="field"><?php echo input_tag("invoiceDefault[seller_country]", $config->get('seller_country'))?></div>
            <br class="st_clear_all">
            </div>
            
            <div class="row">
                <div class="label"><?php echo __('NIP/VAT UE') ?>: </div>
                <div class="field<?php if ($sf_request->hasError('invoiceDefault{seller_vat_number}')): ?> form-error<?php endif ?>">
                    <?php echo form_error("invoiceDefault[seller_vat_number]", array('class' => 'form-error-msg')) ?>
                    <?php echo input_tag("invoiceDefault[seller_vat_number]", $config->get('seller_vat_number', null, true))?>
                </div>
            <br class="st_clear_all">
            </div>
            
            </div>
        
        </div>
        
    </div>
    
    <!-- <div style=" float:right; width: 400px;">
        
             <div class="st_invoice_frame" style="width: 100%;">

            <div class="st_invoice_frame_header" >
                <?php echo __('Nabywca') ?>:
            </div>
            
            <div class="st_invoice_frame_content_last" >
            
            <div class="row">
                <div class="label"><?php echo __('firma') ?>:</div>
                <div class="field"><?php echo input_tag("invoiceDefault[customer_company]", $config->get('customer_company'),array("disabled"=>"disabled"))?></div>
            <br class="st_clear_all">
            </div>
           
            <div class="row">
                <div class="label"><?php echo __('imie i nazwisko') ?>:</div>
                <div class="field"><?php echo input_tag("invoiceDefault[customer_full_name]", $config->get('customer_full_name'),array("disabled"=>"disabled"))?></div>
            <br class="st_clear_all">
            </div>
            
            <div class="row">
                <div class="label"><?php echo __('adres') ?>:</div>
                <div class="field"><?php echo input_tag("invoiceDefault[customer_address]", $config->get('customer_address'),array("disabled"=>"disabled"))?></div>
            <br class="st_clear_all">
            </div>

            <div class="row">
                <div class="label"><?php echo __('adres cd') ?>:</div>
                <div class="field"><?php echo input_tag("invoiceDefault[customer_address_more]", $config->get('customer_address_more'),array("disabled"=>"disabled"))?></div>
            <br class="st_clear_all">
            </div>

            <div class="row">
                <div class="label"><?php echo __('województwo') ?>:</div>
                <div class="field"><?php echo input_tag("invoiceDefault[customer_region]", $config->get('customer_region'),array("disabled"=>"disabled"))?></div>
            <br class="st_clear_all">
            </div>

            <div class="row">
                <div class="label"><?php echo __('kod, miasto') ?>:</div>
                <div class="field"><?php echo input_tag("invoiceDefault[customer_code]", $config->get('customer_code'),array("disabled"=>"disabled"))?><?php echo input_tag("invoiceDefault[customer_town]", $config->get('customer_town', null, true),array("disabled"=>"disabled"))?></div>
            <br class="st_clear_all">
            </div>
            
            
            <div class="row">
                <div class="label"><?php echo __('Kraj') ?>:</div>
                <div class="field"><?php echo input_tag("invoiceDefault[customer_country]", $config->get('customer_country'),array("disabled"=>"disabled"))?></div>
            <br class="st_clear_all">
            </div>
            
            <div class="row">
                <div class="label"><?php echo __('NIP') ?>:</div>
                <div class="field"><?php echo input_tag("invoiceDefault[customer_vat_number]", $config->get('customer_vat_number'),array("disabled"=>"disabled"))?></div>
            <br class="st_clear_all">
            </div>
            
            </div>
        
        </div>
        
    </div> -->
    <br class="st_clear_all">
    
    <br><br>
    
        <div id="st_invoice_number">
            
            <?php echo input_tag("invoiceDefault[invoice_label]", $config->get('invoice_label', null, true), array("size"=>"50px"))?><?php echo st_get_admin_culture_flag($config->getCulture()) ?>
        </div>
        
        <div>
            <?php echo __('Kolejny numer faktury') ?>&nbsp;<?php echo input_tag("invoiceDefault[number_confirm]", $config->get('number_confirm'),array("size"=>"10px"))?>
<br>
<?php echo __('Format numeru faktury') ?>&nbsp;<?php echo input_tag("invoiceDefault[number_format_prefix]", $config->get('number_format_prefix'),array("size"=>"10px"))?>
<?php echo select_tag('invoiceDefault[number_format]', options_for_select(
    array('1' => __('numer miesiąc rok'), '2' => __('numer rok'), '3' => __('numer')),
    array($config->get('number_format'))
)) ?>
<?php echo input_tag("invoiceDefault[number_format_sufix]", $config->get('number_format_sufix'),array("size"=>"10px"))?>
<br>
<?php echo __('Separator pól') ?>&nbsp;<?php echo select_tag('invoiceDefault[number_format_separator]', options_for_select(
    array('/' => '/', '-' => '-', '.' => '.', ',' => ',', ':' => ':', ';' => ';', '&nbsp;' => __('spacja'), '' =>  __('brak')),
    array($config->get('number_format_separator'))
)) ?>


<br>
<br>
<?php echo __('Kolejny numer proformy') ?>&nbsp;<?php echo input_tag("invoiceDefault[number_proforma]", $config->get('number_proforma'),array("size"=>"10px"))?>
<br>

<?php echo __('Format numeru faktury proforma') ?>&nbsp;<?php echo input_tag("invoiceDefault[number_proforma_format_prefix]", $config->get('number_proforma_format_prefix'),array("size"=>"10px"))?>
<?php echo select_tag('invoiceDefault[number_proforma_format]', options_for_select(
    array('1' => __('numer miesiąc rok'), '2' => __('numer rok'), '3' => __('numer')),
    array($config->get('number_proforma_format'))
)) ?>
<?php echo input_tag("invoiceDefault[number_proforma_format_sufix]", $config->get('number_proforma_format_sufix'),array("size"=>"10px"))?>
<br>
<?php echo __('Separator pól') ?><?php echo select_tag('invoiceDefault[number_proforma_format_separator]', options_for_select(
    array('/' => '/', '-' => '-', '.' => '.', ',' => ',', ':' => ':', ';' => ';', '&nbsp;' => __('spacja'), '' => __('brak')),
    array($config->get('number_proforma_format_separator'))
)) ?>

        </div>
    
    <br>
    
    <!-- <table border="0" cellpadding="0" cellspacing="0" width="100%" class="st_invoice_table">
        <tr>
            <td width="10px" class="st_invoice_table_head"><?php echo __('Lp') ?></td>
            
            <td width="260px" class="st_invoice_table_head"><?php echo __('Nazwa') ?></td>
            
            <td class="st_invoice_table_head"><?php echo __('Ilość') ?></td>
            
            <td class="st_invoice_table_head"><?php echo __('j.m.') ?></td>
            
            <td class="st_invoice_table_head"><?php echo __('Cena netto') ?></td>
            
            <td class="st_invoice_table_head"><?php echo __('VAT') ?><br/>[%]</td>
            
            <td class="st_invoice_table_head"><?php echo __('Wartość netto') ?></td>
            
            <td class="st_invoice_table_head"><?php echo __('VAT') ?></td>
            
            <td class="st_invoice_table_head"><?php echo __('Wartość brutto') ?></td>
            
        </tr>
        
        <tr>
            <td class="st_invoice_table_td">&nbsp;</td>
            
            <td class="st_invoice_table_td">&nbsp;</td>
            
            <td class="st_invoice_table_td">&nbsp;</td>
            
            <td class="st_invoice_table_td">&nbsp;</td>
            
            <td class="st_invoice_table_td">&nbsp;</td>
            
            <td class="st_invoice_table_td">&nbsp;</td>
            
            <td class="st_invoice_table_td">&nbsp;</td>
            
            <td class="st_invoice_table_td">&nbsp;</td>
            
            <td class="st_invoice_table_td">&nbsp;</td>
            
            <td class="st_invoice_table_td">&nbsp;</td>
        </tr>
    
    </table> -->

    <br>

    <?php echo __('Maksymalny czas oczekiwania na płatność') ?> <?php echo select_tag('invoiceDefault[max_day]', options_for_select(
    array('none' => __('brak'), '7' => __('7'), '14' => __('14'), '21' => __('21'), '28' => __('28')),
    array($config->get('max_day'))
)) ?>

    <br>
    <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
    <?php echo textarea_tag("invoiceDefault[invoice_description]", $config->get('invoice_description', null, true), array ( 'size' => '54x6', 'rich' => true, 'tinymce_options' => "height:80,width:'100%' ,theme:'simple'")) ?>

    <br>
    
    <div style="float:left; width: 340px; text-align:center;">
        
         <div class="st_invoice_frame_signature" style="width: 100%;">
        
            <div class="st_invoice_frame_header_signature" >
                <?php echo __('Wystawił(a)') ?>:
            </div>
            
            <div class="st_invoice_frame_content_signature" >
                 <?php echo input_tag("invoiceDefault[seller_signature]", $config->get('seller_signature'),array("size"=>"62px"))?>
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
                <?php echo input_tag("invoiceDefault[customer_signature]", $config->get('customer_signature'),array("size"=>"62px","disabled"=>"disabled"))?>
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
    <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin')) ?>
<?php echo st_get_admin_actions_foot() ?>   

</form>

