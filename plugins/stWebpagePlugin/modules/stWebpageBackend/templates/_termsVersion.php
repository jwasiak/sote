<input style="margin-bottom: 5px;" id="load_terms" type="button" value="<?php echo __('Załaduj szablon regulaminu'); ?>"><br/>

<?php echo __('Szablon regulaminu został opracowany zgodnie z aktualnym prawem. Obejmuje m.in. wymagania jakie weszły w życie po 25 grudnia 2014 r, nie zawiera klauzul niedozwolonych. Szablon regulaminu ma charakter ogólny, firma SOTE nie ponosi odpowiedzialności za jego użytkowanie.'); ?> 



<?php // echo $content; ?>
<script type="text/javascript">
jQuery(function ($)
{
    $(document).ready(function()
    {
        var iframe = $('.rich_text_editor');

        $( "#load_terms" ).click(function() {

        if (confirm('<?php echo __('Potwierdź pobranie szablonu regulaminu. Szablon zastąpi aktualny tekst po zapisie zmian.'); ?>')) {
            $('#toggle_webpage_content').remove();
            $('#webpage_content').val('<?php echo $content; ?>').change();
        }
    });
    
});

});

</script>

