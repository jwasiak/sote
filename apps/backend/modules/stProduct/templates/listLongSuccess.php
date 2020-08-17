<?php use_helper('I18N', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin', 'stDate') ?>

<?php
use_stylesheet('backend/stProductList.css');
?>

<?php
sfLoader::loadHelpers('stProduct', 'stProduct');
?>

<?php st_include_partial('stProduct/header', array('related_object' => $related_object, 'title' => __('Lista', 
array()), 'route' => 'stProduct/list')) ?>

<?php st_include_component('stProduct', 'listMenu', array('forward_parameters' => $forward_parameters)) ?>

<div id="sf_admin_content">
    <?php st_include_partial('stProduct/list_messages', array('pager' => $pager, 'forward_parameters' => $forward_parameters)) ?>
    <?php $list_actions = st_get_partial('list_long_actions', array('pager' => $pager, 'forward_parameters' => $forward_parameters)) ?> 

    <div>     
    <?php if ($pager->getNbResults() > 10 || $filters): ?>
    <?php st_include_partial('stProduct/list_filters', array('filters' => $filters, 'forward_parameters' => $forward_parameters)) ?>   
    <?php endif; ?>
    <?php echo form_tag('stProduct/list', array('id' => 'record_list_form', 'class' => 'admin_form')) ?>
        <?php echo input_hidden_tag('page', $pager->getPage()) ?>   
     
    <?php if ($pager->getNbResults() || $filters): ?>
    <?php st_include_partial('stProduct/list_pager', array('pager' => $pager, 'forward_parameters' => $forward_parameters, 'url' => st_url_for('stProduct/list'), 'prefix' => 'head')) ?>    
    <?php st_include_partial('stProduct/list_long', array('pager' => $pager, 'forward_parameters' => $forward_parameters, 'product_action_select_options' => $product_action_select_options)) ?>
    <?php else: ?>
    <?php st_include_partial('stProduct/list_empty_message', array('pager' => $pager, 'forward_parameters' => $forward_parameters)) ?>
    <?php endif; ?>    
    <div id="list_actions">    
        <?php echo $list_actions ?>
    </div>
    </form>

    </div>
    <div class="clr"></div>
</div>

<?php st_include_partial('stProduct/footer', array('related_object' => $related_object)) ?>
<script type="text/javascript">
jQuery(function($) {
      $('#list_actions').stickyBox();
});
</script>