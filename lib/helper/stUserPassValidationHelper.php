<?php
use_helper('Javascript');

$response = sfContext::getInstance()->getResponse();
use_javascript('/stCategoryTreePlugin/js/jquery-1.3.2.min.js', 'first');

use_javascript('/stCategoryTreePlugin/js/jquery-no-conflict.js', 'first');
$response->addJavascript('passValidator/digitalspaghetti.password.js','last');

$options=array(
    'displayMinChar'=> 'true',
    'minChar'=> '6',
    'minCharText'=> __('Minimalnie 6 znaków'),
    'colors'=> array('#FF0000', '#FF5500', '#FFD400', '#C8F31E', '#49F31E'),
    'scores'=> array(6, 30, 40, 50),
    'verdicts'=>	array(__('bardzo słabe'), __('słabe'), __('normalne'), __('mocne'), __('bardzo mocne')),
    'raisePower'=> '1.4',
    'debug'=> 'false'
);

echo javascript_tag('digitalspaghetti.password.defaults = '.json_encode($options).';');

?>
