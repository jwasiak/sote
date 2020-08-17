<?php use_helper('stProgressBar'); ?>
<?php if (function_exists('st_include_component') ):?>
    <?php st_include_component('stProgressBar','progressBar', array('complete' => $complete, 'name' => $name, 'msg'=>$msg, 'title'=>$title)); ?> 
<?php else: ?>
    <?php include_component('stProgressBar','progressBar', array('complete' => $complete, 'name' => $name, 'msg'=>$msg, 'title'=>$title)); ?>
<?php endif;?>

<?php if ($makeNextProgress): ?>
       <?php echo progress_bar_update($name, $step, array('msg'=>$msg, 'fatal_msg'=>$fatal_msg)); ?>
<?php endif; ?>