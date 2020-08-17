<?php
use_helper('stCurrency', 'stOrder', 'stPrice', 'stJQueryTools', 'stProductImage', 'stDiscount');
sfLoader::loadHelpers('stProduct', 'stProduct');
?>

<?php if(!$sf_user->getAttribute('edit_mode', false, 'soteshop/stOrder')): ?>
<table id="st_order-product-list" class="st_record_list" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th></th>
            <th style="padding: 3px 2px">&nbsp;</th>
            <th><?php echo __('Kod') ?></th>
            <th><?php echo __('Nazwa') ?></th>
            <th><?php echo __('Recenzja') ?></th>
            <th><?php echo __('Netto') ?></th>
            <th><?php echo __('Vat') ?></th>
            <th><?php echo __('Brutto') ?></th>
            <th><?php echo __('Rabat') ?></th>
            <th><?php echo __('Brutto') ?>(-%)</th>
            <th><?php echo __('Ilość') ?></th>
            <th><?php echo __('Suma') ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th colspan="11" style="text-align: right"><?php echo __('Łącznie') ?>:</th>
            <th style="text-align: right"><?php echo st_order_product_total_amount($order, true, false) ?></th>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach ($order->getOrderProducts() as $key=>$order_product): ?>
        <tr>
            <td><?php echo $key+1; ?></td>
            <td style="padding: 3px 2px"><?php echo st_product_image_tag($order_product->getImage(), 'icon', array('style' => 'max-height: 42px; max-width: 42px')) ?></td>
            <td><?php echo $order_product->getCode() ?></td>      
            <td class="st_record_list-item-name">
                    <?php if ($order_product->productValidate()): ?>
                        <?php echo st_external_link_to($order_product->getName(), 'stProduct/edit?id=' . $order_product->getProductId()) ?>
                    <?php else: ?>
                        <?php echo $order_product->getName() ?>
                    <?php endif; ?>
                    <?php if ($order_product->hasPriceModifiers() || $order_product->hasOldOptions()): ?>
                        <?php st_order_display_product_options($order_product) ?>
                    <?php endif; ?>
                    <?php if ($order_product->getIsSet()): ?>
                        <?php st_order_display_product_set($order_product) ?>
                    <?php endif; ?>                    
                    <?php if ($order_product->getOnlineCode()): ?>
                        <?php $codes = unserialize($order_product->getOnlineCode());?>
                        <?php if(!empty($codes)):?>
                            <div>
                                <div style="float: left;">
                                    <?php echo (count($codes) == 1) ? __('Kod') : __('Kody');?>:
                                </div>
                                <div style="float: left; padding-left: 5px;">
                                    <ul>
                                        <?php foreach ($codes as $code):?>
                                            <li><?php echo $code;?></li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                                <div style="clear:both;">
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($order->isAllegroOrder()): ?>
                        <p><?php echo __('Oferta Allegro', null, 'stAllegroBackend') ?>: <a href="<?php echo url_for('@stAllegroPlugin?action=edit&id=' . $order_product->getAllegroAuctionId()) ?>" target="_blank"><?php echo $order_product->getAllegroAuctionId() ?></a></p>
                    <?php endif ?>
            </td>      
            <td style="text-align: center"><?php st_include_component("stReview", "reviewStatus", array('order_product' => $order_product)); ?></td>
            <td style="text-align: right"><?php echo st_order_product_price($order_product, false, false) ?></td>
            <td style="text-align: right"><?php echo $order_product->getVat() ?> %</td>
            <td style="text-align: right"><?php echo st_order_product_price($order_product, true, false) ?></td>
            <td style="text-align: right"><?php echo $order_product->getDiscountInPercent() ?> %</td>
            <td style="text-align: right"><?php echo st_order_product_price($order_product, true) ?></td>
            <td style="text-align: right"><?php echo $order_product->getQuantity() ?> <?php echo st_product_uom($order_product->getProduct()) ?></td>
            <td style="text-align: right"><?php echo st_order_product_total_amount($order_product, true) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
</table>
<?php else: ?>
<?php
use_javascript('/jQueryTools/jquery/effects.core.js?v5');

use_javascript('/jQueryTools/stTableRecordManager/js/script.js?v5');

use_stylesheet('/jQueryTools/stTableRecordManager/css/style.css?v5');

use_javascript('backend/stOrder.js?v5');

$taxes =  TaxPeer::doSelect(new Criteria());

