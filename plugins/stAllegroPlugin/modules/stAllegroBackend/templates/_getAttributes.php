<?php use_javascript('stAllegroPlugin/stAllegroEdit.js?v2');?>
<?php init_tooltip('.st-allegro-tooltip-ajax');?>
<?php 
if (!empty($attributes))
    echo stAllegroAttributes::process($attributes, $auction, $environment, $product);
?>

<script type="text/javascript">
    jQuery(function($) {
        $(document).ready(function() {
            <?php if(stAllegro::hasVariants($category, $environment)):?>
                stAllegroEdit.setVariantsActivity();

                $('#st-allegro-edit-options-row').hide();
                $('#st-allegro-edit-stock').prop('disabled', true);
            <?php else:?>
                $('#st-allegro-edit-options-row').show();
                $('#st-allegro-edit-stock').prop('disabled', false);
            <?php endif;?>
        });
    });
</script>
