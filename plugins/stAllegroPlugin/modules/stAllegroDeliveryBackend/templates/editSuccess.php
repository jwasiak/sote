<?php use_helper('stAdminGenerator', 'Object', 'stAllegroDelivery');?>
<?php st_include_partial('stAllegroDeliveryBackend/header', array('title' =>  __('Edycja cennika dostawy', null, 'stAllegroDeliveryBackend')));?>
<?php st_include_component('stAllegroBackend', 'configMenu'); ?>   

<div id="sf_admin_content">
    <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels)) ?>
    <form action="<?php echo $sf_request->hasParameter('id') ? url_for('@stAllegroDelivery?action=edit&id='.$sf_request->getParameter('id')) : url_for('@stAllegroDelivery?action=edit') ?>" id="record_list_form" class="admin_form" method="post">
        <fieldset>
            <div class="content">
                <?php echo st_admin_get_form_field('delivery[name]', __("Nazwa"), $delivery['name'], 'input_tag', array('maxlength' => 64, 'size' => 60)) ?>
                <div class="row">
                    <label><?php echo __('Cennik') ?></label>
                    <div class="field">
                        <?php echo st_get_component('stAllegroDeliveryBackend', 'deliveries', array('delivery' => $delivery)) ?>
                    </div>
                </div>
            </div>
        </fieldset>
        <div id="edit_actions">
            <div style="float: left">
                <?php echo st_get_admin_actions(array(
                    array('type' => 'list', 'label' => __('Lista'), 'action' => '@stAllegroDelivery?action=list'),
                )); ?>			
            </div>
            <div style="float: right">
                <?php echo st_get_admin_actions(array(
                    array('type' => 'save', 'label' => __('Zapisz'))
                )) ?>
            </div>
            <div class="clr"></div>
        </div>
    </form>
</div>

<script type="text/javascript">
jQuery(function($) {
    $(document).ready(function() {
        $('#edit_actions').stickyBox();
    });
});
</script>

<?php st_include_partial('stAllegroDeliveryBackend/footer');?>
