<?php use_helper('stAdminGenerator') ?>
<?php use_stylesheet('backend/stCategory.css') ?>
<?php foreach ($iterators as $iterator): ?>
    <h3>
        <?php echo $iterator->getRoot()->getName() ?>
    </h3>
    <ul id="st_category_tree-list">
        <?php foreach ($iterator->getDescendants() as $descendat): ?> 
            <li style="margin-left: <?php echo $descendat->getLevel()*20 ?>px">
                <?php echo checkbox_tag('category['.$descendat->getId().']', $descendat->getId(), $descendat->hasDatabaseRecord($object) || $sf_request->getParameter('category['.$descendat->getId().']')) ?> 
                <?php echo label_for('category['.$descendat->getId().']', $descendat->getName()) ?>
                <br class="st_clear_all" />
            </li>
        <?php endforeach; ?>
    </ul>
    <br class="st_clear_all" />
<?php endforeach; ?>