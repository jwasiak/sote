<?php use_helper('stAdminGenerator') ?>
<?php echo form_tag('stProductOptionsBackend/useTemplate?product_id='.$product->getId())?>

<?php $value = (!is_object($root->getProductOptionsTemplate())) ?
        select_tag('product_options_template', options_for_select($options,$root->getProductOptionsTemplateId()),
                                                    array('onchange' => "document.getElementById('submit_use_template_form').click()")) 

        : __('Szablon').' '.$root->getProductOptionsTemplate()->getName().' '.__('jest aktualnie wykorzystywany'); ?>
<?php echo $value ?>

<?php echo submit_tag(__('Zapisz', null, 'stAdminGeneratorPlugin'), array('id' => 'submit_use_template_form')) ?>
</form>

<?php echo st_get_admin_actions_head() ?>  
    <?php if(count($options)<=1): ?>
        <?php echo st_get_admin_action('add', __('Dodaj nowy szablon'), 'stProduct/optionsTemplatesCreate?remeber=1') ?>
    <?php endif; ?>
     <?php echo st_get_admin_action('list', __('Lista szabonów'), 'stProduct/optionsTemplatesList?remeber=1') ?>
<?php echo st_get_admin_actions_foot() ?>