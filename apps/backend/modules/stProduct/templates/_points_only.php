<?php echo checkbox_tag('product[points_only]', true, $product->getPointsOnly()); ?>
<script type="text/javascript">
         
   var points_only = $('product_points_only');

   setInputs();

   points_only.observe('click', function() {       
       setInputs();
   });

    function setInputs(){
       $('product_price_netto')[points_only.checked ? 'disable' : 'enable']();
       $('product_price_brutto')[points_only.checked ? 'disable' : 'enable']();
       $('product_old_price_netto')[points_only.checked ? 'disable' : 'enable']();
       $('product_old_price_brutto')[points_only.checked ? 'disable' : 'enable']();
       $('product_vat')[points_only.checked ? 'disable' : 'enable']();
       $('product_edit_currency')[points_only.checked ? 'disable' : 'enable']();
       $('product_wholesale_a_netto')[points_only.checked ? 'disable' : 'enable']();
       $('product_wholesale_b_netto')[points_only.checked ? 'disable' : 'enable']();
       $('product_wholesale_c_netto')[points_only.checked ? 'disable' : 'enable']();
       $('product_wholesale_a_brutto')[points_only.checked ? 'disable' : 'enable']();
       $('product_wholesale_b_brutto')[points_only.checked ? 'disable' : 'enable']();
       $('product_wholesale_c_brutto')[points_only.checked ? 'disable' : 'enable']();
       
       
    }

</script>
