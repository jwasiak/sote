<?php
st_theme_use_stylesheet('stProductsComparePlugin.css');

$smarty->assign("compare_product", $compareProduct);
if($compareProduct)
{
    $smarty->assign("add_product_to_compare", content_tag('a', __("Dodaj produkt do porównania"), array('href' => '#', 'class' => 'compare_product_link add')));
}
else
{
    $smarty->assign("delete_product_from_compare", content_tag('a', __("Usuń produkt z porównania"), array('href' => '#', 'class' => 'compare_product_link remove')));
}

$smarty->assign("products_compare_array",$productsToCompareArray);

if($productsToCompareArray)
{
    $smarty->assign("product_compare", link_to( __('Porównaj produkty', array()).' ('.count($productsToCompareArray).')', 'productsCompare', array() ));
}
$smarty->display("product_compare_button.html");
?>
<script type="text/javascript">
jQuery(function($){
   $('.compare_product_link').click(function(event) {
      if ($(this).hasClass('add'))
      {
         $('#st_component-st_products_compare_plugin-product_compare').load('<?php echo url_for('productsCompare/addProductToCompare?id='.$productId) ?>');
      }
      else
      {
         $('#st_component-st_products_compare_plugin-product_compare').load('<?php echo url_for('productsCompare/removeProductFromCompare?id='.$productId) ?>');
      }

      event.preventDefault();
   });
});
</script>