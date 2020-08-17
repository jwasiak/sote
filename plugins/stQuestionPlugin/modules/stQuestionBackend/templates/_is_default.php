<?php $value = object_checkbox_tag($question_status, 'getIsDefault', array (
  'control_name' => 'question_status[is_default]', 'disabled' => $question_status->getStatusType() != 'ST_NEW' || $question_status->getIsDefault()
)); echo $value ? $value : '&nbsp;' ?>
<?php if ($question_status->getStatusType() != 'ST_NEW' || $question_status->getIsDefault()): ?>
    <?php echo input_hidden_tag('question_status[is_default]', $question_status->getIsDefault()) ?>
<?php endif; ?>