<?php
// auto-generated by sfPropelAdmin
// date: 2008/10/31 11:03:38
?>
<td>
<div id="st_object_actions_td_frame">
<ul class="st_object_actions">     
      <li><?php echo link_to(image_tag('backend/icons/edit.gif', array('alt' => __('edit'), 'title' => __('edit'))), 'stUser/userDataDeliveryEdit?id='.$user_data->getId()) ?></li>
      <?php if($user_data->getIsDefault()!=1): ?>
      <li><?php echo link_to(image_tag('backend/icons/delete.gif', array('alt' => __('delete'), 'title' => __('delete'))), 'stUser/userDataDeliveryDelete?id='.$user_data->getId(), array (
  'post' => true,
  'confirm' => __('Jesteś pewien?'),
)) ?></li>
<?php endif; ?>
</ul>
</div>
</td>
