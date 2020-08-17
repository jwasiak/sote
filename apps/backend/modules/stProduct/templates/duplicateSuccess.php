<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'VisualEffect', 'stAdminGenerator', 'stDate') ?>
<?php
use_stylesheet('backend/stProductEdit.css');
?>

<?php
sfLoader::loadHelpers('stProduct', 'stProduct');
sfLoader::loadHelpers('stDeliveryBackend', 'stDeliveryBackend');
?>

<?php st_include_partial('stProduct/header', array('related_object' => $product, 'title' =>  __('Duplikowanie produktu', 
array(), 'stProduct'), 'route' => 'stProduct/edit?id='.$product->getId())) ?>

<?php echo form_tag('stProduct/duplicate?id='.$product->getId(), array(
  'id'        => 'admin_edit_form',
  'name'      => 'admin_edit_form',
  'class'     => 'admin_form',
  'multipart' => true,
)) ?>

<fieldset id="sf_fieldset_none" style="margin: 0 10px; padding: 10px;">

<?php echo object_input_hidden_tag($product, 'getId') ?>
<input type="hidden" value="1" id="save" name="save">

<div class="row row_code">

<label for="product_code" class="required" >
  <?php echo __("Kod nowego produktu", array(), 'stProduct'); ?></label>
  <div class="field<?php if ($sf_request->hasError('product{code}')): ?> form-error<?php endif; ?>">
<?php if ($sf_request->hasError('product{code}')): ?>
    <?php echo form_error('product{code}', array('class' => 'form-error-msg')) ?>
<?php endif; ?>

<input type="text" size="32" value="<?php echo $new_code;?>" id="product_code" name="product[code]">




  <div class="clr"></div>
  </div>
</div>

<div class="row row_name">

<label for="product_name" class="required" >
  <?php echo __("Nazwa nowego produktu", array(), 'stProduct'); ?></label>
  <div class="field<?php if ($sf_request->hasError('product{name}')): ?> form-error<?php endif; ?>">
<?php if ($sf_request->hasError('product{name}')): ?>
    <?php echo form_error('product{name}', array('class' => 'form-error-msg')) ?>
<?php endif; ?>

 <?php echo object_input_tag($product, 'getName', array (
  'disabled' => false,
  'control_name' => 'product[name]',
  'size' => 40,
)); ?> 


  <div class="clr"></div>
  </div>
</div>

</fieldset>

<ul class="admin_actions" style="float: right; margin-right: 10px;">
<li class="action-duplicate"><input type="submit" style="background-image: url(/images/backend/icons/duplicate.png)" value="<?php echo __("Duplikuj", array(), 'stProduct'); ?>" name="duplicate"></li>
</ul>


</form>