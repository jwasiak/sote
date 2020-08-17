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
<?php echo st_back_price($product->getPriceBrutto(), true,true); ?>