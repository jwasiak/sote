<?php use_stylesheet('backend/stProductGroup.css');?>

	<script type="text/javascript">
    document.getElementById('product_group_default_product_group').onchange = function(){
        if (this.value == 'NEW') {
        	<?php if ($product_group->getCulture()=="pl_PL"):?>
            document.getElementById('sote_labels_pl').style.display = "block";
            document.getElementById('sote_labels_en').style.display = "none";
            <?php elseif($product_group->getCulture()=="en_US"):?>
            document.getElementById('sote_labels_pl').style.display = "none";
            document.getElementById('sote_labels_en').style.display = "block";
            <?php endif;?>
        } else {
            document.getElementById('sote_labels_pl').style.display = "none";
            document.getElementById('sote_labels_en').style.display = "none";
            document.getElementById('product_group_label_none').checked=true;      
        }
    };
    </script>

<?php 
if ($product_group->getProductGroup() == "NEW")
{
	if ($product_group->getCulture()=="pl_PL") 
	{
		$display_labels_en = "display:none";
		$display_labels_pl = "display:block";
	}
	elseif($product_group->getCulture()=="en_US")
	{
		$display_labels_en = "display:block";
		$display_labels_pl = "display:none";
	}else{
		$display_labels_en = "display:none";
		$display_labels_pl = "display:none";
	}
}else{
		$display_labels_en = "display:none";
		$display_labels_pl = "display:none";
}
?>


<div class="pg_none">
	<?php if (!$product_group->getLabel() || $product_group->getLabel()=='none'):?>
	<?php echo radiobutton_tag('product_group[label]', 'none', true) ?><?php echo __('Brak');?>
	<?php else: ?>
	<?php echo radiobutton_tag('product_group[label]', 'none', false) ?><?php echo __('Brak');?>
	<?php endif;?>
</div>

<div id="sote_labels_pl" class="pg_star" style="<?php echo $display_labels_pl;?>">
	<?php if ($product_group->getLabel()=='new_blue_pl.png'):?>
	<?php echo radiobutton_tag('product_group[label]', 'new_blue_pl.png', true) ?>
	<?php else: ?>
	<?php echo radiobutton_tag('product_group[label]', 'new_blue_pl.png', false) ?>
	<?php endif;?>
	<img src="/uploads/product_group/new_blue_pl.png" width="90" height="25" alt="" /> 

	<?php if ($product_group->getLabel()=='new_green_pl.png'):?>
	<?php echo radiobutton_tag('product_group[label]', 'new_green_pl.png', true) ?>
	<?php else: ?>
	<?php echo radiobutton_tag('product_group[label]', 'new_green_pl.png', false) ?>
	<?php endif;?>
	<img src="/uploads/product_group/new_green_pl.png" width="90" height="25" alt="" />

	<?php if ($product_group->getLabel()=='new_red_pl.png'):?>
	<?php echo radiobutton_tag('product_group[label]', 'new_red_pl.png', true) ?>
	<?php else: ?>
	<?php echo radiobutton_tag('product_group[label]', 'new_red_pl.png', false) ?>
	<?php endif;?>
	<img src="/uploads/product_group/new_red_pl.png" width="90" height="25" alt="" />

	<?php if ($product_group->getLabel()=='new_yellow_pl.png'):?>
	<?php echo radiobutton_tag('product_group[label]', 'new_yellow_pl.png', true) ?>
	<?php else: ?>
	<?php echo radiobutton_tag('product_group[label]', 'new_yellow_pl.png', false) ?>
	<?php endif;?>
	<img src="/uploads/product_group/new_yellow_pl.png" width="90" height="25" alt="" />
</div>

<div id="sote_labels_en" class="pg_star" style="<?php echo $display_labels_en;?>">
	<?php if ($product_group->getLabel()=='new_blue_en.png'):?>
	<?php echo radiobutton_tag('product_group[label]', 'new_blue_en.png', true) ?>
	<?php else: ?>
	<?php echo radiobutton_tag('product_group[label]', 'new_blue_en.png', false) ?>
	<?php endif;?>
	<img src="/uploads/product_group/new_blue_en.png" width="75" height="25" alt="" /> 

	<?php if ($product_group->getLabel()=='new_green_en.png'):?>
	<?php echo radiobutton_tag('product_group[label]', 'new_green_en.png', true) ?>
	<?php else: ?>
	<?php echo radiobutton_tag('product_group[label]', 'new_green_en.png', false) ?>
	<?php endif;?>
	<img src="/uploads/product_group/new_green_en.png" width="75" height="25" alt="" />

	<?php if ($product_group->getLabel()=='new_red_en.png'):?>
	<?php echo radiobutton_tag('product_group[label]', 'new_red_en.png', true) ?>
	<?php else: ?>
	<?php echo radiobutton_tag('product_group[label]', 'new_red_en.png', false) ?>
	<?php endif;?>
	<img src="/uploads/product_group/new_red_en.png" width="75" height="25" alt="" />

	<?php if ($product_group->getLabel()=='new_yellow_en.png'):?>
	<?php echo radiobutton_tag('product_group[label]', 'new_yellow_en.png', true) ?>
	<?php else: ?>
	<?php echo radiobutton_tag('product_group[label]', 'new_yellow_en.png', false) ?>
	<?php endif;?>
	<img src="/uploads/product_group/new_yellow_en.png" width="75" height="25" alt="" />
</div>


<div class="pg_my_image">
	<div class="desc_label">	
	<?php if ($product_group->getLabel()=='my_image'):?>
	<?php echo radiobutton_tag('product_group[label]', 'my_image', true) ?><?php echo __('Własny obrazek');?>
	<?php else: ?>
	<?php echo radiobutton_tag('product_group[label]', 'my_image', false) ?><?php echo __('Własny obrazek');?>
	<?php endif;?>
	</div>
	
	<?php if ($product_group->getImage()): ?>
	<div>
	<img src="/uploads/product_group/<?php echo $product_group->getImage();?>" />
	</div>
	<div class="clear" /></div>
	<?php endif; ?>
	
</div>
<div style="clear: both;" /></div>

<div style="padding-top: 5px;"><?php echo input_file_tag('product_group[image]') ?></div>
<?php if ($product_group->getImage()): ?>
   <p><?php echo checkbox_tag('product_group[delete_image]', 1, false) ?> <?php echo __('usuń obrazek') ?></p>

<script type="text/javascript">
   $('product_group_delete_image').observe('click', function ()
   {
      var product_group_image = $('product_group_image');

      product_group_image[this.checked ? 'disable' : 'enable']();
   });
</script>
<?php endif; ?>
