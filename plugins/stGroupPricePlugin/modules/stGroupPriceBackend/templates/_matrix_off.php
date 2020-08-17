<?php 
$checked = "checked=checked";
if($sf_request->getParameter('group[matrix_on]')){    
    
    if($sf_request->getParameter('group[matrix_on]')=="false"){
        $checked = "checked=checked";
    }else{
        $checked = "";
    }
} 
?>

<input id="matrix_off" type="radio" name="group[matrix_on]" value="false" <?php echo $checked ?> />

<script type="text/javascript">
jQuery(function ($)
{
    $(document).ready(function()
    {
     
        $('#matrix_off').click(function(){
            $(".row_tax_id").hide();
            $(".row_price").hide();
            $(".row_old_price").hide();
            $(".row_wholesale_price").hide();
            $(".action-save").hide();
            
            $(".row_price_type").show();
            $(".row_price_mod").show();
        });
        
        $('#matrix_on').click(function(){
            $(".row_tax_id").show();
            $(".row_price").show();
            $(".row_old_price").show();
            $(".row_wholesale_price").show();
            $(".action-save").show();
            
            $(".row_price_type").hide();
            $(".row_price_mod").hide();
        }); 
        
        if($('#matrix_off').attr('checked'))
        {
            $(".row_tax_id").hide();
            $(".row_price").hide();
            $(".row_old_price").hide();
            $(".row_wholesale_price").hide();
            $(".action-save").hide();
            
            $(".row_price_type").show();
            $(".row_price_mod").show();
        }else{
            $(".row_tax_id").show();
            $(".row_price").show();
            $(".row_old_price").show();
            $(".row_wholesale_price").show();
            $(".action-save").show();
            
            $(".row_price_type").hide();
            $(".row_price_mod").hide();   
        }
         
     });
});

</script>

