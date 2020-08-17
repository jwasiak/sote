<?php
st_theme_use_stylesheet('appCategoryHorizontal.css');
use_helper('stCategoryImage');
use_helper('stAsset');

$smarty->assign('categories', $categories);

$smarty->assign('category_horizontal', $categoryHorizontal);

$selected = $sf_user->getParameter('selected', null, 'soteshop/stCategory');

$sf_user->setParameter('selected', null, 'soteshop/stCategory');

$smarty->assign('count', count($categories));

$smarty->display('category_tree.html');

$sf_user->setParameter('selected', $selected, 'soteshop/stCategory');

?>
<?php if (isset($initialize)): ?>
<script type="text/javascript">    
//<![CDATA[
jQuery(function($) {
    $('.horizontal-category-menu a').click(function() {
        var link = $(this);
        window.location = link.attr('href')+'?horizontal';
        return false;
    });

    var url = window.location.pathname;

    if (url != '/') {
        var current = $('.horizontal-category-menu a[href="'+url+'"]');

        if (current.length) {
            current.parent().addClass('selected');
            current.parentsUntil('#underbaner', '.subMenu').addClass('selected');
        }
    }
});
//]]>
</script> 
<?php endif ?>