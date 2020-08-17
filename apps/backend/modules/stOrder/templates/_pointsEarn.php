<?php 
if($points_earn>0){
    echo $points_earn." ".$config_points->get('points_shortcut', null, true);    
}else{
    echo "-";
}
?>
