<?php  
$config = stConfig::getInstance(sfContext::getInstance(), 'appTermsBackend');
$config->setCulture(sfContext::getInstance()->getRequest()->getParameter('culture', stLanguage::getOptLanguage()));
?>

<input type="text" size="60;" value="<?php echo $config->get('terms_field1', null, true) ?>" id="webpage_terms_field1" name="webpage[terms_field1]"> 