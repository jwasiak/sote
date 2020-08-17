<?php use_helper('stText'); ?>
<?php if($company && $company!="-"): ?>
    <?php echo '<a class="list_tooltip" href="'.st_url_for('stUser/edit?id='.$id).'" title="'.$company.'">'.truncate_text($company, '30', '...').'</a>'; ?>     
    <?php else: ?>
    <?php echo "-"; ?>
<?php endif; ?>