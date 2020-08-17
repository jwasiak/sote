<?php 
  use_helper('stText', 'stUrl');
  use_stylesheet('backend/style.css');
  $name_lenght = '40';
  $desc_lenght = '145';
  $author_lenght = '40';
?>
<div id="review_gadget">
  <?php if($reviews): ?>
    <?php foreach ($reviews as $index => $review): ?>
      <div class="item">
        <div style="padding-top: 5px;">
          <div style="float: left;">
            <div style="width: 80px; float: left;">
              <?php $i=1; while($i<=$review->getScore()) { ?>
                <img src="/images/frontend/theme/default2/star_icon.png" width="10" alt="star"/>
              <?php $i++; } ?>
            </div>
            <div style="float: left;">
              <em><?php echo st_link_to(st_truncate_text($review->getProduct(), $name_lenght), 'stReview/edit?id='.$review->getId(), array('target' => '_top')); ?></em>
            </div>
          </div>
          <div style="float: right; font-size: 11px;">
            <?php echo $review->getCreatedAt(); ?>
          </div>
        </div>
        <div class="teaser" style="clear: both; padding-bottom: 5px;">
          <?php echo st_truncate_text($review->getDescription(), $desc_lenght); ?><br />
          <?php if ($review->getAdminName()): ?>
            <span style="float: right;">[<i><?php echo st_truncate_text($review->getAdminName(), $author_lenght); ?></i>]</span>
          <?php elseif ($review->getUsername()): ?>
            <span style="float: right;">[<i><?php echo st_truncate_text($review->getUsername(), $author_lenght); ?></i>]</span>
          <?php endif; ?>
        </div>
        <div class="complete" style="clear: both; padding-bottom: 5px; display: none;">
          <?php echo $review->getDescription(); ?>
          <?php if ($review->getAdminName()): ?>
            <span style="float: right;">[<i><?php echo st_truncate_text($review->getAdminName(), $author_lenght); ?></i>]</span>
          <?php elseif ($review->getUsername()): ?>
            <span style="float: right;">[<i><?php echo st_truncate_text($review->getUsername(), $author_lenght); ?></i>]</span>
          <?php endif; ?>
        </div>
        <?php $lang = $review->getLanguage(); ?>
        <?php $c = new Criteria(); ?>
        <?php $c->add(LanguagePeer::LANGUAGE, $lang); ?>
        <?php $language = LanguagePeer::doSelectOne($c); ?>
        <?php if($language->getActiveImage()):?>
          <?php echo image_tag('/'.sfConfig::get('sf_upload_dir_name')."/stLanguagePlugin/".$language->getActiveImage(), array('style' => 'vertical-align: middle; margin-right: 5px')); ?>
        <?php else:?>
          <?php echo $language; ?>
        <?php endif;?>
        <?php if (strlen($review->getDescription()) > $desc_lenght): ?>
          <span class="more"><?php echo __("więcej...", null, "stBackend") ?></span>
        <?php endif; ?>
        <div style="clear: both; float: right;">
          <?php if ($review->getAgreement()): ?>
            <span class="accept"><?php echo __("zatwierdzona", null, "stBackend") ?></span>
          <?php else: ?>
            <a href="<?php echo gadget_url_for('@stDashboardGadget?action=reviewGadget', array('review_id' => $review->getId(), 'type' => 'accept')) ?>" class="ajax accept">
              <?php echo __('zatwierdź', null, 'stBackend') ?>
            </a> 
            |
            <a class="ajax skip" href="<?php echo gadget_url_for('@stDashboardGadget?action=reviewGadget', array('review_id' => $review->getId(), 'type' => 'skip')) ?>">
              <?php echo __('pomiń', null, 'stBackend') ?>
            </a>
          <?php endif; ?>
        </div>
        <div style="clear: both; border-bottom: 1px solid #DDDDDD; padding-bottom: 5px;"></div>
      </div>    
    <?php endforeach; ?>
    <div style="clear: both; text-align: right; padding-top: 15px;">
      <?php echo st_link_to( __('zobacz więcej', null, 'stBackend'), 'stReview/list', array('target' => '_top')); ?>
    </div>
  <?php else: ?>
    <p style="font-family: Helvetica,Arial,sans-serif; margin-top: 10px; padding-left: 15px;"><?php echo __('Brak nowych recenzji', null, 'stBackend') ?></p>
  <?php endif; ?>
</div>
<script type="text/javascript">
jQuery(function($) {
  $('.ajax').click(function() {
    var link = $(this);
    $.post(link.attr('href'), {}, function() {
      if (link.hasClass('skip')) {
        link.parents('.item').first().remove();
        var review_gadget = $('#review_gadget');
        if (review_gadget.children('.item').length == 0) {
          review_gadget.html('<p style="font-family: Helvetica,Arial,sans-serif; margin-top: 0px"><?php echo __('Brak nowych recenzji', null, 'stBackend') ?></p>');
        }
      } else if (link.hasClass('accept')) {
        link.parent().html('<span class="accept" style="float: right;"><?php echo __("zatwierdzona", null, "stBackend") ?></span>');
      }
    });
    return false;
  });
  $(".more").toggle(function(){
    $(this).text('<?php echo __("mniej...", null, "stBackend") ?>').siblings(".complete").show();
    $(this).text('<?php echo __("mniej...", null, "stBackend") ?>').siblings(".teaser").hide();        
  }, function(){
    $(this).text('<?php echo __("więcej...", null, "stBackend") ?>').siblings(".complete").hide();
    $(this).text('<?php echo __("więcej...", null, "stBackend") ?>').siblings(".teaser").show();   
  });
});
</script>