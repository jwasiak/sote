<?php  
	use_helper('stText', 'stProductImage');
	sfLoader::loadHelpers('stProduct', 'stProduct');
	use_stylesheet("backend/stDashboardGadget.css");
?>

<?php $lang = sfContext::getInstance()->getUser()->getCulture(); ?>
<div id="sote_blog">
	<?php 

		$i=0;

		while ($i<=3){

			$image = $results->posts[$i][0];
			$url = $results->posts[$i][1];
			$title = $results->posts[$i][2];
			$desc = $results->posts[$i][3];
			$date = $results->posts[$i][4];

	?>

	<div class="item" style="float: left; width: 580px; height: 87px;">

		<div style="float: left;">
			<a href="<?php echo $url; ?>" target="_blank"><img width="146" height="77" class="wp-image" src="<?php echo $image; ?>" alt=" " /></a>
		</div>

		<div style="float: left; width: 300px; padding-left: 10px;">
			<h3 class="post-title" style="color: #000000; font-size: 13px; font-weight: 600; margin-bottom: 1px;"><?php echo $title; ?></h3>
			<a class="desc" href="<?php echo $url; ?>" style="text-decoration:none; color: #9f9f9f;" target="_blank"><?php echo st_truncate_text($desc, 140)."..."; ?></a>
		</div>

		<div style="float: left;">
			<span class="date" style="color: #868686; display: block; font-size: 11px; margin: 0px 0px 17px 50px; font-style: italic;"><?php echo $date; ?></span>
		</div>
	</div>
		
	<?php

			$i++;
		}

	?>
<!-- 	<div id="sote_social">
         <?php if ($lang == 'pl_PL'): ?>
            <a class="forum" href="http://forum.sote.pl/" title="<?php echo __('Forum') ?>" target="_blank"></a>
         <?php else: ?>
            <a class="forum" href="http://forum.soteshop.com/" title="<?php echo __('Forum') ?>" target="_blank"></a>
         <?php endif; ?>
         <a class="twitter" href="https://twitter.com/soteshop" title="<?php echo __('Twitter') ?>" target="_blank"></a>
         <a class="gplus" href="https://plus.google.com/118079187976432062238" title="<?php echo __('Google +') ?>" target="_blank"></a>
         <a class="youtube" href="http://www.youtube.com/user/soteshop6" title="<?php echo __('YouTube') ?>" target="_blank"></a>
         <?php if ($lang == 'pl_PL'): ?>
            <a class="facebook" href="http://www.facebook.com/soteshopsoftware" title="<?php echo __('Facebook') ?>" target="_blank"></a>
         <?php else: ?>
            <a class="facebook" href="http://www.facebook.com/sotebuy" title="<?php echo __('Facebook') ?>" target="_blank"></a>
         <?php endif; ?>
	</div> -->
    <div style="clear: both"></div>
</div>