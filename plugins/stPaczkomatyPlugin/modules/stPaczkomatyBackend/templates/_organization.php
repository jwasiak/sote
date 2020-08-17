<?php echo st_inpost_organization_select_tag('config[organization]', $config->get('organization')); ?>

<?php if (stInPostApi::getInstance()->isValid()): ?>
    <script>
        jQuery(function($) {
            $('#sf_fieldset_domy__lne_ustawienia,.row_organization,.row_order_status,.row_payment,#sf_fieldset_informacje_o_nadawcy_na_paczce').show();
        });
    </script>
<?php else: ?>
    <script>
        jQuery(function($) {
            $('#sf_fieldset_domy__lne_ustawienia,.row_organization,.row_order_status,.row_payment,#sf_fieldset_informacje_o_nadawcy_na_paczce').prop('disabled', true);
        });
    </script>
<?php endif ?>