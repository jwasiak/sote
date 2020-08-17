<?php use_helper('stPrice') ?>

<?php
$taxes =  TaxPeer::doSelect(new Criteria());

$tax_values = array();

foreach ($taxes as $tax)
{
    $tax_values[] = $tax->getVat();
}

st_price_tax_managment_init(array(
        'taxField' => 'delivery_edit_tax',
        'taxValues' => $tax_values,
        'priceFields' => array(
                array('price' => 'delivery_cost_netto', 'priceWithTax' => 'delivery_cost_brutto'),
                array('price' => 'cost_netto', 'priceWithTax' => 'cost_brutto'),
        )));
?>

<?php echo select_tag('delivery[edit_tax]', options_for_select(_get_options_from_objects($taxes, 'getVatName'), $delivery->getTax()->getId())) ?>


<?php //echo object_select_tag($delivery->getTax(), 'getId', array('related_class' => 'Tax','text_method' => 'getVatName', 'control_name' => 'delivery[edit_tax]')) ?>
