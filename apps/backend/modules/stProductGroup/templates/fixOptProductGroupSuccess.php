<?php use_helper('stProgressBar'); ?>
<?php echo progress_bar('stProductGroup_optimize', 'stProductGroupOptimize', 'updateOptimize', ProductGroupHasProductPeer::doCount(new Criteria())); ?>

