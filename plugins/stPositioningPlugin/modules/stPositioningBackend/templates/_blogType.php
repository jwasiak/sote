<?php $positioningOptions = array(stPositioning::TYPE_GENERATE => __('Generuj automatycznie'), stPositioning::TYPE_USER => __('Ustaw samodzielnie'));?>
<?php echo select_tag("blog_has_positioning[type]", options_for_select($positioningOptions, $blog_has_positioning->getType())); ?>

<script>
jQuery(function($) {
	var data = <?php echo json_encode($positioning_data) ?>;
	
	if ($('#blog_has_positioning_type').val() == 2) {
		$('#blog_has_positioning_title').val(data[2].title);
		$('#blog_has_positioning_description').val(data[2].desc);
		$('#blog_has_positioning_keywords').val(data[2].keywords);
	}

	$('#blog_has_positioning_type').change(function() {
		var disabled = $(this).val() == 2;
		$('#blog_has_positioning_title').prop('disabled', disabled);
		$('#blog_has_positioning_description').prop('disabled', disabled);
		$('#blog_has_positioning_keywords').prop('disabled', disabled);
	}).change();
});	
</script>