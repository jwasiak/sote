<?php echo input_file_tag('theme_config[css][body][background-image]') ?>
&nbsp;<?php echo __('powielanie') ?>: &nbsp;
<?php
echo select_tag('theme_config[css][body][background-repeat]', options_for_select(array(
            'no-repeat' => __('brak'),
            'repeat-x' => __('powiel w poziomie'),
            'repeat-y' => __('powiel w pionie'),
            'repeat' => __('powiel w pionie i poziomie')
                ), 
            $theme_config->getBodyCss('background-repeat')))
?>

