<span style="font-size: 14px;"><?php echo $user->getPoints()." ".$points_shortcut;?></span>
<?php echo link_to(__('zmień'), 'stUser/pointsEdit?id='.$user->getId())?>