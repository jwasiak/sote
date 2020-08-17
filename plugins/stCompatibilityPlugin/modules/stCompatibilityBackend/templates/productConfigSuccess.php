<?php use_helper('stAdminGenerator', 'appProductAttribute') ?>
<?php st_include_partial('stProduct/header', array(
    'related_object' => $product, 
    'title' => __('Moduł zgodności'), 
    'route' => '@stCompatibilityPlugin?action=productConfig&product_id='.$product->getId(),
    'culture' => $product->getCulture()
)) ?>
<?php st_include_component('stProduct', 'editMenu', array('related_object' => $product)); ?>
<?php st_include_partial('stProduct/edit_messages') ?>

<form class="admin_form" action="<?php echo st_url_for('@stCompatibilityPlugin?action=productConfig&product_id='.$product->getId().'&culture='.$product->getCulture()) ?>" method="post">

   <fieldset style="margin: 0 10px;">
      <div class="content">
        <div class="row">
           <label for="product_config_is_service"><?php echo __('Produkt jest usługą') ?>:</label>
           <div class="field">
              <?php echo checkbox_tag('product_config[is_service]', true, $product->getIsService()) ?>
           </div>
        </div>
      </div>
   </fieldset>
   <div id="edit_actions" style="margin-right: 10px;"><?php echo st_get_admin_actions(array(array('type' => 'save', 'label' => __('Zapisz', null, 'stAdminGeneratorPlugin')))) ?></div>
</form>
<?php st_include_partial('stProduct/footer') ?>