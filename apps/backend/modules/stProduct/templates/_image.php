<?php
/**
 * Szablon dla partial'a _product_image
 *
 * @package   stProduct
 * @author    Marcin Olejniczak <marcin.olejniczak@sote.pl>
 * @copyright SOTE
 * @license   SOTE
 * @version   $Id: _image.php 617 2009-04-09 13:02:31Z michal $
 */ 
?>
  <?php if ($sf_request->hasError('product{image}')): ?>
    <?php echo form_error('product{image}', array('class' => 'form-error-msg')) ?>
  <?php endif; ?>
  <?php $value = object_admin_input_file_tag($product, 'getImage', array (
  'control_name' => 'product[image]',
)); echo $value ? $value : '&nbsp;' ?>
    <br class="st_clear_all" />
<?php st_include_component('stProduct', 'mainImage');?><br>
