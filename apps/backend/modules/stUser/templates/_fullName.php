<?php use_helper('stTooltip'); ?>
<?php if($full_name && $full_name!='-'): ?>
    <?php echo '<a class="list_tooltip" href="'.st_url_for('stUser/edit?id='.$id).'" title="'.$full_name.'"><img src="/images/backend/beta/icons/16x16/user.png" style="vertical-align: middle; padding-right: 3px;" /></a><a class="list_tooltip" href="'.st_url_for('stUser/edit?id='.$id).'" title="'.$full_name.'">'.truncate_text($full_name, '30', '...').'</a>'; ?>     
    <?php else: ?>
    <?php echo "-"; ?>
<?php endif; ?>