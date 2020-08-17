<div class="row" style="padding: 0px;">
<label for="product_group_new"><?php echo __('Wybierz sposób wyświetlania nowości', array(), 'stProductGroup'); ?></label>
<div class="field">

	<?php 
	$manual = __('przypisane produkty', array(), 'stProductGroup');
	$date = __('po dacie dodania', array(), 'stProductGroup');


	$select_type = array(
	'manual' => $manual,
	'date' => $date
	);

	echo select_tag('new_type', options_for_select($select_type, $config_group->get('new_type')));?>

	</select>
<div class="clr"></div>
</div>
</div>
<div class="row" id="date" style="padding: 8px 0px 0px 0px;">

	<label for="product_group_new"><?php echo __('Produkty są w nowościach od:', array(), 'stProduct'); ?></label>
	<div class="field">
	<?php echo input_date_tag('new_product_date', $config->get('new_product_date'), array (
  'rich' => true,
  'withtime' => true,
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
)); ?>   
	<div class="clr"></div>
	</div>
</div>

<script type="text/javascript">
jQuery(function($) {
    $('#product_group_default_product_group').change(function() {
        var value = $(this).val();

        if (value == 'NEW') {
            $('.row_new').show();
        } else {
            $('.row_new').hide();
        }
    }).change();    
});

jQuery(function($) {
    $('#new_type').change(function() {
        var value = $(this).val();

        if (value == 'date') {
            $('#date').show();
            $('#sf_fieldset_etykieta').hide();
            $('#product_group_label_none').prop("checked", true);

            
        } else {
            $('#date').hide();
            $('#sf_fieldset_etykieta').show();
        }
    }).change();    
});
</script>

