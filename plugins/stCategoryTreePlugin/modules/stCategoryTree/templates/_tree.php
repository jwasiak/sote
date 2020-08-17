<?php
use_javascript('/stCategoryTreePlugin/js/jquery.treeview.js');
st_theme_use_stylesheet('stCategory.css');
echo javascript_tag('
        jQuery(function($) {
            $("#st_category-tree-'.$parent['id'].'").treeview({
                collapsed: true,
                animated: "fast",
                prerendered: true
            });
        })
');
?>
<div class="st_category-tree x-panel x-panel-noborder x-tree"><div class="x-panel-bwrap"><div class="x-panel-body x-panel-body-noheader x-panel-body-noborder">
<ul id="st_category-tree-<?php echo $parent['id'] ?>" class="x-tree-root-ct x-tree-arrows">
<?php foreach ($categories as $category): if ($category['is_hidden']) continue ?>
<?php if ($category['has_children']): ?>
    <li class="st_category-tree-element<?php echo $category['is_last'] ? ' st_category-tree-element-last' . ($category['is_expanded'] ? ' st_category-tree-element-minus-last' : ' st_category-tree-element-plus-last') : ($category['is_expanded'] ? ' st_category-tree-element-minus' : ' st_category-tree-element-plus') ?>">
        <div class="x-tree-node-el x-tree-node-<?php echo $category['is_expanded'] ? 'expanded' : 'collapsed' ?><?php echo $category['is_last'] && !$category['is_first'] ? ' x-tree-node-last' : '' ?> <?php echo $category['is_selected'] ? 'x-selected' : '' ?>">
            <img class="x-tree-hitarea x-tree-ec-icon<?php echo $category['is_expanded'] ? ($category['is_last'] ? ' x-tree-elbow-minus-last' : '') . ' x-tree-elbow-minus' : ($category['is_last'] ? ' x-tree-elbow-plus-last' : '') . ' x-tree-elbow-plus' ?>" src="/plugins/sfExtjs2Plugin/extjs/resources/images/default/s.gif" alt="" />
            <a class="<?php echo $category['is_selected'] ? 'x-tree-node-anchor x-tree-node-anchor-selected' : 'x-tree-node-anchor' ?>" href="<?php echo $category['url'] ?>"><span><?php echo $category['name'] ?> <?php if ($show_product_count) { echo '('.$category['product_count'].')'; } ?></span></a>
        </div>
    <ul style="display: <?php echo $category['is_expanded'] ? 'block' : 'none' ?>" class="x-tree-node-ct">
<?php else: ?>
    <li class="st_category-tree-element<?php echo $category['is_last'] ? ' st_category-tree-element-last st_category-tree-element-leaf-last' : ($category['is_first'] ? ' st_category-tree-element-first' : '')  ?>">
        <div class="x-tree-node-el x-tree-node-collapsed <?php echo $category['is_selected'] ? 'x-selected' : '' ?>">
            <img class="x-tree-ec-icon x-tree-elbow-plus x-tree-elbow-leaf<?php $category['is_last'] ? ' x-tree-elbow-leaf-last' : '' ?>" src="/plugins/sfExtjs2Plugin/extjs/resources/images/default/s.gif" alt="" />
            <a class="<?php echo $category['is_selected'] ? 'x-tree-node-anchor x-tree-node-anchor-selected' : 'x-tree-node-anchor' ?>" href="<?php echo $category['url'] ?>"><span><?php echo $category['name'] ?> <?php if ($show_product_count) { echo '('.$category['product_count'].')'; } ?></span></a>
        </div>
    </li>
<?php for ($i = 0; $i < $category['close_tag_count']; $i++): ?>
    </ul></li>
<?php endfor; ?>
<?php endif; ?>
<?php endforeach; ?>
</ul>
</div></div></div>