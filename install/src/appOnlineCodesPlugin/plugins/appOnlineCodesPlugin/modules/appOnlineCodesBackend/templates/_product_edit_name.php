<?php
$id = $name = null;

if (isset($online_codes)) {
	$module = 'online_codes';
	$jsModule = 'Codes';
} elseif (isset($online_files)) {
	$module = 'online_files';
	$jsModule = 'Files';
}

if (is_object($$module)) {
	$product = ProductPeer::retrieveByPk($$module->getProductId());
	if(is_object($product)) {
		$id = $$module->getProductId();
		$name = $product->getName();
	}
}
if ($$module->isNew()) {
	echo st_autocompleter_input_tag($module.'[product_name]', $name, array('size' => '50', 'autocompleter' => array(
                  'serviceUrl' => url_for('appOnlineCodesBackend/ajaxSearchProduct?by=name'),
                  'deferRequestBy' => 300, 'minChars' => 3,
                  'onSelect' => 'appOnline'.$jsModule.'ProductManagment.updateForm(value, data, el);',
                  'resultFormat' => 'appOnline'.$jsModule.'ProductManagment.fnFormatResult')));
} else {
	echo $name;
}
echo input_hidden_tag($module.'[product_id]', $id);
