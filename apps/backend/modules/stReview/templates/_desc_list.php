<?php use_helper('stText', 'stUrl'); ?>
<?php $desc_lenght = '50'; ?>
<?php $author_lenght = '40'; ?>
<p class="teaser">
  <?php echo st_truncate_text($review->getDescription(), $desc_lenght); ?>
</p>
<p class="complete" style="display: none; white-space: normal;">
  <?php echo $review->getDescription(); ?>
</p>
<?php if ($review->getAdminName()): ?>
  <span style="float: right;">[<i><?php echo st_truncate_text($review->getAdminName(), $author_lenght); ?></i>]</span>
<?php elseif ($review->getUsername()): ?>
  <span style="float: right;">[<i><?php echo st_truncate_text($review->getUsername(), $author_lenght); ?></i>]</span>
<?php endif; ?>
<?php if (strlen($review->getDescription()) > $desc_lenght): ?>
  <p class="more"><?php echo __("więcej...", null, "stBackend") ?></p>
<?php endif; ?>
<script type="text/javascript">
jQuery(function($) {
  $(".more").toggle(function(){
    $(this).text('<?php echo __("mniej...", null, "stBackend") ?>').siblings(".complete").show();
    $(this).text('<?php echo __("mniej...", null, "stBackend") ?>').siblings(".teaser").hide();        
  }, function(){
    $(this).text('<?php echo __("więcej...", null, "stBackend") ?>').siblings(".complete").hide();
    $(this).text('<?php echo __("więcej...", null, "stBackend") ?>').siblings(".teaser").show();   
  });
});
</script>