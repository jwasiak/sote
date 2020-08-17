<?php
/**
 * Szablon dla partial'a _list_price
 *
 * @package stProduct
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @copyright SOTE
 * @license SOTE
 * @version $Id: _list_price.php 617 2009-04-09 13:02:31Z michal $
 */ 
?>

<?php use_helper('stCurrency') ?>
<?php use_javascript('stPrice.js') ?>
<?php if ($sf_user->getAttribute('list.mode', null, 'soteshop/stAdminGenerator/stProduct/config') == 'edit'): ?>
<?php echo st_front_symbol() ?> <?php echo input_tag('product['.$product->getId().'][price_brutto]', $sf_request->hasErrors() && $product->getCurrencyExchange() == 1 ?  $sf_request->getParameter('product['.$product->getId().'][price_brutto]') : stPrice::round($product->getPriceBrutto()), array('style' => 'width: 70px', 'class' => 'editable', 'disabled' => $product->getCurrencyExchange() != 1)) ?> <?php echo st_back_symbol() ?>
<script type="text/javascript">
   var field = $('product_<?php echo $product->getId() ?>_price_brutto');
   field.observe('change', function() {
      this.value = stPrice.fixNumberFormat(this.value);
   });

   field.observe('keypress', function(event) {
      if (event.keyCode == Event.KEY_RETURN)
      {
         this.value = stPrice.fixNumberFormat(this.value);
      }
   });
</script>
<?php else: ?>
<?php echo st_back_price($product->getPriceBrutto(), true,true); ?>
<?php endif; ?>