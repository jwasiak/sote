<?php 
if ($webpage->getState() == "RIGHT2CANCEL")
{
    $checked = 'checked="checked"';
}else{
    $checked = '';
}
?>
<input id="webpage_right2cancel" type="checkbox" <?php echo $checked;?>  value="1" name="webpage[right2cancel]" onclick="if (this.checked){ document.getElementById('webpage_privacy').checked=false; document.getElementById('webpage_terms').checked=false;  document.getElementById('webpage_shipping').checked=false; }else{ document.getElementById('webpage_privacy').disabled = false; document.getElementById('webpage_terms').disabled = false; document.getElementById('webpage_shipping').disabled = false; }" />