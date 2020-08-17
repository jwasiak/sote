<?php 

if($sf_request->getParameter('group[matrix_on]')){    
    
    if($sf_request->getParameter('group[matrix_on]')=="true"){
        $checked = "checked=checked";
    }else{
        $checked = "";
    }
}else{
    $checked = "";
}
 
 
 
?>

<input id="matrix_on" type="radio" name="group[matrix_on]" value="true" <?php echo $checked  ?> />