$tax_values = array();

$default_tax = null;

$has_valid_vat_eu = $order->getOrderUserDataBilling()->getHasValidVatEu();

foreach ($taxes as $tax)
{
    $tax_values[] = $tax->getVat();

    $tax_options[$tax->getId()] = $tax->getVatName();

    if (!$default_tax && (!$has_valid_vat_eu && $tax->getIsDefault() || $has_valid_vat_eu && $tax->getVat() === 0))
    {
        $default_tax = $tax->getId();
    }
}

echo form_error('order{product}', array('style' => 'color: #ff3333'));
?>
<table id="st_order-product-list" class="st_record_list st_record_manager" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th style="padding: 3px 2px">&nbsp;</th>
            <th><?php echo __('Kod') ?></th>
            <th><?php echo __('Nazwa') ?></th>
            <th><?php echo __('Netto') ?></th>
            <th><?php echo __('Vat') ?></th>
            <th><?php echo __('Brutto') ?></th>
            <th><?php echo __('Rabat') ?></th>
            <th><?php echo __('Brutto') ?>(-%)</th>
            <th><?php echo __('Ilość') ?></th>
            <th><?php echo __('Suma') ?></th>
            <th>&nbsp;</th>
        </tr>
        <tr class="template">
            <th>&nbsp;</th>
        
            <th>
               <?php echo st_autocompleter_input_tag("code", null, array('class' => 'code-field', 'autocompleter' => array(
                  'serviceUrl' => url_for('stOrder/ajaxSearchProduct?by=code&order_id='.$order->getId().'&vat_eu='.$has_valid_vat_eu),
                  'deferRequestBy' => 300,
                  'onSelect' => 'stOrderProductPriceManagment.updateProductForm(value, data, el);',
                  'resultFormat' => 'stOrderProductPriceManagment.fnFormatResult')))?>
            </th>
            <th>
               <?php echo st_autocompleter_input_tag("name", null, array('class' => 'name-field', 'autocompleter' => array(
                  'serviceUrl' => url_for('stOrder/ajaxSearchProduct?by=name&order_id='.$order->getId().'&vat_eu='.$has_valid_vat_eu),
                  'deferRequestBy' => 300, 'minChars' => 3,
                  'onSelect' => 'stOrderProductPriceManagment.updateProductForm(value, data, el);',
                  'resultFormat' => 'stOrderProductPriceManagment.fnFormatResult')))?>
            </th>
            <th><?php echo input_tag("price_netto", '0.00', array('class' => 'price-field'))?></th>
            <th><?php echo select_tag('tax', options_for_select($tax_options, $default_tax)) ?></th>
            <th><?php echo input_tag("price_brutto", '0.00', array('class' => 'price-field'))?></th>
            <th><?php echo input_tag("discount", 0, array('class' => 'discount-field'))?> <?php echo st_discount_type_select_tag("discount_type", '%', array('currency' => $order->getOrderCurrency())) ?></th>
            <th><?php echo input_tag("price_brutto_discount", '0.00', array('class' => 'price-field', 'disabled' => true))?></th>
            <th><?php echo input_tag("quantity", 1, array('class' => 'quantity-field'))?></th>
            <th>
               <?php echo input_tag("total_amount", '0.00', array('class' => 'price-field total-amount', 'disabled' => true)) ?>
               <?php echo input_hidden_tag('oid', null) ?>
               <?php //echo input_hidden_tag('hidden_data', null, array('class' => 'hidden_data')) ?>
            </th>
            <th class="actions">
               <?php echo link_to(image_tag('backend/icons/add.png'), "#", array('class' => 'create')) ?>
               <?php echo link_to(image_tag('backend/icons/delete.png'), "#", array('class' => 'remove')) ?>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($order->getOrderProducts() as $index => $order_product): if ($order_product->isDeleted()) continue; ?>                        
        <?php if (form_has_error('order{product}{'.$index.'}{code}')): ?>
        <tr class="errors">
           <td colspan="12"><?php echo form_error('order{product}{'.$index.'}{code}') ?></td>
        </tr>
        <?php endif; ?>
        <?php if (form_has_error('order{product}{'.$index.'}{name}')): ?>
        <tr class="errors">
           <td colspan="12"><?php echo form_error('order{product}{'.$index.'}{name}') ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td><?php echo $index+1; ?></td>
            <td class="<?php echo form_has_error('order{product}{'.$index.'}{code}') ? 'errors' : 'none' ?>"><?php echo input_tag("order[product][".$index."][code]", $order_product->getCode(), array('class' => 'code-field')) ?></td>
            <td class="<?php echo form_has_error('order{product}{'.$index.'}{name}') ? 'errors' : 'none' ?>">
               <?php echo input_tag("order[product][".$index."][name]", $order_product->getName(), array('class' => 'name-field'))?>
                 <?php if ($order_product->hasPriceModifiers() || $order_product->hasOldOptions()): ?>
                 <div class="product-options-container"><span><?php echo $order_product->getPriceModifierLabels(); ?></span></div>
                 <?php endif; ?>
            </td>
            <td><?php echo input_tag("order[product][".$index."][price_netto]", $order_product->getPriceNetto(true, false), array('class' => 'price-field'))?></td>
            <td><?php echo select_tag("order[product][".$index."][tax]", options_for_select($tax_options, $order_product->getTaxId())); ?></td>
            <td><?php echo input_tag("order[product][".$index."][price_brutto]", stPrice::round($order_product->getPriceBrutto(true, false)), array('class' => 'price-field'))?></td>
            <td><?php echo input_tag("order[product][".$index."][discount]", $order_product->getDiscountType() == 'P' ? stPrice::round($order_product->getDiscountValue()) : stPrice::round($order_product->getDiscountInPercent(), 1), array('class' => 'discount-field'))?> <?php echo st_discount_type_select_tag("order[product][".$index."][discount_type]", $order_product->getDiscountType(), array('currency' => $order->getOrderCurrency())) ?></td>
            <td><?php echo input_tag("order[product][".$index."][price_brutto_discount]", $order_product->getPriceBrutto(true), array('class' => 'price-field', 'disabled' => true))?></td>
            <td><?php echo input_tag("order[product][".$index."][quantity]", $order_product->getQuantity(), array('class' => 'quantity-field'))?></td>
            <td>
               <?php echo input_tag("order[product][".$index."][total_amount]", $order_product->getTotalAmount(true, true), array('class' => 'price-field total-amount', 'disabled' => true)) ?>
               <?php
               echo input_hidden_tag('order[product]['.$index.'][oid]', $order_product->getId());
               /*
               $hidden_data = array('id' => $order_product->getProductId(), 'io' => $order_product->getImage());
               
               if ($order_product->hasPriceModifiers() || $order_product->hasOldOptions())
               {
                  $hidden_data['pm'] = $order_product->getPriceModifiers();
               }
               
               echo input_hidden_tag('order[product]['.$index.'][hidden_data]', json_encode($hidden_data), array('class' => 'hidden_data'));
                */
               ?>
            </td>
            <td class="actions">
               <?php echo link_to(image_tag('backend/icons/delete.png'), '#', array('class' => 'remove')) ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>    
