<?php 
if($points_value>0){
    echo $points_value." ".$config_points->get('points_shortcut', null, true);    
}else{
    echo "-";
}
?>