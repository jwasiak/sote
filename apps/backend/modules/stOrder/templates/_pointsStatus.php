<?php 
if($points_status == 1){
 echo __("tak");
}elseif($points_earn>0){
 echo __("nie")." ".st_link_to(__("(rozlicz)"),"stPointsBackend/addPointsForOrder?id=".$order_id);
}else{
 echo "-";
}

?>