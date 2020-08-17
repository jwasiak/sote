<?php echo input_file_tag('theme_config[bg_banner]') ?>
&nbsp;<?php echo __('powielanie')  ?>: &nbsp;
<?php echo select_tag('theme_config[bg_banner_repeat]', options_for_select(
      array('no-repeat' => __('brak'),
            'repeat-x' => __('powiel w poziomie'),
            'repeat-y' => __('powiel w pionie'),
            'repeat' => __('powiel w pionie i poziomie')
          ),
      array($theme_config->getBgBannerRepeat())
		)) ?>