<?php
use_javascript('/jQueryTools/jquery/effects.core.js?version=2');

use_javascript('/jQueryTools/stTableRecordManager/js/script.js?version=2');

use_stylesheet('/jQueryTools/stTableRecordManager/css/style.css?version=2');
?>
<script type="text/javascript">
//<![CDATA[   

   jQuery(function($) {
      $('#st_delivery-sections').stTableRecordManager({ namespace: 'delivery[sections]', confirmMsg: '<?php echo __('Jesteś pewien?', null, 'stAdminGeneratorPlugin') ?>'});
      $('#st_delivery-sections').bind('postAdd', function(event, row, fields) {
            stPrice.addFormatBehavior(fields.from);
            stPriceTaxManagment.instance.addPriceField({price: fields.cost_netto.id, priceWithTax: fields.cost_brutto.id});
         });
      $('#delivery_section_cost_type').change(function() {
         if (this.selectedIndex > 0)
         {
            $('#st_delivery-sections').show();
         }
         else
         {
            $('#st_delivery-sections').hide();  
         }
      });
   });
//]]>   
</script>
<?php echo select_tag('delivery[section_cost_type]', options_for_select($options, $selected)) ?>
<?php echo form_error('delivery{sections}', array('style' => 'color: #FF3333')) ?>
<table id="st_delivery-sections" class="st_record_list st_record_manager" cellspacing="0" style="margin-top: 10px; <?php echo $delivery->getSectionCostType() ? '' : 'display: none' ?>">
   <thead>
      <tr>
         <th rowspan="2"><?php echo __('Od') ?></th>
         <th colspan="2"><?php echo __('Koszt') ?></th>
         <th rowspan="2">&nbsp;</th>
      </tr>
      <tr>
         <th><?php echo __('Netto') ?></th>
         <th><?php echo __('Brutto') ?></th>
      </tr>
      <tr class="template">
         <th><?php echo input_tag('from', null, array('size' => 8, 'value' => '0')) ?></th>
         <th><?php echo input_tag('cost_netto', null, array('size' => 8, 'value' => '0.00')) ?></th>
         <th><?php echo input_tag('cost_brutto', null, array('size' => 8, 'value' => '0.00')) ?></th>
         <th class="actions">
            <?php echo link_to(image_tag('backend/icons/add.png'), "#", array('class' => 'create')) ?>
            <?php echo link_to(image_tag('backend/icons/delete.png'), "#", array('class' => 'remove')) ?>
         </th>
      </tr>
   </thead>
   <tbody>
      <?php foreach ($delivery_sections as $id => $delivery_section): $namespace = 'delivery[sections]['.$id.']'; ?>
         <?php
         $error_from = form_has_error('delivery{sections}{'.$id.'}{from}');
         $error_cost = form_has_error('delivery{sections}{'.$id.'}{cost_netto}');
         $error_cost_brutto = form_has_error('delivery{sections}{'.$id.'}{cost_brutto}');
         st_price_tax_manager_add_price_field(array(
             'price' => 'delivery_sections_'.$id.'_cost_netto',
             'priceWithTax' => 'delivery_sections_'.$id.'_cost_brutto'));
         ?>
         <?php if ($error_from): ?>
            <tr class="errors"><td colspan="4"><?php echo form_error('delivery{sections}{'.$id.'}{from}', array('style' => 'color: #FF3333')) ?></td></tr>
         <?php endif; ?>
         <?php if ($error_cost): ?>
            <tr class="errors"><td colspan="4"><?php echo form_error('delivery{sections}{'.$id.'}{cost_netto}', array('style' => 'color: #FF3333')) ?></td></tr>
         <?php endif; ?>
         <?php if ($error_cost_brutto): ?>
            <tr class="errors"><td colspan="4"><?php echo form_error('delivery{sections}{'.$id.'}{cost_brutto}', array('style' => 'color: #FF3333')) ?></td></tr>
         <?php endif; ?>
         <tr>
            <td>
               <?php echo input_tag($namespace.'[from]', $delivery_section->getFrom(), array('size' => 8, 'style' => $error_from ? 'color: #FF3333' : '')) ?>

            </td>
            <td>
               <?php echo input_tag($namespace.'[cost_netto]', $delivery_section->getCostNetto(), array('size' => 8, 'style' => $error_cost ? 'color: #FF3333' : '')) ?>
            </td>
            <td>
               <?php
               echo input_tag($namespace.'[cost_brutto]', $delivery_section->getCostBrutto(), array('size' => 8, 'style' => $error_cost_brutto ? 'color: #FF3333' : ''))
               ?>
            </td>
            <td class="actions">
               <?php echo link_to(image_tag('backend/icons/delete.png'), '#', array('class' => 'remove')) ?>
            </td>
         </tr>
      <?php endforeach ?>
   </tbody>
</table>

