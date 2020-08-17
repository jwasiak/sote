
<?php echo st_get_admin_actions_head('style="float: left"') ?>
<?php if (method_exists($product, 'getIsSystemDefault') == false || (method_exists($product, 'getIsSystemDefault') && !$product->getIsSystemDefault())): ?>
		<?php if ($product->getId()): ?>
<?php echo st_get_admin_action('delete', __('Usuń', null, 'stAdminGeneratorPlugin'), 'stProduct/delete?id='.$product->getId(), array("confirm" => __('Potwierdź usuniecie produktu?', null, 'stProduct'),"name" => "delete",)) ?><?php endif; ?>
<?php endif; ?>
</ul>

<?php echo st_get_admin_actions_head('style="float: right"') ?>
<?php if (!$product->isNew()): ?>
<li class="action-view_shop">
<input type="button" onclick="window.open('/backend.php/product/viewProduct/id/<?php echo $product->getId();?>')" value="<?php echo __("Zobacz produkt w sklepie");?>" style="background-image: url(/images/backend/beta/icons/16x16/view_shop.png)" name="view_product">
</li>
<?php endif;?>

<?php echo st_get_admin_action('list', __('Pokaż listę', null, 'stAdminGeneratorPlugin'), 'stProduct/list', array("name" => "list",)) ?>
<?php 
if (!$product->isNew()){
 echo st_get_admin_action('duplicate', __('Duplikuj', null, 'stProduct'), 'stProduct/duplicate?id='.$product->getId(), array("name" => "duplicate",));
}
?>
<?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array("name" => "save",)) ?>      
<?php echo st_get_admin_action('save_and_add', __('Zapisz i dodaj kolejny', null, 'stAdminGeneratorPlugin'), null, array("name" => "save_and_add",)) ?>  
<?php echo st_get_admin_actions_foot() ?>