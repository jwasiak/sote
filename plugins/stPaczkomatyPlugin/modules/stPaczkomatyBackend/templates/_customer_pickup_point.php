<?php echo st_inpost_point_select_tag('paczkomaty_pack[customer_pickup_point]', $paczkomaty_pack->getCustomerPickupPoint(), array (
  'title' => 'Paczkomat odbiorcy',
  'disabled' => !$paczkomaty_pack->isEditable()
)); ?> 