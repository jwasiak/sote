<?php use_helper('stText', 'stUrl'); ?>
<?php $name_lenght = '15'; ?>
<div style="width: 100px"><?php echo st_link_to(st_truncate_text($review->getProduct(), $name_lenght), 'review/edit?id='.$review->getId()); ?></div>