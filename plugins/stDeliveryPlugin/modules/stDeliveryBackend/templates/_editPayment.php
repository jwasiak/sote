<script type="text/javascript">
    jQuery(function($) {
        $('#st_delivery-payment-body').on("click", "[data-action]", function() {
            var action = $(this);

            var tr = action.closest('tr');

            console.log(tr);

            if (action.data('action') == "up") {
                
                var prev = tr.prevAll('.st_delivery-payment-row-enabled').first();

                if (prev.length) {
                    prev.before(tr);
                }
            } else if (action.data('action') == "down") {
                var next = tr.nextAll('.st_delivery-payment-row-enabled').first();

                if (next.length) {
                    next.after(tr);
                }                   
            }

            return false;
        });

        $('#st_delivery-payment-body').on("change", ".cost-type", function() {
            var select = $(this);

            var tr = select.closest("tr");
            
            tr.find('.cost-netto').prop("disabled", select.val() == '%');
            // tr.find('.cost-brutto').trigger('change');
            var el = tr.find('.cost-brutto').change().get(0);

            var event = document.createEvent("HTMLEvents");
            event.initEvent("change",true,false);
            el.dispatchEvent(event);    
        });

        $('#st_delivery-payment-body').on("change", ".cost-brutto", function() {
            var input = $(this);

            var tr = input.closest("tr");

            if (tr.find('.cost-type').val() == '%') {
                tr.find('.cost-netto').val(input.val());
            }
        });

        $('#st_delivery-payment-body').on("change", ".st_delivery-payment-form-active", function() {
            var checkbox = $(this);

            var tr = checkbox.closest("tr");
            
            var elements = tr.find(":input");
            elements.not(checkbox).prop("disabled", !checkbox.prop("checked"));
            elements.filter('.cost-type').change();
        }); 
    });
</script>
<?php echo form_error('delivery{payments}', array('style' => 'color: #FF3333')) ?>
<?php if (empty($payments)): ?>
<?php echo st_link_to(__('Brak aktywnego typu płatności, przejdź do konfiguracji typów płatności'), '@stPaymentType') ?>
<?php else: ?>
<table class="st_record_list" cellspacing="0" width="100%" style="max-width: 700px;">
    <thead>
        <tr>
            <th rowspan="2"><?php echo __('Aktywna') ?></th>
            <th rowspan="2"><?php echo __('Domyślna') ?></th>
            <th rowspan="2" style="width: 100%"><?php echo __('Nazwa') ?></th>
            <th colspan="3"><?php echo __('Koszt') ?></th>
            <th><?php echo __('Darmowa od') ?></th>
            <th><?php echo __('Koszt kuriera') ?></th>
            <th rowspan="2"><?php echo __('Kolejność') ?></th>
        </tr>
        <tr>
            <th><?php echo __('Netto') ?></th>
            <th><?php echo __('Brutto') ?></th>
            <th><?php echo __('Rodzaj') ?></th>
            <th><?php echo __('Brutto') ?></th>
            <th><?php echo __('Brutto') ?></th>
        </tr>
    </thead>
    <tbody id="st_delivery-payment-body">

<?php foreach ($payments as $index => $payment): ?>
<?php
$dhp = $payment->getDeliveryHasPaymentType();
$active = $dhp ? $dhp->getIsActive() : false;
$pid = $payment->getId();

$error_cost = form_has_error('delivery{payments}{'.$pid.'}{cost_netto}');
$error_cost_brutto = form_has_error('delivery{payments}{'.$pid.'}{cost_brutto}');
$error_free_from = form_has_error('delivery{payments}{'.$pid.'}{free_from}');
      st_price_tax_manager_add_price_field(array(
          'price' => 'delivery_payments_'.$pid.'_cost_netto',
          'priceWithTax' => 'delivery_payments_'.$pid.'_cost_brutto'));
?>
<?php if ($error_cost): ?>
        <tr><td colspan="7"><?php echo form_error('delivery{payments}{'.$pid.'}{cost_netto}', array('style' => 'color: #FF3333')) ?></td></tr>
<?php endif; ?>
<?php if ($error_cost_brutto): ?>
        <tr><td colspan="7"><?php echo form_error('delivery{payments}{'.$pid.'}{cost_brutto}', array('style' => 'color: #FF3333')) ?></td></tr>
<?php endif; ?>
<?php if ($error_free_from): ?>
        <tr><td colspan="7"><?php echo form_error('delivery{payments}{'.$pid.'}{free_from}', array('style' => 'color: #FF3333')) ?></td></tr>
