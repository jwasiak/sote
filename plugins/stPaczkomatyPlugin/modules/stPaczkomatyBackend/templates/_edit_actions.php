<?php 
echo st_get_admin_actions_head('style="float: left"');
echo st_get_admin_action('edit', __('Wróć do zamówienia'), 'stOrder/edit?id='.$paczkomaty_pack->getOrderId()); 
echo "</ul>";
include sfConfig::get('sf_module_cache_dir').'/auto'.ucfirst($sf_context->getModuleName()).'/templates/_edit_actions.php';
?>

<?php if (!$paczkomaty_pack->isEditable()): ?>
    <script>
        jQuery(function($) {
            $('.action-download_sticker').show();
            $('#sf_fieldset_none').show();
        });
    </script>
<?php else: ?>
    <script>
        jQuery(function($) {
            $('.action-save').show();
        });
    </script>
<?php endif ?>