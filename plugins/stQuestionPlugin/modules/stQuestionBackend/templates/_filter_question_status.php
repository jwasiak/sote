<?php echo object_select_tag(isset($filters['filter_question_status']) ? $filters['filter_question_status'] : null, null, array (
  'include_custom' => '---',
  'related_class' => 'QuestionStatus',
  'text_method' => '__toString',
  'control_name' => 'filters[filter_question_status]',
  'style' => 'width: 80px'
)) ?>