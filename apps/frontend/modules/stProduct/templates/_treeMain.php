<?php
use_helper('stAsset', 'stCategoryImage', 'stText', 'stUrl');

st_theme_use_stylesheet('stCategory.css');

if ($categories && $show_category_main_menu)
{
    $smarty->assign('producer_id', $producer_id);

    $smarty->assign("height", st_asset_thumbnail_setting('height', 'thumb', 'category'));

    $row=array();

    $arrow_blue_image = st_theme_image_tag('arrow_blue.png', array('alt' => ''));

    foreach ($categories as $index => $category)
    {
        $children = ProductHasCategoryPeer::doSelectMainPageCategories($category);

        $row[$index]['class_name'] = "st_product-tree_main_category";

        $row[$index]['object'] = $category;
        $row[$index]['id'] = $category->getId();
        $row[$index]['link'] = st_url_for('stProduct/list?url=' . $category->getFriendlyUrl());
        $row[$index]['description'] = strip_tags($category->getDescription());

        if ($category->getSfAssetId())
        {
             $row[$index]['show_image'] = "1";
        }

        $row[$index]['photo'] = st_category_image_link_to($category, 'thumb');

        if ($config->get('cut_tree_cat_name') && st_check_strlen($category->getName()) > $config->get('cut_tree_cat_name_num'))
        {
            $row[$index]['name'] = '<span title="'.$category->getName().'"  class="hint">'.st_link_to(st_truncate_text($category->getName(), $config->get('cut_tree_cat_name_num'), '...'),'stProduct/list?url=' . $category->getFriendlyUrl() )."</span>";
            
        }
        else
        {
            $row[$index]['name'] = st_link_to($category->getName(),'stProduct/list?url=' . $category->getFriendlyUrl()) ;
        }

        if ($children)
        {
            foreach ($children as $child_index => $child)
            {
                 if ($config->get('cut_tree_subcat_name') && st_check_strlen($child->getName()) > $config->get('cut_tree_subcat_name_num'))
                {
                    $row[$index]['subcategories'][$child_index]['name'] = '<span title="'.$child->getName().'"  class="hint">'.st_link_to(st_truncate_text($child->getName(), $config->get('cut_tree_subcat_name_num'), '...'), 'stProduct/list?url=' . $child->getFriendlyUrl())."</span>";
                }
                else
                {
                    $row[$index]['subcategories'][$child_index]['name'] = st_link_to($child->getName(),'stProduct/list?url=' . $child->getFriendlyUrl());
                }
            }
        }

    }

    $smarty->assign('results', $row);

    $smarty->display("product_tree_main.html");
}
?>