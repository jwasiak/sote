<?php use_helper('stProgressBar') ?>
<?php foreach ($langs as $lang): ?>
<?php echo progress_bar('stPositioning_sitemap_'.$lang,'stSitemapGenerator','step_'.$lang,$count); ?>
<?php endforeach; ?>
