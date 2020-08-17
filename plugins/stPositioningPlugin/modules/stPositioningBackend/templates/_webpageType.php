<?php $positioningOptions = array(stPositioning::TYPE_GENERATE => __('Generuj automatycznie'), stPositioning::TYPE_USER => __('Ustaw samodzielnie'));?>
<?php echo select_tag("webpage_has_positioning[type]", options_for_select($positioningOptions, $webpage_has_positioning->getType())); ?>

<script>
jQuery(function($) {
	var data = <?php echo json_encode($positioning_data) ?>;
	
	if ($('#webpage_has_positioning_type').val() == 2) {
		$('#webpage_has_positioning_title').val(data[2].title);
		$('#webpage_has_positioning_description').val(data[2].desc);
		$('#webpage_has_positioning_keywords').val(data[2].keywords);
	}

	$('#webpage_has_positioning_type').change(function() {
		var disabled = $(this).val() == 2;
		$('#webpage_has_positioning_title').prop('disabled', disabled);
		$('#webpage_has_positioning_description').prop('disabled', disabled);
		$('#webpage_has_positioning_keywords').prop('disabled', disabled);
	}).change();
});	
</script>