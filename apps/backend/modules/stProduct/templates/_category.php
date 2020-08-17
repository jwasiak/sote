<?php

/**
 * Szablon dla komponentu category
 *
 * @package stProduct
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @copyright SOTE
 * @license SOTE
 * @version $Id: _category.php 661 2009-04-16 07:01:00Z michal $
 */
if ($product->isNew())
{
    $params = array('product_hash' => $product->hashCode());
}
else
{
    $params = array('product_id' => $product->getId());
}

if ($sf_request->hasErrors())
{
    $params['assigned-categories'] = implode('-', $sf_request->getParameter('product_has_category', array()));

    $params['default-category'] = $sf_request->getParameter('product_default_category');
}
?>

<div id="st_product_has_categories">
<?php foreach ($categories as $category): ?>
<?php if ($category['default']): ?>
   <input type="hidden" value="<?php echo $category['id'] ?>" name="product_default_category" id="product_default_category" />
<?php endif; ?>
   <input type="hidden" value="<?php echo $category['id'] ?>" name="product_has_category[<?php echo $category['id'] ?>]" id="product_has_category_<?php echo $category['id'] ?>" />
<?php endforeach; ?>
</div>