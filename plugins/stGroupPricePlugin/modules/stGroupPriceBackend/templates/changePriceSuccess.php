<?php use_helper('stAdminGenerator', 'Validation'); ?>

<?php st_include_partial('stGroupPriceBackend/header', array('title' => __('Zmień cenę'))) ?>
<?php st_include_component('stGroupPriceBackend', 'listMenu') ?>
<div id="sf_admin_content">
	<?php st_include_partial('stGroupPriceBackend/list_messages') ?>
	<form action="saveChangePrice" enctype="multipart/form-data" method="post" class="admin_form" name="admin_edit_form" id="admin_edit_form">
		<input type="hidden" value="1" id="id" name="id">

		<fieldset id="sf_fieldset_none">
			<div id="sf_fieldset_none_slide" class="content">
				<div class="row row_name">

					<div class="row row_group_price_group_price_id">

						<label for="group_id"><?php echo __('Grupa cenowa') ?>:</label>
						<div class="field">

							<select id="group_id" name="group[id]">
								<?php foreach($groupPrice as $group): ?>
								<option <?php if($group_id==$group->getId()) : ?> selected="selected" <?php endif; ?> value="<?php echo $group -> getId(); ?>"><?php echo $group -> getName(); ?></option>
								<?php endforeach; ?>
								
							</select>
							
							<div class="clr"></div>
						</div>
					</div>
				</div>
				
				<div class="row row_name">

					<div class="row row_group_type">

						<label for="group_type"><?php echo __('Zmień') ?>: </label>
						<div class="field">

							<select id="group_type" name="group[type]">
								<option <?php if($group_type=="netto") : ?> selected="selected" <?php endif; ?> value="netto"><?php echo __('Cenę netto') ?></option>
								<option <?php if($group_type=="brutto") : ?> selected="selected" <?php endif; ?> value="brutto"><?php echo __('Cenę brutto') ?></option>
								<option <?php if($group_type=="old_netto") : ?> selected="selected" <?php endif; ?> value="old_netto"><?php echo __('Starą cenę netto') ?></option>
								<option <?php if($group_type=="old_brutto") : ?> selected="selected" <?php endif; ?> value="old_brutto"><?php echo __('Starą cenę brutto') ?></option>
								<option <?php if($group_type=="wholesale_a_netto") : ?> selected="selected" <?php endif; ?> value="wholesale_a_netto"><?php echo __('Cenę hurtową A netto') ?></option>
								<option <?php if($group_type=="wholesale_a_brutto") : ?> selected="selected" <?php endif; ?> value="wholesale_a_brutto"><?php echo __('Cenę hurtową A brutto') ?></option>
								<option <?php if($group_type=="wholesale_b_netto") : ?> selected="selected" <?php endif; ?> value="wholesale_b_netto"><?php echo __('Cenę hurtową B netto') ?></option>
								<option <?php if($group_type=="wholesale_b_brutto") : ?> selected="selected" <?php endif; ?> value="wholesale_b_brutto"><?php echo __('Cenę hurtową B brutto') ?></option>
								<option <?php if($group_type=="wholesale_c_netto") : ?> selected="selected" <?php endif; ?> value="wholesale_c_netto"><?php echo __('Cenę hurtową C netto') ?></option>
								<option <?php if($group_type=="wholesale_c_brutto") : ?> selected="selected" <?php endif; ?> value="wholesale_c_brutto"><?php echo __('Cenę hurtową C brutto') ?></option>			
							</select>

							<div class="clr"></div>
						</div>
					</div>
				</div>

				<div class="row row_name">

					<div class="row row_group_new_price">

						<label class="required" for="group_new_price"><?php echo __('Nowa cena') ?>: <a class="help" href="#" title="Podaj wartość np:<br> 10.00 - ustawi jako nowa cene 10.00<br> +10.00 - doda do aktualnej ceny 10.00<br>-10.00 - odejmie od aktualnej ceny 10.00 <br>+10% - doda do aktualnej ceny 10%<br>-10% - odejemie od aktualnej ceny 10%"></a> : </label>
						<div class="field<?php if ($sf_request->hasError('group{new_price}')): ?> form-error<?php endif; ?>">
							<?php if ($sf_request->hasError('group{new_price}')): ?>
							<?php echo form_error('group{new_price}', array('class' => 'form-error-msg')) ?>
							<?php endif; ?>

							<?php echo input_tag('group[new_price]', '', array('control_name' => 'group[new_price]', 'value' => $new_price, 'class' => form_has_error('group{new_price}') ? 'st_form-error' : '')); ?>

							<div class="clr"></div>
						</div>
					</div>
				</div>
			</div>
		</fieldset>

		<div style="display: none; min-width: 1010px;" class="floating_container"></div>
		<div id="edit_actions">
			<div class="floating_content">

				<ul class="admin_actions" style="float: right">
					
					<li class="action-save">
						<input type="submit" onclick="return confirm('<?php echo __('Jesteś pewień, że chcesz zmienić cenę dla tej grupy, tego procesu nie da się odwrócić ?') ?>');" style="background-image: url(/images/backend/icons/save.png)" value="<?php echo __('Aktualizuj') ?>" name="save">
					</li>
				</ul><div class="clr"></div>
			</div>
		</div>

	</form>

</div>
<?php st_include_partial('smGroupPriceBackend/footer')
?>