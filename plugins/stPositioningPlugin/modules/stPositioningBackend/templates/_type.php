<?php if($positioning->getSystemName() != 'DEFAULT_VALUE'):?>
    <?php $positioningOptions = array(stPositioning::TYPE_DEFAULT => __('Ustaw domyślne wartości'), stPositioning::TYPE_USER => __('Ustaw poniższe wartości'), /*stPositioning::TYPE_GENERATE => 'Generuj automatycznie'*/);?>
    <?php echo select_tag("positioning[type]", options_for_select($positioningOptions, $positioning->getType())); ?>
<?php else:?>
    <?php echo __('Ustawienia domyślne nie posiadają opcji wyświetlania.')?>
<?php endif;?>
11