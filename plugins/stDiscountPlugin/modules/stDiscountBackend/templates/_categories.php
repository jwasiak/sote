<?php 
use_helper('stCategory');

$defaults = array();

if ($sf_request->hasErrors() && $sf_request->hasParameter('categories')) 
{      
   $parameters = $sf_request->getParameter('categories');
   $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
}
elseif (!$discount->isNew())
{   
   $defaults = DiscountHasCategoryPeer::doSelectCategoriesForTokenInput($discount);
}

echo category_picker_input_tag('categories', $defaults, array('show_default' => false, 'allow_assign_parents_only' => true));
?>
<script>
    jQuery(function($) {
        $('.all_products').change(function() {
            if ($(this).prop('checked')) {
                $('#sf_fieldset_kategorie_i_producenci').hide();
            } else {
                $('#sf_fieldset_kategorie_i_producenci').show();
            }
        }).change();
    });
</script>