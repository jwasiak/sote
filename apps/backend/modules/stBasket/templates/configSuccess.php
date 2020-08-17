<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>

<?php st_include_partial('stBasket/header', array('related_object' => null, 'title' => __('Konfiguracja', 
array(), 'stBasket'), 'route' => 'stBasket/config')) ?>

<?php st_include_component('stBasket', 'configMenu', array('forward_parameters' => $forward_parameters)) ?>
     
<div id="sf_admin_content">
   <?php st_include_partial('stBasket/config_messages', array('config' => $config, 'labels' => $labels, 'forward_parameters' => $forward_parameters)) ?>
   <?php st_include_partial('stBasket/config_form', array('config' => $config, 'labels' => $labels, 'forward_parameters' => $forward_parameters)) ?> 
</div>

<?php 
$config_product = stConfig::getInstance('stProduct');
if ($config_product->get('global_price_netto')){
?>
<script type="text/javascript">
jQuery(function($) {
	document.getElementById("config_show_netto_in_basket").disabled = true;
	document.getElementById("config_show_netto_in_basket").value = 1;
	var config_show_netto_in_basket = document.createElement("input");
	config_show_netto_in_basket.setAttribute("type", "hidden");
	config_show_netto_in_basket.setAttribute("name", "config[show_netto_in_basket]");
	config_show_netto_in_basket.setAttribute("value", "1");
	document.getElementById("config_actions").appendChild(config_show_netto_in_basket);
});
</script>
<?php } ?>
    
<?php st_include_partial('stBasket/footer', array('related_object' => null, 'forward_parameters' => $forward_parameters)) ?>