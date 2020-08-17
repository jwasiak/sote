<?php 
use_helper('stCategory');

$defaults = array();

if ($sf_request->hasErrors()) 
{      
   $parameters = $sf_request->getParameter('categories');
   $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
}
elseif (!$gift_card->isNew())
{   
   $defaults = GiftCardHasCategoryPeer::doSelectCategoriesForTokenInput($gift_card);
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