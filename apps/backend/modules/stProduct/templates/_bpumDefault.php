<?php if (!$sf_user->getParameter('hide', false,'stProduct/edit/fields/bpum_default_value')): ?>
  <div style="margin-left: 0px;" class="field<?php if ($sf_request->hasError('product{bpum_default_value}')): ?> form-error<?php endif; ?>">
<?php if ($sf_request->hasError('product{bpum_default_value}')): ?>
    <?php echo form_error('product{bpum_default_value}', array('class' => 'form-error-msg')) ?>
<?php endif; ?>

 <?php echo object_input_tag($product, 'getBpumDefaultValue', array (
  'size' => 7,
  'control_name' => 'product[bpum_default_value]',
)); ?> 


<select include_blank="" id="product_bpum_default_id" name="product[bpum_default_id]">
<option class="none" value="">---</option>    
<?php foreach($bpum as $unit): ?>
<option <?php if($product->getBpumDefaultId() == $unit->getId()){ echo "selected='selected'";}  ?> class="<?php echo $unit->getUnitGroup(); ?>" value="<?php echo $unit->getId(); ?>"><?php echo $unit->getUnitSymbol()." (".$unit->getUnitName().")" ; ?></option>    
<?php endforeach; ?>
</select>



  <div class="clr"></div>
  </div>

<?php endif; ?>
<?php echo st_price_add_format_behavior(get_id_from_name("product_bpum_default_value")); ?>