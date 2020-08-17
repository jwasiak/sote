<?php use_helper('stAdminGenerator', 'appProductAttribute') ?>
<?php st_include_partial('stProduct/header', array(
	'related_object' => $product, 
	'title' => __('Atrybuty'), 
	'route' => '@appProductAttributesPlugin?action=productAttribute&product_id='.$product->getId(),
	'culture' => $product->getCulture()
)) ?>
<?php st_include_component('stProduct', 'editMenu', array('related_object' => $product)); ?>
<?php st_include_partial('appProductAttributeBackend/edit_messages') ?>
<?php use_stylesheet('backend/appProductAttributeBackend.css') ?>
<?php if ($attributes): ?>
<form class="admin_form" action="<?php echo st_url_for('@appProductAttributesPlugin?action=productAttribute&product_id='.$product->getId().'&culture='.$product->getCulture()) ?>" method="post">
   <fieldset>
      <?php echo st_admin_get_form_field('app_product_attribute[label]', __('Tytuł'), appProductAttributeHelper::getAttributeLabel($product), 'input_tag', array(
      	'help' => __('Tytuł wyświetlany jest nad listą atrybutów na stronie karty produktu')
      )) ?>
 	</fieldset>
   <fieldset>
   	<h2><?php echo __('Atrybuty') ?></h2>	  
<?php foreach ($attributes as $attribute): ?>
      <div class="row">
         <label for="token-input-app_product_attribute_variant_<?php echo $attribute->getId() ?>"><?php echo $attribute->getName() ?>:</label>
         <div class="field">
         	<?php echo app_product_attribute_variant_tokenizer($attribute, $product) ?>
         </div>
         <div class="clr"></div>
      </div>
<?php endforeach ?>
   </fieldset>
   <div id="edit_actions"><?php echo st_get_admin_actions(array(array('type' => 'save', 'label' => __('Zapisz', null, 'stAdminGeneratorPlugin')))) ?></div>
</form>
<?php st_include_partial('stProduct/footer') ?>
<script type="text/javascript">
jQuery(function($) {
    $(document).ready(function() {
        $('#edit_actions').stickyBox();
    });

});
</script>
<?php else: ?>
  <div style="margin: 10px; min-height: 50px; border: 1px solid #ccc; padding: 10px;">
    <p style="text-align: center; font-family: Helvetica,Arial,sans-serif; font-size: 12px; padding-top: 15px;"><?php echo __('Produkt nie zawiera atrybutów dla przypisanych kategorii') ?></p>
  </div>
<?php endif ?>