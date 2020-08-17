<?php if (!$categoryTree->isRoot()): ?>
    <ul class="st_category_tree-menu">
        <li <?php echo get_tooltip('Awansuj kategorię') ?>>
            <?php echo link_to(image_tag('/images/backend/category_tree/arrows/arrow_left.png'), 'category/promote?id='.$categoryTree->getId()) ?>
        </li>
        <li <?php echo get_tooltip('Przesuń kategorię w górę') ?>>
            <?php echo link_to(image_tag('/images/backend/category_tree/arrows/arrow_up.png'), 'category/moveUp?id='.$categoryTree->getId()) ?>
        </li>
        <li <?php echo get_tooltip('Przesuń kategorię w dół') ?>>
            <?php echo link_to(image_tag('/images/backend/category_tree/arrows/arrow_down.png'), 'category/moveDown?id='.$categoryTree->getId()) ?>
        </li>
        <li <?php echo get_tooltip('Degraduj kategorię') ?>>
            <?php echo link_to(image_tag('/images/backend/category_tree/arrows/arrow_right.png'), 'category/degrade?id='.$categoryTree->getId()) ?>
        </li>
        <li <?php echo get_tooltip('Przejdź do edycji kategorii') ?>>
            <?php echo link_to(image_tag('backend/icons/edit.png'), 'category/edit?id='.$categoryTree->getId()) ?>
        </li>
        <li <?php echo get_tooltip('Usuń kategorię - usuwa daną kategorię wraz z jej podkategoriami') ?>>
            <?php echo link_to(image_tag('backend/icons/delete.png'), 'category/delete?id='.$categoryTree->getId()) ?>
        </li>
    </ul>
<?php else: ?>
    <ul class="st_category_tree-menu">
        <li <?php echo get_tooltip('Usuń drzewo') ?>><?php echo link_to(image_tag('backend/icons/delete.png'), 'category/delete?id='.$categoryTree->getId()) ?></li>
    </ul>
<?php endif; ?>