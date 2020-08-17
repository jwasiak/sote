<div style="width: 95px">
  <?php if ($review->getAgreement()): ?>
    <span class="accept"><?php echo __("zatwierdzona", null, "stBackend") ?></span>
  <?php elseif ($review->getSkipped()): ?>
    <span class="skip"><?php echo __("pominięta", null, "stBackend") ?></span>
  <?php else: ?>
    <a href="<?php echo st_url_for('stReview/reviewAccept') ?>?id=<?php echo $review->getId() ?>" class="ajax accept">
      <?php echo __('zatwierdź', null, 'stBackend') ?>
    </a> 
    |
    <a href="<?php echo st_url_for('stReview/reviewSkip') ?>?id=<?php echo $review->getId() ?>" class="ajax skip">
      <?php echo __('pomiń', null, 'stBackend') ?>
    </a>
  <?php endif; ?>
</div>
<script type="text/javascript">
jQuery(function($) {
  $('.ajax').click(function() {
    var link = $(this);
    $.post(link.attr('href'), {}, function() {
      if (link.hasClass('skip')) {
        link.parent().html('<span class="skip" style="float: left;"><?php echo __("pominięta", null, "stBackend") ?></span>');
      } else if (link.hasClass('accept')) {
        link.parent().html('<span class="accept" style="float: left;"><?php echo __("zatwierdzona", null, "stBackend") ?></span>');
      }
    });
    return false;
  });
});
</script>   