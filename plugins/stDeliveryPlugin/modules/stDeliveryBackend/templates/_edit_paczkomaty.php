<?php echo select_tag('delivery[paczkomaty_size]', options_for_select(array('A' => 'A (8 x 38 x 64 cm)', 'B' => 'B (19 x 38 x 64 cm)', 'C' => 'C (41 x 38 x 64 cm)'), $delivery->getPaczkomatySize())); ?>

<input name="delivery[paczkomaty_dimension]" id="delivery_paczkomaty_dimension" type="hidden" value="[<?php echo $delivery->getWidth() ?>, <?php echo $delivery->getHeight() ?>, <?php echo $delivery->getDepth() ?>]" />
<script type="text/javascript">
    jQuery(function($) {
        var deliveries = <?php echo json_encode(DeliveryTypePeer::doSelectArrayCached()) ?>;
        var dimensions = {
            'A': [8, 38, 64],
            'B': [19, 38, 64],
            'C': [41, 38, 64]
        };

        var delivery_width = $('#delivery_width');
        var delivery_height = $('#delivery_height');
        var delivery_depth = $('#delivery_depth');
        var paczkomaty_dimension = $('#delivery_paczkomaty_dimension');

        $('#delivery_type_id').change(function() {
            var select = $(this);

            if (select.val() && deliveries[select.val()].type == 'inpostp') {
                $('.row_edit_paczkomaty').show();
            } else {
                $('.row_edit_paczkomaty').hide();
            }
        }).change();


        $('#delivery_paczkomaty_type').change(function() {
            $('#delivery_paczkomaty_size').attr('disabled', !this.selectedIndex);
            delivery_width.attr('disabled', this.selectedIndex > 0);
            delivery_height.attr('disabled', this.selectedIndex > 0);
            delivery_depth.attr('disabled', this.selectedIndex > 0);
            if (this.selectedIndex > 0) {
                $('#delivery_paczkomaty_size').change();
            } else {
                delivery_width.val(delivery_width.prop('defaultValue'));
                delivery_height.val(delivery_height.prop('defaultValue'));
                delivery_depth.val(delivery_depth.prop('defaultValue'));          
            }
        });

        $('#delivery_paczkomaty_size').change(function() {
            var dimension = dimensions[$(this).val()];
            delivery_width.val(dimension[1]);
            delivery_height.val(dimension[0]);
            delivery_depth.val(dimension[2]);  
            paczkomaty_dimension.val('['+dimension.join(', ')+']');
        });
    });
</script>