</table>
<div id="st_order-autocomplete-template">
   <div class="st_order-autocomplete-item">
      <div class="image"><img src="" alt="" /></div>
      <div class="content">
         <h2></h2>
         <ul>
            <li><b><?php echo __('Cena:') ?></b> <?php echo $order->getOrderCurrency()->getFrontSymbol() ?><span class="price_netto"></span> <?php echo $order->getOrderCurrency()->getBackSymbol() ?> / <?php echo $order->getOrderCurrency()->getFrontSymbol() ?><span class="price_brutto"></span> <?php echo $order->getOrderCurrency()->getBackSymbol() ?></li>
         </ul>
      </div>
   </div>
</div>
<script type="text/javascript">
   stOrderProductPriceManagment.setParams({taxValues: <?php echo json_encode($tax_values) ?>});
   jQuery(function($) {

      function updatePayment() {
         var locale = "<?php echo str_replace("_", "-", $sf_user->getCulture()); ?>";
         var numberFormat = new Intl.NumberFormat(locale, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
         var priceFormat = "<?php echo $order->getOrderCurrency()->getFrontSymbol().'%price% '.$order->getOrderCurrency()->getBackSymbol() ?>";
         var payment = $('#st_record_manager-payment tbody tr .price-field').not('[data-gift-card=1]');

         var paid = 0;
         var manager = $('#st_record_manager-payment');

         manager.find('tbody tr .price-field').each(function() {
            var current = $(this);

            if (current.closest('tr').find('.payment-status').prop('checked')) {
               paid += Number(current.val());
            }
         });

         var total = 0;

         $('#st_order-product-list tbody .total-amount').each(function() {
            total += Number($(this).val());
         });

         var totalAmount = total;

         total += Number($('#order_delivery_cost').val());  

         var totalAmountWithOrder = total;

         var discountOption = $('#order_discount option:selected');

         if (discountOption.data('discount-type')) {
            if (discountOption.data('discount-type') == '%') {
               var toPay = total - totalAmount * (discountOption.data('discount-value') / 100);
            } else {
               var toPay = total - discountOption.data('discount-value');
            }
         } else {
            var toPay = total;
         }

         if (toPay < 0) {
          toPay = 0;
         }

         var leftToPay = toPay - paid;

         if (leftToPay < 0) {
            leftToPay = 0;
         }

         $('#order-total-amount-container').html(priceFormat.replace('%price%', numberFormat.format(totalAmountWithOrder)));

         $('#order-to-pay-amount-container').html(priceFormat.replace('%price%', numberFormat.format(toPay)));

         $('#order-left-to-pay-amount-container').html(priceFormat.replace('%price%', numberFormat.format(leftToPay)));

         $('#order-paid-amount-container').html(priceFormat.replace('%price%', numberFormat.format(paid > toPay ? toPay : paid)));

         $('#st_order-product-list').data('total-amount', total);

         if (!manager.data('update')) {
            var whatsLeft = total;

            payment.each(function() {
               whatsLeft -= Number($(this).val());
            });

            if (whatsLeft >= 0 && !manager.data('update')) {
               $('#payment_amount').val(whatsLeft.toFixed(2));
               $('#payment_status').prop('disabled', false);
            }
        }
      }

      $('#order_discount').change(updatePayment);

      $('#order_discount').change();

      stOrderPriceModifiers.params.url = '<?php echo st_url_for('stOrder/ajaxPriceModifiers') ?>';

      $('#st_order-product-list').stTableRecordManager({ namespace: 'order[product]', confirmMsg: '<?php echo __('Jesteś pewien?', null, 'stAdminGeneratorPlugin') ?>'});

      $('#order_delivery_cost').on('change', updatePayment);

      $('#st_order-product-list').bind('preRemove', function(event, row)
      {
         row = row.prev('tr');
         
         while(row.hasClass('errors'))
         {
            var tmp = row.prev('tr');
            row.remove();
            row = tmp;
         }
      });

      $('#st_order-product-list').bind('postRemove', function(event) {
         updatePayment();
      });

      $('#st_order-product-list').bind('postAdd', function(event, row, fields) {
         $.each(fields, function() {
            $(this).css('background-color', $(this).attr('prev-background-color'));
         });

         new stOrderProductPriceManagment(fields, updatePayment);

         $(fields.discount).after('&nbsp;');

         stOrderProductPriceManagment.updateTotalAmount(fields);

         updatePayment();
      });

      $('#admin_edit_form').submit(function() {

         var form = $(this);
         var data = form.serializeArray();

         var json = {};
        
         var index = null;

         var current = {};

         for (var i = 0; i < data.length; i++) {

            if (data[i] && data[i].name.indexOf("order[product]") > -1) {

               var matches = data[i].name.match(/order\[product\]\[(\d+)\]\[([^\]]+)\]/);

               if (index === null) {
                  index = matches[1];
               } else if (index != matches[1]) {
                  json[index] = (current);
                  current = {};
                  index = matches[1];
               }

               current[matches[2]] = data[i].value;
            }         
         }

         if (current && index !== null) {
            json[index] = (current);
         }

         hidden = $("<input type=\"hidden\" name=\"order[product]\" />");

         hidden.val(JSON.stringify(json));

         form.append(hidden);

         form.append("<input type=\"hidden\" name=\"validation_token\" />");

         $('#st_order-product-list').find('select, input').attr('disabled', true);

      });

      $('#st_order-product-list tr').each(function()
      {
         var fields = $(this).find('input, select');
         if (fields.length)
         {
            new stOrderProductPriceManagment({
               price_netto: fields[2],
               tax: fields[3],
               price_brutto: fields[4],
               discount: fields[5],
               discount_type: fields[6],
               price_brutto_discount: fields[7],
               quantity: fields[8],
               total_amount: fields[9]
            }, updatePayment);
         }
      });
   });



</script>
<?php endif; ?>
