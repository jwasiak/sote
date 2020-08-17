<?php use_helper('stPrice') ?>

<style>

</style>

<div id="allegro-deliveries">
    <div class="visibility-toggle">
        <a href="#" class="show-all"><?php echo __('Pokaż wszystkie') ?></a>
        <a href="#" class="show-only-selected" style="display: none"><?php echo __('Pokaż tylko zaznaczone') ?></a>
    </div>
    <?php $errorId = 0 ?>
    <?php foreach ($deliveryGroups as $group => $types): ?>
        <?php foreach ($types as $type => $deliveryMethods): $index = 0 ?>
            <div class="allegro-delivery-group" style="margin-top: 15px; display: none">
                <b><?php echo __($group) ?> - <?php echo $type == 'IN_ADVANCE' ? __('Płatność z góry') : __('Płatność przy odbiorze') ?></b>
                <table cellspacing="0" cellpadding="0" class="st_record_list record_list allegro-delivery-table" style="width: 100%; margin-top: 5px">
                    <thead>         
                        <tr> 
                            <th><?php echo __('Aktywna') ?></th>
                            <th style="width: 80%"><?php echo __('Metoda dostawy') ?></th>
                            <th><?php echo __('Pierwsza sztuka') ?></th>
                            <th><?php echo __('Maks. w paczce') ?></th>
                            <th><?php echo __('Kolejna sztuka') ?></th>
                        </tr>    
                    </thead>
                    <tbody>
                        <?php foreach ($deliveryMethods as $method): 
                            $rate = isset($delivery['rates'][$method->id]) ? $delivery['rates'][$method->id] : null; 
                            $name = 'delivery[rates]['.$method->id.']';
                            $index++;
                        ?>
                            <tr class="<?php echo $index % 2 ? '' : 'highlight' ?>"<?php if (null === $rate): ?> style="display: none"<?php endif ?>>
                                <td><?php echo checkbox_tag($name.'[active]', 1, null !== $rate, array('class' => 'active')) ?></td>
                                <td <?php if ($rate && $sf_request->hasError('rates['.$errorId.'].deliveryMethod.id')): ?>class="form-error error_tooltip" title="<?php echo htmlspecialchars($sf_request->getError('rates['.$errorId.'].deliveryMethod.id')) ?>"<?php endif ?>>
                                    <?php echo $method->name ?>
                                    <?php if ($rate && $sf_request->hasError('rates['.$errorId.'].deliveryMethod.id')): ?>
                                        <img style="width: 14px; vertical-align: middle" src="/images/update/red/status/alert.png">
                                    <?php endif ?>  
                                </td>
                                <td <?php if ($rate && $sf_request->hasError('rates['.$errorId.'].firstItemPrice.amount')): ?>class="form-error error_tooltip" title="<?php echo htmlspecialchars($sf_request->getError('rates['.$errorId.'].firstItemPrice.amount')) ?>"<?php endif ?>>
                                    <?php echo input_tag($name.'[first_item_rate][amount]', stCurrency::formatPrice($rate ? $rate['first_item_rate']['amount'] : $rate['first_item_rate']['default']), array('style' => 'width: 60px', 'maxlength' => 10, 'disabled' => !$rate, 'class' => 'price')) ?>
                                    <?php echo input_hidden_tag($name.'[first_item_rate][currency]', $rate ? $rate['next_item_rate']['currency'] : 'PLN', array('class' => 'hidden', 'disabled' => !$rate)) ?>
                                    <?php if ($rate && $sf_request->hasError('rates['.$errorId.'].firstItemPrice.amount')): ?>
                                        <img style="width: 14px; vertical-align: middle" src="/images/update/red/status/alert.png">
                                    <?php endif ?>                                
                                </td>
                                <td <?php if ($rate && $sf_request->hasError('rates['.$errorId.'].maxQuantityPerPackage')): ?>class="form-error error_tooltip" title="<?php echo htmlspecialchars($sf_request->getError('rates['.$errorId.'].maxQuantityPerPackage')) ?>"<?php endif ?>>
                                    <?php echo input_tag($name.'[max_quantity_per_package]', $rate ? $rate['max_quantity_per_package'] : 1, array('style' => 'width: 60px', 'maxlength' => 10, 'disabled' => !$rate, 'class' => 'price', 'data-min-value' => 1, 'data-decimals' => 0)) ?>
                                    <?php if ($rate && $sf_request->hasError('rates['.$errorId.'].maxQuantityPerPackage')): ?>
                                        <img style="width: 14px; vertical-align: middle" src="/images/update/red/status/alert.png">
                                    <?php endif ?>                                
                                </td>
                                <td <?php if ($rate && $sf_request->hasError('rates['.$errorId.'].nextItemPrice.amount')): ?>class="form-error error_tooltip" title="<?php echo htmlspecialchars($sf_request->getError('rates['.$errorId.'].nextItemPrice.amount')) ?>"<?php endif ?>>
                                    <?php echo input_tag($name.'[next_item_rate][amount]', stCurrency::formatPrice($rate ? $rate['next_item_rate']['amount'] : $rate['next_item_rate']['default']), array('style' => 'width: 60px; vertical-align: middle', 'maxlength' => 10, 'disabled' => !$rate, 'class' => 'price error')) ?>
                                    <?php echo input_hidden_tag($name.'[next_item_rate][currency]', $rate ? $rate['next_item_rate']['currency'] : 'PLN', array('class' => 'hidden', 'disabled' => !$rate)) ?>
                                    <?php if ($rate && $sf_request->hasError('rates['.$errorId.'].nextItemPrice.amount')): ?>
                                        <img style="width: 14px; vertical-align: middle" src="/images/update/red/status/alert.png">
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php if (null !== $rate) $errorId++ ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach ?>
    <?php endforeach ?>
