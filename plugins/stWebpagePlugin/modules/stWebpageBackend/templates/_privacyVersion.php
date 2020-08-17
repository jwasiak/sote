<input style="margin-bottom: 5px;" id="load_privacy" type="button" value="<?php echo __('Załaduj szablon polityki prywatności'); ?>"><br/>

<?php echo __('Szablon "Polityki prywatności" jest integralną częścią wzoru regulaminu (ładowanego szablonu). SOTE nie ponosi odpowiedzialności za jego użytkowanie.'); ?> 



<?php // echo $content; ?>
<script type="text/javascript">
jQuery(function ($)
{
    $(document).ready(function()
    {
       var iframe = $('.rich_text_editor');
       
       $( "#load_privacy" ).click(function() {
       
        if (confirm('<?php echo __('Potwierdź pobranie szablonu regulaminu. Szablon zastąpi aktualny tekst po zapisie zmian.'); ?>')) {
            $('#toggle_webpage_content').remove();
            $('#webpage_content').val('<?php echo $content; ?>').change();
        }
    });
    
});

});

</script>

