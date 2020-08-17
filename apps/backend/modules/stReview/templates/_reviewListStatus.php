<?php if($reviewed_product): ?>
    <a style="text-decoration: none; background: none; padding: 0px; margin: 0px;" href="<?php echo st_url_for('stReview/edit') ?>?id=<?php echo $reviewed_product->getId() ?>" <?php if($reviewed_product->getDescription()!=""): ?> class="help" title="<?php echo $reviewed_product->getDescription() ?>" <?php endif; ?> >
    <?php $i=1; while($i<=$reviewed_product->getScore()) { ?>
        <img src="/images/frontend/theme/default2/star_icon.png" width="12" alt="star"/>
    <?php $i++; } ?></a>
    
    <div style="display:inline;">            
      <?php if ($reviewed_product->getAgreement()): ?>
        <span class="accept"><img src="/images/backend/yes_green.png" /></span>
      <?php elseif ($reviewed_product->getSkipped()): ?>
        <span class="skip"><img src="/images/backend/no_black.png" /></span>
      <?php else: ?>
        <a style="text-decoration: none;" href="<?php echo st_url_for('stReview/reviewAccept') ?>?id=<?php echo $reviewed_product->getId() ?>" class="ajax<?php echo $order_product->getId() ?> accept">
          <img src="/images/backend/yes_blue.png" />
        </a> 
        <a style="text-decoration: none;" href="<?php echo st_url_for('stReview/reviewSkip') ?>?id=<?php echo $reviewed_product->getId() ?>" class="ajax<?php echo $order_product->getId() ?> skip">
          <img src="/images/backend/no_blue.png" />
        </a>
      <?php endif; ?>
    </div>          
    
<?php else: ?>  
    
    <?php if(!$order_product): ?>
        
        <img class="img_send" src="/images/backend/no_black.png" width="16" />
    
    <?php elseif($order_product->getSendReview()!=""): ?>    
        <a style="text-decoration: none; background: none; padding: 0px; margin: 0px;" href="<?php echo st_url_for('stReview/sendReviewRequest') ?>?order_product_id=<?php echo $order_product->getId() ?>" class="help ajax_send<?php echo $order_product->getId() ?>" title="<?php echo stReview::getSendTime($order_product->getSendReview()); echo "<br/>".__("Kliknij aby wysłać ponownie."); ?>" >            
            <img class="img_send<?php echo $order_product->getId() ?>" src="/images/backend/sent2.png" width="20" />
        </a>
    <?php else: ?>
        <a style="text-decoration: none; background: none; padding: 0px; margin: 0px;" href="<?php echo st_url_for('stReview/sendReviewRequest') ?>?order_product_id=<?php echo $order_product->getId() ?>" class="help ajax_send<?php echo $order_product->getId() ?>" title="<?php echo __("Kliknij aby wysłać prośbę o recenzję."); ?>" >            
            <img class="img_send<?php echo $order_product->getId() ?>" src="/images/backend/send2.png" width="20" />
        </a>    
    <?php endif; ?>
    
<?php endif; ?>

<?php if($order_product): ?>
<script type="text/javascript">
jQuery(function($) {
  $('.ajax<?php echo $order_product->getId() ?>').click(function() {
    var link = $(this);
    $.post(link.attr('href'), {}, function() {
      if (link.hasClass('skip')) {
        link.parent().html('<span class="skip"><img src="/images/backend/no_black.png" /></span>');
      } else if (link.hasClass('accept')) {
        link.parent().html('<span class="accept"><img src="/images/backend/yes_green.png" /></span>');
      }
    });
    return false;
  });
  
  $('.ajax_send<?php echo $order_product->getId() ?>').click(function() {
    var link = $(this);    
    $('.img_send<?php echo $order_product->getId() ?>').attr("src", "/images/backend/review_loading.gif");    
    $.post(link.attr('href'), {}, function() {      
        link.html('<a style="text-decoration: none; background: none; padding: 0px; margin: 0px;" href="<?php echo st_url_for('stReview/sendReviewRequest') ?>?order_product_id=<?php echo $order_product->getId() ?>" class="ajax_send<?php echo $order_product->getId() ?>" ><img class="img_send<?php echo $order_product->getId() ?>" src="/images/backend/sent.png" width="20" /></a>');
      });
    return false;
  });
  
  
});
</script>
<?php endif; ?>