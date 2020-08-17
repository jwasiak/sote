</div>
<?php if($dataUse == 1):?>
    <?php if($dayLimit != -1):?>
        <?php echo __('Pozostało');?> <?php echo $dayLimit;?> <?php echo __('dni do wygaśnięcia licencji.');?>
    <?php endif;?>
<?php else:?>
    <?php echo __('Licencja straciła ważność');?>
<?php endif;?>