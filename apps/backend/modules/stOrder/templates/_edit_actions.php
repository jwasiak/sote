<?php echo st_get_admin_actions_head('style="margin-top: 10px; float: left"') ?>
<?php
if($sf_user->getAttribute('edit_mode', false, 'soteshop/stOrder'))
{
   echo st_get_admin_action('edit', __('Realizacja'), 'stOrder/mode?id='.$order->getId().'&type=show');
}
else
{
   echo st_get_admin_action('edit', __('Edycja'), 'stOrder/mode?id='.$order->getId().'&type=edit');
}
?>
<?php echo st_get_admin_action('delete', __('Usuń'), 'stOrder/delete?id='.$order->getId(), array("confirm" => __("Jesteś pewien?"))); ?>
</ul>

<?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
<?php echo st_get_admin_action('list', __('Lista'), $order->getOptAllegroNick() || $order->getOptAllegroCheckoutFormId() ? '@stOrder?action=allegroList' : '@stOrder?action=list') ?>
<?php echo st_get_admin_action('printPdf', __('Pobierz'), 'stOrder/printPdf?id='.$order->getId()) ?>
<?php echo st_get_admin_action('save', __('Zapisz'), null, array('name' => 'save')) ?>
<?php echo st_get_admin_actions_foot() ?>