<?php endif; ?>
        <tr id="st_delivery-payment-row-<?php echo $pid ?>" class="st_delivery-payment-row-<?php echo $active ? 'enabled' : 'disabled' ?>">
            <td><?php echo checkbox_tag('delivery[payments]['.$pid.'][is_active]', $pid, $active, array('class' => 'st_delivery-payment-form-active')) ?></td>
            <td><?php echo radiobutton_tag('delivery[is_default_payment]', $pid, $dhp ? $dhp->getIsDefault() : false, array('id' => 'delivery_is_default_payment_' . $pid, 'disabled' => !$active)) ?></td>
            <td style="text-align: left">
                <?php echo st_link_to($payment->getName(), 'stPaymentType/edit?id=' . $pid) ?>
<?php if (!$payment->checkPaymentConfiguration()): ?>
                <p><b><?php echo __('Skonfiguruj płatność') ?></b></p>
<?php endif; ?>
            </td>
            <td>
                    <?php echo input_hidden_tag('delivery[payments]['.$pid.'][cost_netto]', $dhp ? $dhp->getCost() : '0.00', array('id' => 'delivery_payments_'.$pid.'_cost_netto_hidden')) ?>
                    <?php echo input_tag('delivery[payments]['.$pid.'][cost_netto]',
                    $dhp ? $dhp->getCost() : '0.00',
                    array('size' => 6, 'disabled' => !$active || ($dhp && $dhp->getCostType() == '%'), 'style' => $error_cost ? 'border-color: #FF3333' : '', 'class' => 'cost-netto cost')) ?>
            </td>
            <td>
                    <?php echo input_hidden_tag('delivery[payments]['.$pid.'][cost_brutto]', $dhp ? $dhp->getCostBrutto() : '0.00', array('id' => 'delivery_payments_'.$pid.'_cost_brutto_hidden')) ?>
                    <?php echo input_tag('delivery[payments]['.$pid.'][cost_brutto]',
                    $dhp ? $dhp->getCostBrutto() : '0.00',
                    array('size' => 6, 'disabled' => !$active, 'style' => $error_cost ? 'border-color: #FF3333' : '', 'class' => 'cost-brutto cost')) ?>
            </td>
            <td>
                    <?php echo select_tag('delivery[payments]['.$pid.'][cost_type]', options_for_select(array('P' => stCurrency::getDefault()->getShortcut(), '%' => '%'), $dhp ? $dhp->getCostType() : null), array('class' => 'cost-type')) ?>
            </td>
            <td>
                    <?php echo input_hidden_tag('delivery[payments]['.$pid.'][free_from]', $dhp ? $dhp->getFreeFrom() : '0.00', array('id' => 'delivery_payments_'.$pid.'_free_from_hidden')) ?>
                    <?php echo input_tag('delivery[payments]['.$pid.'][free_from]',
                    $dhp ? $dhp->getFreeFrom() : '0.00',
                    array('size' => 8, 'disabled' => !$active, 'style' => $error_free_from ? 'border-color: #FF3333' : '')) ?>
                    <?php echo st_price_add_format_behavior('delivery_payments_'.$pid.'_free_from') ?>
            </td>
            <td>
                   <?php echo input_hidden_tag('delivery[payments]['.$pid.'][courier_cost]', $dhp ? $dhp->getCourierCost() : '0.00', array('id' => 'delivery_payments_'.$pid.'_courier_cost_hidden')) ?>
                   <?php echo input_tag('delivery[payments]['.$pid.'][courier_cost]',
                    $dhp ? $dhp->getCourierCost(): '0.00',
                    array('size' => 8, 'disabled' => !$active, 'style' => $error_free_from ? 'border-color: #FF3333' : '')) ?>
                    <?php echo st_price_add_format_behavior('delivery_payments_'.$pid.'_courier_cost') ?>
            </td>            
            <td>
                <div id="st_delivery-payment-row-<?php echo $pid ?>-control" style="display: <?php echo $active ? 'block' : 'none' ?>">
<?php if ($form_has_errors): ?>
                        <?php echo image_tag('/images/backend/icons/asc.png') ?>
                        <?php echo image_tag('/images/backend/icons/desc.png') ?>
<?php else: ?>
                        <a href="#" data-action="up"><?php echo image_tag('/images/backend/icons/asc.png') ?></a>
                        <a href="#" data-action="down"><?php echo image_tag('/images/backend/icons/desc.png') ?></a>
<?php endif; ?>
                </div>
            </td>
        </tr>
    <?php st_price_tax_manager_add_price_field(array('price' => 'delivery_payments_'.$pid.'_cost_netto', 'priceWithTax' => 'delivery_payments_'.$pid.'_cost_brutto')) ?>
<?php endforeach ?>
    </tbody>
    <tfoot>
        <tr><th colspan="9"><?php echo st_link_to(__('Konfiguracja płatności'), '@stPaymentType') ?></th></tr>
    </tfoot>
</table>
<?php endif ?>

