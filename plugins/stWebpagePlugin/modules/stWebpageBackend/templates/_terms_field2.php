<?php  
$config = stConfig::getInstance(sfContext::getInstance(), 'appTermsBackend');
$config->setCulture(sfContext::getInstance()->getRequest()->getParameter('culture', stLanguage::getOptLanguage()));
?>

<textarea cols="60" rows="6" tinymce_options="height:80,width:'60%'" id="webpage_terms_field2" name="webpage[terms_field2]"><?php echo $config->get('terms_field2', null, true)?></textarea>
 
