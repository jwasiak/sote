<?php 
if ($webpage->getTarget()==1)
{
	$checked = 'checked="checked"';
}else{
	$checked = '';
}
?>

<input type="checkbox" <?php echo $checked;?> value="1" name="webpage[target]" />
