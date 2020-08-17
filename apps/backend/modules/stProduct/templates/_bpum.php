<?php if (!$sf_user->getParameter('hide', false,'stProduct/edit/fields/bpum_value')): ?>

  <div style="margin-left: 0px;" class="field<?php if ($sf_request->hasError('product{bpum_value}')): ?> form-error<?php endif; ?>">
<?php if ($sf_request->hasError('product{bpum_value}')): ?>
    <?php echo form_error('product{bpum_value}', array('class' => 'form-error-msg')) ?>
<?php endif; ?>

 <?php echo object_input_tag($product, 'getBpumValue', array (
  'size' => 7,
  'control_name' => 'product[bpum_value]',
)); ?> 

<?php $selected_val = 0; ?>
<select include_blank="" id="product_bpum_id" name="product[bpum_id]">
<option class="sub-none" value="">---</option>    
<?php foreach($bpum as $unit): ?>
    
<option <?php if($product->getBpumId() == $unit->getId()){ echo "selected='selected'"; $selected_val = $unit->getId();}  ?> class="sub-<?php echo $unit->getUnitGroup(); ?>" value="<?php echo $unit->getId(); ?>"><?php echo $unit->getUnitSymbol()." (".$unit->getUnitName().")" ; ?></option>
    
<?php endforeach; ?>
</select> 
<span id="optionstore" style="display:none;"></span>

  <div class="clr"></div>
  </div>

<?php endif; ?>
<?php echo st_price_add_format_behavior(get_id_from_name("product_bpum_value")); ?>

<script type="text/javascript">
jQuery(function($) {

$(document).ready(function() {
    
    var selected_val = <?php echo $selected_val; ?>;
    var cattype = $("#product_bpum_default_id option[value='"+ $('#product_bpum_default_id').val() +"']").attr('class')
    optionswitch(cattype);
    $("#product_bpum_id").val(selected_val);
    checkvisible();
    
    $('#product_bpum_default_id').on("change", function() {
        var cattype = $("#product_bpum_default_id option[value='"+ $(this).val() +"']").attr('class')
        optionswitch(cattype);
        checkvisible();    
    });

});

function checkvisible() {
    if($('#product_bpum_default_id').val()==""){
            $('.row_bpum').hide();
        }else{
            $('.row_bpum').show();
        }
}

function optionswitch(myfilter) {
    //Populate the optionstore if the first time through
    if ($('#optionstore').text() == "") {
        $('option[class^="sub-"]').each(function() {
            var optvalue = $(this).val();
            var optclass = $(this).prop('class');
            var opttext = $(this).text();
            optionlist = $('#optionstore').text() + "@%" + optvalue + "@%" + optclass + "@%" + opttext;
            $('#optionstore').text(optionlist);
        });
    }
    //delete everything
    $('option[class^="sub-"]').remove();
    // put the filtered stuff back
    populateoption = rewriteoption(myfilter);
    $('#product_bpum_id').html(populateoption);
}

function rewriteoption(myfilter) {
    //rewrite only the filtered stuff back into the option
    var options = $('#optionstore').text().split('@%');
    var resultgood = false;
    var myfilterclass = "sub-" + myfilter;
    var optionlisting = "";
    
    myfilterclass = (myfilter != "")?myfilterclass:"all";
    //first variable is always the value, second is always the class, third is always the text
    for (var i = 3; i < options.length; i = i + 3) {
        if (options[i - 1] == myfilterclass || myfilterclass == "all") {
            optionlisting = optionlisting + '<option value="' + options[i - 2] + '" class="sub-' + options[i - 1] + '">' + options[i] + '</option>';
            resultgood = true;
        }
    }
    if (resultgood) {
        return optionlisting;
    }
}

});
</script>
