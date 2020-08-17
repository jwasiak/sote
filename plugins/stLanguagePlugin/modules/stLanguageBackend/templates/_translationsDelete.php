<?php echo checkbox_tag('language[delete_file]', 1, false);?>

<?php if(!$hasTranslations):?>
    <script type="text/javascript">
        jQuery(function($) {
            $(document).ready(function() {     
                $('#sf_fieldset_usuwanie').hide();
            });
        });
    </script>
<?php endif;?>
