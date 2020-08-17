<?php use_helper('Javascript'); ?>
<li style="margin-left: <?php echo $categoryTree->getLevel() * 20 ?>px">
    <?php st_include_partial('categoryRow', array('categoryTree' => $categoryTree)); ?>
</li>