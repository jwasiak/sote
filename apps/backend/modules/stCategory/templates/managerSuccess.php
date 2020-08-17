<?php 
use_helper('stAdminGenerator', 'stCategoryTree');
use_stylesheet('backend/stCategory.css');
?>

<?php st_include_partial('stCategory/header', array('title' => __('Menedżer kategorii'))) ?>
<?php st_include_component('stCategory', 'listMenu') ?> 
<form id="category_tree_form" action="<?php echo st_url_for('stCategory/addTree')  ?>" method="post">
   <?php if ($sf_request->hasError('category_tree_name')): ?>
   <?php echo form_error('category_tree_name', array('class' => 'form-error-msg')) ?>
   <?php endif; ?>            
   <label for="category_tree_name"><?php echo __('Nazwa drzewa') ?></label>
   <input type="text" value="<?php echo $sf_request->getParameter('category_tree_name') ?>" name="category_tree_name" id="category_tree_name" />
   <?php echo st_get_admin_actions(array(
      array('label' => __('Dodaj'), 'type' => 'create')
   )) ?>
</form>     
<div class="clr"></div>
<?php foreach ($roots as $root): ?>
<?php st_category_tree_include($root, true); ?>
<?php endforeach; ?>
<div class="clr"></div>
<?php st_include_partial('stCategory/footer') ?>