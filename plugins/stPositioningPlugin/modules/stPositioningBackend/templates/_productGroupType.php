<?php $positioningOptions = array(stPositioning::TYPE_GENERATE => __('Generuj automatycznie'), stPositioning::TYPE_USER => __('Ustaw samodzielnie'));?>
<?php echo select_tag("product_group_has_positioning[type]", options_for_select($positioningOptions, $product_group_has_positioning->getType()));?>

<script>
jQuery(function($) {
	var data = <?php echo json_encode($positioning_data) ?>;
	
	if ($('#product_group_has_positioning_type').val() == 2) {
		$('#product_group_has_positioning_title').val(data[2].title);
		$('#product_group_has_positioning_description').val(data[2].desc);
		$('#product_group_has_positioning_keywords').val(data[2].keywords);
	}

	$('#product_group_has_positioning_type').change(function() {
		var disabled = $(this).val() == 2;
		$('#product_group_has_positioning_title').prop('disabled', disabled);
		$('#product_group_has_positioning_description').prop('disabled', disabled);
		$('#product_group_has_positioning_keywords').prop('disabled', disabled);
	}).change();
});	
</script>