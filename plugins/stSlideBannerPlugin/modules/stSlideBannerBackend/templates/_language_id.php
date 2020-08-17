<?php if($slide_banner->getImage()==""): ?>

<?php $value = object_select_tag($slide_banner, 'getLanguageId', array (
  'related_class' => 'Language',
  'control_name' => 'slide_banner[language_id]',
)); echo $value ? $value : '&nbsp;' ?>

<?php else: ?>

<?php $value = object_select_tag($slide_banner, 'getLanguageId', array (
  'related_class' => 'Language',
  'control_name' => 'slide_banner[language_id]',
  'disabled'=>'disabled',
)); echo $value ? $value : '&nbsp;' ?>

<?php endif; ?>