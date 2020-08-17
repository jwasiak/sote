
<?php use_helper('stAdminGenerator') ?>

<?php st_include_partial('stAllegroBackend/header', array(
	'title' => __('Cenniki'),
)) ?>

<?php st_include_component('stAllegroBackend', 'configMenu'); ?>
<div id="sf_admin_content">

	<?php if ($shippingRates): ?>
		<form action="<?php echo url_for('@stAllegroDelivery?action=list') ?>" id="record_list_form">
			<table cellspacing="0" cellpadding="0" class="st_record_list record_list" style="width: 100%">
				<thead>         
					<tr> 
						<th width="1%">&nbsp;</th>
					
						<th><?php echo __('Nazwa') ?></th>

						<th width="1%">&nbsp;</th>
					</tr>    
				</thead>
				<tbody>
					<?php foreach ($shippingRates as $index => $shippingRate): ?>
					
						<tr class="<?php echo $index % 2 ? 'highlight' : '' ?>">
							<td>
								<ul class="st_object_actions">
									<li><a href="<?php echo url_for('@stAllegroDelivery?action=edit&id=' . $shippingRate->id) ?>" data-admin-confirm="" data-admin-action="edit"><img src="/images/backend/beta/icons/16x16/edit.png" title="edit" class="tooltip"></a></li>                          
								</ul>
							</td>
										
							<td class="column_list_image"><?php echo $shippingRate->name ?></td>
							<td>
								<ul class="st_object_actions">     
									<!-- <li><a href="<?php //echo url_for('@stAllegroDelivery?delete=edit&id=' . $shippingRate->id) ?>" data-admin-confirm="Jesteś pewien?" data-admin-action="delete"><img src="/images/backend/beta/icons/16x16/remove.png" title="delete" class="tooltip"></a></li>   -->
								</ul>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</form>
	<?php else: ?>
		<div style="width: 98.2%; min-height: 50px; border: 1px solid #ccc; padding: 10px;">
			<p id="st_record_list-empty"><?php echo __("Brak cenników") ?></p>
		</div>
	<?php endif ?>
	<div id="list_actions">
		<?php echo st_get_admin_actions(array(
			array('type' => 'add', 'label' => __('Dodaj'), 'action' => '@stAllegroDelivery?action=edit'),
		)); ?>
    </div>
</div>

<?php st_include_partial('stAllegroBackend/footer') ?>

<script>
jQuery(function($) {
	$('#list_actions').stickyBox();
});
</script>