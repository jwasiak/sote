<?php use_helper('stTooltip'); ?>

<?php echo '<a class="list_tooltip" href="'.st_url_for('stUser/edit?id='.$id).'" title="'.$username.'">'.link_to(truncate_text($username, '70', '...'), 'stUser/edit?id='.$id); ?>
