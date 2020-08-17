<?php use_helper('stProgressBar'); ?>
<?php if ($checked): ?>
    <?php echo progress_bar('stFixCode', 'stFixCode', 'fixCode', stFixCode::countProducts()); ?>
<?php else :?>
    <?php echo __("Operacja ta zmieni wszystkie niedozwolone kody na poprawne.")?>
    <?php echo link_to(__("Wykonaj."),'stProduct/fixCode?checked=true')?>
<?php endif; ?>