</div>

<script type="text/javascript">
    jQuery(function($) {
        $(document).ready(function() {

            $('.error_tooltip').tooltip({"position":"top center","offset":[0,0],"tip":"#jquery_tooltip_512bdb8334ee9ec3b1bc9d634bc975e8","delay":0});

            var allegroDeliveries = $('#allegro-deliveries');

            allegroDeliveries.find('.active').change(function() {
                var checkbox = $(this);
                var tr = checkbox.closest('tr');

                tr.find('.price,.hidden').prop('disabled', !checkbox.prop('checked'));
            });
            

            allegroDeliveries.find('.price').change(function() {
                var input = $(this);
                var decimals = null !== input.data('decimals') ? input.data('decimals') : 2;
                var value = stPrice.fixNumberFormat(input.val(), decimals);
                var max = Number(input.data('max-value'));
                var min = Number(input.data('min-value'));
                
                if (max > 0 && Number(value) > max) {
                    value = stPrice.fixNumberFormat(max, decimals);
                }

                if (value < min) {
                    value = stPrice.fixNumberFormat(min, decimals);
                }

                input.val(value);
            });

            allegroDeliveries.find('.visibility-toggle').on('click', 'a', function() {
                var link = $(this);

                if (link.hasClass('show-all')) {
                    link.closest('div').find('.show-only-selected').show();
                    link.hide();
                    allegroDeliveries.find('.allegro-delivery-group').show();
                    allegroDeliveries.find('.allegro-delivery-table tbody tr').show();
                } else {
                    link.closest('div').find('.show-all').show();
                    link.hide();
                    showChecked();
                }
            });

            function showChecked () {
                var trs = $('#allegro-deliveries table tbody tr');

                $('.allegro-delivery-group').hide();

                trs.each(function() {
                    var tr = $(this);
                    var checked = tr.find('[type="checkbox"]').prop("checked");

                    if (checked) {
                        tr.show();
                        tr.closest('.allegro-delivery-group').show();
                    }  else {
                        tr.hide();
                    }
                });
            }  
            
            showChecked();
        });
    });
</script>
