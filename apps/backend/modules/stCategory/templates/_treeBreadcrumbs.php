<ul class="category_breadcrumbs">
    <li><a href="<?php echo $url ?>?category_filter=0"><?php echo __('Wszystkie') ?></a></li>
<?php foreach ($breadcrumbs as $category): $id = $category->getId(); ?>
     <li>&rsaquo;</li>
    <?php if ($category->isRoot()): ?>
    <li>
        <?php echo $category->getName() ?>
    </li>
    <?php elseif ($category->getId() == $selected): ?>
    <li>
        <?php echo $category->getName() ?>
    </li>
    <?php else: ?>
    <li>
        <a href="<?php echo $url ?>?category_filter=<?php echo $category->getId() ?>"><?php echo $category->getName() ?></a>
    </li>    
    <?php endif; ?>
<?php endforeach; ?>
</ul>