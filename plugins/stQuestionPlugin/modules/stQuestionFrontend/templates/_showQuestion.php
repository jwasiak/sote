<?php if (!$is_ajax): ?>
   <div id="question-container">
<?php endif; ?>
<?php
st_theme_use_stylesheet('stQuestionPlugin.css');
if ($smarty->get_template_vars('show_ask_depository') || $smarty->get_template_vars('show_ask_price'))
{
    $smarty->display('question_show_question.html');
}
?>
<?php if (!$is_ajax): ?>
   </div>
<?php endif; ?>
<script type="text/javascript" language="javascript">
   jQuery(function ($)
   {
      $(document).ready(function ()
      {
         $('#active_price_question_overlay').click(function()
         {

           <?php  if(stTheme::is_responsive()): ?>

                $('#price_question_modal').modal('show');

                $.get('<?php echo url_for('stQuestionFrontend/showAddOverlay') ?>', { 'product_id':'<?php echo $product->getId(); ?>','question_type':'price'}, function(data)
                {
                    $('#price_question').html(data);
                });

           <?php else: ?>

            var api = $('#price_question_overlay').data('overlay');

            if (!api)
            {
               $('#price_question_overlay').overlay(
               {

                  onBeforeLoad: function()
                  {
                     var wrap = this.getOverlay().find('.price_question_overlay_content');
                     $.get('<?php echo url_for('stQuestionFrontend/showAddOverlay') ?>', { 'product_id':'<?php echo $product->getId(); ?>','question_type':'price'}, function(data)
                     {
                        wrap.html(data);
                     });
                  },
                  load: true
               });
            }
            else
            {
               api.load();
            }

            <?php endif; ?>
         });

         $('#active_depository_question_overlay').click(function()
         {
            <?php  if(stTheme::is_responsive()): ?>

                $('#depository_question_modal').modal('show');

                $.get('<?php echo url_for('stQuestionFrontend/showAddOverlay') ?>', { 'product_id':'<?php echo $product->getId(); ?>','question_type':'depository'}, function(data)
                {
                    $('#depository_question').html(data);
                });

           <?php else: ?>

            var api = $('#depository_question_overlay').data('overlay');

            if (!api)
            {
               $('#depository_question_overlay').overlay(
               {

                  onBeforeLoad: function()
                  {
                     var wrap = this.getOverlay().find('.depository_question_overlay_content');
                     $.get('<?php echo url_for('stQuestionFrontend/showAddOverlay') ?>', { 'product_id':'<?php echo $product->getId(); ?>','question_type':'depository'}, function(data)
                     {
                        wrap.html(data);
                     });
                  },
                  load: true
               });
            }
            else
            {
               api.load();
            }

             <?php endif; ?>
         });
      });
   });
</script>
