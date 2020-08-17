<?php
// auto-generated by sfPropelAdmin
// date: 2012/05/24 13:41:13
?>

<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'VisualEffect', 'stAdminGenerator', 'stDate') ?>

<?php
?>

<?php st_include_partial('stProduct/header', array('related_object' => $related_object, 'title' => $online_files->isNew() ? __('Dodaj nowy', 
array(), 'stAdminGeneratorPlugin') : __('', 
array(), 'stAdminGeneratorPlugin'), 'route' => 'stProduct/onlineAudioEdit?id='.$online_files->getId().'&product_id='.$forward_parameters['product_id'])) ?>

<?php
if (!$online_files->isNew() || isset($related_object) && !$related_object->isNew())
{ 
   st_include_component('stProduct', 'editMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object));
}
?>
  

<div id="sf_admin_content">
   <?php st_include_component('stProduct/online_audio_edit_messages', array('online_files' => $online_files, 'labels' => $labels, 'forward_parameters' => $forward_parameters)) ?>
   <?php st_include_partial('stProduct/online_audio_edit_form', array('online_files' => $online_files, 'labels' => $labels, 'forward_parameters' => $forward_parameters)) ?>
   <?php echo st_get_component('appOnlineCodesBackend','showFileList',array('related_object'=>$related_object, 'media_type'=>'ST_AUDIO')); ?></br>

</div>

<?php st_include_partial('stProduct/footer', array('related_object' => $related_object, 'forward_parameters' => $forward_parameters)) ?>
