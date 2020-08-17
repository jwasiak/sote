<?php 
if ($paczkomaty_pack->isEditable())
{
    echo st_inpost_sending_method_select_tag('paczkomaty_pack[sending_method]', $paczkomaty_pack->getSendingMethod(), array (
        'service' => 'inpost_locker_standard',
        'target' => '.row_dropoff_point',
    )); 
}
else
{
    $api = stInPostApi::getInstance();
    $methods = $api->getSendingMethods('inpost_locker_standard');
    echo $methods[$paczkomaty_pack->getSendingMethod()];
}
?> 

<?php if (!$paczkomaty_pack->isEditable() && $paczkomaty_pack->getSendingMethod() != 'parcel_locker'): ?>
    <script>
        jQuery(function($) {
            $('.row_dropoff_point').hide();
        }); 
    </script>
<?php endif ?>