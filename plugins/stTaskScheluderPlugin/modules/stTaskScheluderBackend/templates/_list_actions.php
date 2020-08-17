<?php 
if (!$sf_user->getParameter('progress_bar'))
{
    include sfConfig::get('sf_module_cache_dir').'/auto'.ucfirst($sf_context->getModuleName()).'/templates/_list_actions.php';
}