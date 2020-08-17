<?php $positioningOptions = array(stPositioning::TYPE_GENERATE => __('Generuj automatycznie'), stPositioning::TYPE_USER => __('Ustaw samodzielnie'));?>
<?php echo select_tag("producer_has_positioning[type]", options_for_select($positioningOptions, $producer_has_positioning->getType())); ?>

<script>
jQuery(function($) {
	var data = <?php echo json_encode($positioning_data) ?>;
	
	if ($('#producer_has_positioning_type').val() == 2) {
		$('#producer_has_positioning_title').val(data[2].title);
		$('#producer_has_positioning_description').val(data[2].desc);
		$('#producer_has_positioning_keywords').val(data[2].keywords);
	}

	$('#producer_has_positioning_type').change(function() {
		var disabled = $(this).val() == 2;
		$('#producer_has_positioning_title').prop('disabled', disabled);
		$('#producer_has_positioning_description').prop('disabled', disabled);
		$('#producer_has_positioning_keywords').prop('disabled', disabled);
	}).change();
});	
</script>