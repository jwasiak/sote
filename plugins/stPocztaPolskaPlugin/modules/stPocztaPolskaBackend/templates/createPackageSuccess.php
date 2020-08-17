<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'VisualEffect', 'stAdminGenerator', 'stDate', 'stPocztaPolska', 'stPrice') ?>


<?php
sfLoader::loadHelpers('stOrder', 'stOrder');
?>

<?php st_include_partial('stOrder/header', array('title' => __('Przygotowanie paczki dla zamówienia %%number%%', 
array('%%number%%' => '<i>'.$order->getNumber().'</i>')), 'route' => 'stOrder/edit?id='.$order->getId())) ?>

<div id="sf_admin_content">
    <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels));?>
    
    <?php echo form_tag('@stPocztaPolskaBackend?action=createPackage&id='.$order->getId(), array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form'));?>
        <fieldset>
            <div class="content">
                <?php echo st_admin_get_form_field('service_name', __('Usługa'), $serviceName, 'st_poczta_polska_uslugi', array('include_custom' => null, 'delivery_point_only' => isset($po))) ?>
            </div>
        </fieldset>

        <div id="package-form-container">
            <?php echo st_get_component('stPocztaPolskaBackend', 'createPackageForm', array('package' => $package, 'order' => $order)) ?>
        </div>


        <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: left"');?>
        <?php echo st_get_admin_action('list', __('Wróć do zamówienia'), '@stOrder?action=edit&id='.$order->getId());?>
        </ul>
        <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"');?>
            <?php echo st_get_admin_action('save', __('Spakuj'), null, array('name' => 'save'));?>
        <?php echo st_get_admin_actions_foot();?>
    </form>
</div>
<script type="text/javascript">
    jQuery(function($) {
        $('#service_name').change(function() {
            $(document).trigger('preloader', 'show');
            $.get("<?php echo st_url_for('@stPocztaPolskaBackend?action=ajaxUpdateCreatePackageForm') ?>", { order_id: <?php echo $order->getId() ?>, service: $(this).val() }, function(content) {
                    $('#package-form-container').html(content);
                    $(document).trigger('preloader', 'close');
            });
        });
    });
</script>
<?php st_include_partial('stOrder/footer') ?>