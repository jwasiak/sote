<?php
use_helper('stJQueryTools', 'stPrice', 'I18N');
use_stylesheet('backend/appOnlineCodesPlugin.css');
use_javascript('backend/appOnlineCodesPlugin.js');
$currency = stCurrency::getInstance(sfContext::getInstance())->getBackendMainCurrency();

$code = null;
if (isset($online_codes)) {
	$module = 'online_codes';
	$jsModule = 'Codes';
} elseif (isset($online_files)) {
	$module = 'online_files';
	$jsModule = 'Files';
}



if (is_object($$module)) {
	$product = ProductPeer::retrieveByPk($$module->getProductId());
	if(is_object($product)) $code = $product->getCode();
}

if ($$module->isNew()) {
	echo st_autocompleter_input_tag($module.'[product_code]', $code, array('size' => '5', 'autocompleter' => array(
                  'serviceUrl' => url_for('appOnlineCodesBackend/ajaxSearchProduct?by=code'),
                  'deferRequestBy' => 300,
                  'onSelect' => 'appOnline'.$jsModule.'ProductManagment.updateForm(value, data, el);',
                  'resultFormat' => 'appOnline'.$jsModule.'ProductManagment.fnFormatResult')));
} else {
	echo $code;
}
?>
<div id="app_online_codes-autocomplete-template">
<div class="app_online_codes-autocomplete-item">
<div class="image"><img src="" alt="" /></div>
<div class="content">
<h2></h2>
<ul>
    <li><b><?php echo __('Cena');?>:</b> <?php echo $currency->getFrontSymbol() ?><span
        class="price_netto"></span> <?php echo $currency->getBackSymbol() ?>
    / <?php echo $currency->getFrontSymbol() ?><span
        class="price_brutto"></span> <?php echo $currency->getBackSymbol() ?>
    </li>
</ul>
</div>
</div>
</div>
