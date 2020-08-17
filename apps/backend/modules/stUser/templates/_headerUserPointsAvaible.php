<?php 
if($user->getPointsAvailable()==1){
     echo "<b style='color:green;'>".__('włączona')."</b> / ";
     echo link_to(__('wyłącz'), 'stUser/pointsAvailable?on=0&user_id='.$user->getId());
} else{
     echo "<b style='color:red;'>".__('wyłączona')."</b> / ";
     echo link_to(__('włącz'), 'stUser/pointsAvailable?on=1&user_id='.$user->getId());
}

?>    
