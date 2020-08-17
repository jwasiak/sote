<div class="application-menu">
    <ul>
        <?php foreach ($items as $current => $name): ?>
            <li class="<?php echo $selected == $current ? 'selected' : 'none' ?>"><a href="<?php echo $current ?>"><?php echo __($name) ?></a></li>
        <?php endforeach; ?>
        <div class="clr"></div>
    </ul>
</div>