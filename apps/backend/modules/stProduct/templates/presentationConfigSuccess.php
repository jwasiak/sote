<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>
<?php st_include_partial('stProduct/header', array('related_object' => null, 'title' => __('Prezentacja', 
array(), 'stProduct'), 'route' => 'stProduct/presentationConfig')) ?>
<?php st_include_component('stProduct', 'configMenu', array('forward_parameters' => $forward_parameters)) ?>
  
<div id="sf_admin_content">
   <?php st_include_partial('stProduct/config_messages', array('config' => $config, 'labels' => $labels, 'forward_parameters' => $forward_parameters)) ?>
   <?php st_include_partial('stProduct/presentation_config_form', array('config' => $config, 'labels' => $labels, 'forward_parameters' => $forward_parameters)) ?>  
</div>

<?php if ($config->get('global_price_netto')){ ?>
<script type="text/javascript">
 jQuery(function($) {
	document.getElementById("config_price_view").disabled = true;
	document.getElementById("config_price_view").value = "only_net";
	var config_price_view = document.createElement("input");
	config_price_view.setAttribute("type", "hidden");
	config_price_view.setAttribute("name", "config[price_view]");
	config_price_view.setAttribute("value", "only_net");
	document.getElementById("config_actions").appendChild(config_price_view);

	
	document.getElementById("config_price_view_long").disabled = true;
	document.getElementById("config_price_view_long").value = "only_net";
	var config_price_view_long = document.createElement("input");
	config_price_view_long.setAttribute("type", "hidden");
	config_price_view_long.setAttribute("name", "config[price_view_long]");
	config_price_view_long.setAttribute("value", "only_net");
	document.getElementById("config_actions").appendChild(config_price_view_long);


	document.getElementById("config_price_view_group").disabled = true;
	document.getElementById("config_price_view_group").value = "only_net";
	var config_price_view_group = document.createElement("input");
	config_price_view_group.setAttribute("type", "hidden");
	config_price_view_group.setAttribute("name", "config[price_view_group]");
	config_price_view_group.setAttribute("value", "only_net");
	document.getElementById("config_actions").appendChild(config_price_view_group);

	<?php if (stTheme::getInstance(sfContext::getInstance())->getVersion() < 7){ ?>

	document.getElementById("config_price_view_short").disabled = true;
	document.getElementById("config_price_view_short").value = "only_net";
	var config_price_view_short = document.createElement("input");
	config_price_view_short.setAttribute("type", "hidden");
	config_price_view_short.setAttribute("name", "config[price_view_short]");
	config_price_view_short.setAttribute("value", "only_net");
	document.getElementById("config_actions").appendChild(config_price_view_short);


	document.getElementById("config_price_view_other").disabled = true;
	document.getElementById("config_price_view_other").value = "only_net";
	var config_price_view_other = document.createElement("input");
	config_price_view_other.setAttribute("type", "hidden");
	config_price_view_other.setAttribute("name", "config[price_view_other]");
	config_price_view_other.setAttribute("value", "only_net");
	document.getElementById("config_actions").appendChild(config_price_view_other);

	<?php } ?>
	
});
</script>
<?php } ?>


    
<?php st_include_partial('stProduct/footer', array('related_object' => null, 'forward_parameters' => $forward_parameters)) ?>