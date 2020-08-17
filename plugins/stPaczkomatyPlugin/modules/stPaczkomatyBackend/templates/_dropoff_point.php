<?php echo st_inpost_point_select_tag('paczkomaty_pack[dropoff_point]', $paczkomaty_pack->getDropoffPoint(), array (
  'title' => 'Paczkomat nadawcy', 
  'disabled' => !$paczkomaty_pack->isEditable()
)); ?> 