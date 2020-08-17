<?php echo input_tag('filters[number]', isset($filters['number']) ? $filters['number'] : null, array('class' => 'string-type')); ?>

<script>
jQuery(function($) {
    $('#filters_number').change(function() {
        var input = $(this);
        var form = input.closest('form');

        var filters = form.find('input[type!=submit],select').not(input).not('[type=image]');

        filters.prop('disabled', input.val().length > 0);
    });
});
</script>