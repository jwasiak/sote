<?php use_helper('stUrl'); ?>

<?php if($products_in_group!="-"): ?>
	
    <?php echo link_to('<img width="20" style="vertical-align: text-bottom;" src="/images/backend/main/icons/red/stProduct.png">','stGroupPriceBackend/showProducts?id='.$group_price_id.'', array('title' => __("Pokaz produkty tej grupy"),  'class' => 'list_tooltip')).$products_in_group; ?>

<?php else: ?>
	
	<?php echo __('Brak przypisanych produktów.');  ?>
	
<?php endif; ?> 