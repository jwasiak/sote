<?php
use_javascript('/js/jquery.rating.js', 'last');
st_theme_use_stylesheet('stReview.css');
?>

<script type="text/javascript" language="javascript">
jQuery(function ($)
{
    $(document).ready(function ()
    {
        $('.auto-submit-star').rating({
            callback: function(value, link)
            {
                showReviewPopUp();
            }
        });
        
        <?php  if($show_review_popup == 1): ?>
            showReviewPopUp();
        <?php endif; ?>
        
        function showReviewPopUp(){
           <?php  if(stTheme::is_responsive()): ?>
 
                    $('#star_raiting_modal').modal('show');
                
                $.get('<?php echo url_for('stReview/showAddOverlay') ?>', { 'value': $('input.auto-submit-star:checked').val(),'product_id':'<?php echo $product->getId(); ?>','hash_code':'<?php echo $hash_code  ?>'}, function(data)
                {
                    $('#star_raiting').html(data);
                });
            
           <?php else: ?>
            
                var api = $('#star_raiting_overlay').data('overlay');

                if (!api)
                {
                    $('#star_raiting_overlay').overlay(
                    {
                        onBeforeLoad: function()
                        {
                            var wrap = this.getOverlay().find('.overlay_content');
                            $.get('<?php echo url_for('stReview/showAddOverlay') ?>', { 'value': $('input.auto-submit-star:checked').val(),'product_id':'<?php echo $product->getId(); ?>','hash_code':'<?php echo $hash_code ?>'}, function(data)
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
        };    
        
    });
});
</script>
<?php
$smarty->assign('scores', $scores);
$smarty->assign('count_review', $count_review);
$smarty->assign('star_raiting', $star_raiting);
$smarty->assign('lockd_star', $lockd_star); 
$smarty->display('review_show_stars.html');
?>