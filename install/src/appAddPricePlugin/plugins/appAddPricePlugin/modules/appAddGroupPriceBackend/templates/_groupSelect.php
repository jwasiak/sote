<?php 
echo $groupPrice->getName();

if($groupPrice->getDescription()!=""){
   echo " - ".$groupPrice->getDescription(); 
}
?>