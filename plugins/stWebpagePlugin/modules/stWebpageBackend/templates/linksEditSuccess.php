<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'VisualEffect', 'stAdminGenerator', 'stDate') ?>


<div class="admin_container" id="sf_admin_container">

<div class="header">
   <h2 class="float_left">
      <a href="/backend.php/webpage/linksList"><img alt="Linki" src="/images/backend/main/icons/red/stWebpageLinksPlugin.png"><?php echo __('Strony www');?></a>
       - <?php echo __('Edycja linku');?> </h2>
      <div class="float_right">

            <?php if (!$webpage->isNew()): ?>
            <span style="float: left; margin-right: 5px; margin-top: 3px;"><?php echo __('Język edycji', null, 'stBackendMain') ?></span> <?php echo st_get_admin_culture_picker(array('url' => 'stWebpageBackend/linksEdit?id='.$webpage->getId(), 'culture' => $webpage->getCulture())); ?>
            <?php endif; ?>
         <div style="clear: left"></div></div>
      <div class="clr"></div>
</div>

<?php
if (!$webpage->isNew() || isset($related_object) && !$related_object->isNew())
{ 
   st_include_component('stWebpageBackend', 'linksEditMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object));
}
?>
  

<div id="sf_admin_content">
   <?php st_include_partial('stWebpageBackend/edit_messages', array('webpage' => $webpage, 'labels' => $labels, 'forward_parameters' => $forward_parameters)) ?>
   <?php st_include_partial('stWebpageBackend/links_edit_form', array('webpage' => $webpage, 'labels' => $labels, 'forward_parameters' => $forward_parameters, 'related_object' => $related_object)) ?>
</div>

<?php st_include_partial('stWebpageBackend/footer', array('related_object' => $related_object, 'forward_parameters' => $forward_parameters)) ?>