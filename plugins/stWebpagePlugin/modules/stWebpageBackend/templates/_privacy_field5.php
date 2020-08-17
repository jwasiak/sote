<?php  
$config = stConfig::getInstance(sfContext::getInstance(), 'appTermsBackend');
$config->setCulture(sfContext::getInstance()->getRequest()->getParameter('culture', stLanguage::getOptLanguage()));
?>

<input type="text" size="60;" value="<?php echo $config->get('privacy_field5', null, true) ?>" id="webpage_privacy_field5" name="webpage[privacy_field5]"> 
