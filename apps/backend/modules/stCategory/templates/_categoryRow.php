<?php 
/**
 * Szablon pomocniczy prezentujący pojedynczy element kategorii
 */
?>
<span class="st_category_tree-<?php echo $categoryTree->getLevel() > 1 ? 'child' : 'parent' ?>">
    <?php if (!$categoryTree->isRoot()): ?>
        <span class="st_category_tree-nest-number">
            <?php echo stNestedIterator::getDepthNumber($categoryTree) ?>
        </span>
    <?php endif; ?>
    <span class="st_category_tree-name" id="category_<?php echo $categoryTree->getId() ?>">
        <?php echo $categoryTree->getName() ?>
    </span>
</span>
<?php st_include_partial('category_menu', array('categoryTree' => $categoryTree)) ?>    
<br style="clear: both" />
<?php echo input_in_place_editor_tag('category_'.$categoryTree->getId(),'category/categoryEdit?id='.$categoryTree->getId(), array(
    'cols' => 20, 
    'rows' => 1,
    'complete' => " { var options = \$A($('st_tree_list').options); options.each(function(option) { if (option.value == {$categoryTree->getId()}) option.text = $('category_{$categoryTree->getId()}').innerHTML; }); }", 
)) ?>