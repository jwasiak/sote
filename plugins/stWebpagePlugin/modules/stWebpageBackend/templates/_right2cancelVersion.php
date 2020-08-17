<input style="margin-bottom: 5px;" id="load_right2cancel" type="button" value="<?php echo __('Załaduj szablon odstąpienia od umowy'); ?>"><br/>

<?php echo __('Szablon "Odstąpienia od umowy" jest integralną częścią wzoru regulaminu. SOTE nie ponosi odpowiedzialności za jego użytkowanie.'); ?> 



<?php // echo $content; ?>
<script type="text/javascript">
jQuery(function ($) {
   $(document).ready(function() {
      var iframe = $('.rich_text_editor');

      $( "#load_right2cancel" ).click(function() {

         if (confirm('<?php echo __('Potwierdź pobranie szablonu regulaminu. Szablon zastąpi aktualny tekst po zapisie zmian.'); ?>')) {
            $('#toggle_webpage_content').remove();
            $('#webpage_content').val('<?php echo addslashes($content); ?>').change();
         }
      });
   });

});

</script>

