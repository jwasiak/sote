<?php if ($roots)
{
    st_theme_use_stylesheet('stCategory.css');
    use_helper('stCategoryTree');
    ob_start();
    foreach ($roots as $root)
    {
        if ($sf_user->hasAttribute('producer_id'))
        {
            st_category_tree_include($root, false, 'stCategory', 'Ext.tree.stTreeNodeFrontendUI', array(), false, false, false, url_for('product/list?id_category=' . $root->getId() . '&producer=' . $sf_user->getAttribute('producer_id')));
        }else
        {
            st_category_tree_include($root, false, 'stCategory', 'Ext.tree.stTreeNodeFrontendUI', array(), false, false, false, url_for('product/list?id_category=' . $root->getId()));
        }
    }
    $smarty->assign('category_tree',ob_get_clean());
    $smarty->display('category_tree.html');
    if (isset($root_id))
    {
        echo javascript_tag('Ext.onReady(function() { Ext.categoryTree[' . $root_id . '].expandPath(\'/' . $category_path . '\') });');
    }
}
?>