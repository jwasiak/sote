<?php use_helper('stPrice') ?>

<?php $groups = array('a', 'b', 'c') ?>
<table class="st_record_list" cellspacing="0">
    <thead>
        <tr>
<?php foreach ($groups as $group): ?>
            <th colspan="2"><?php echo __('Grupa %name%', array('%name%' => strtoupper($group))) ?></th>
<?php endforeach ?>
        </tr>
        <tr>
<?php foreach ($groups as $group): ?>
            <th><?php echo __('Netto') ?></th>
            <th><?php echo __('Brutto') ?></th>
<?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <tr>
<?php foreach ($groups as $group): $getter_netto = 'getWholesale'.ucfirst($group).'Netto'; $getter_brutto = 'getWholesale'.ucfirst($group).'Brutto'; $getter_currency = 'getCurrencyWholesale'.ucfirst($group) ?>
            <td><?php echo input_tag ('add_price[wholesale]['.$group.'][netto]', st_price_format($add_price->$getter_netto()), array('size' => 7)) ?></td>
            <td><?php echo input_tag ('add_price[wholesale]['.$group.'][brutto]', st_price_format($add_price->$getter_brutto()), array('size' => 7)) ?></td>
<?php endforeach ?>
        </tr>
    </tbody>
</table>
<?php foreach ($groups as $group): ?>
<?php st_price_tax_manager_add_price_field(array('price' => 'add_price_wholesale_'.$group.'_netto', 'priceWithTax' => 'add_price_wholesale_'.$group.'_brutto')); ?>
<?php endforeach ?>

