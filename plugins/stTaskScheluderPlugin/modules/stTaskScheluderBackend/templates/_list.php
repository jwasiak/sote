<?php 
if ($sf_user->getParameter('progress_bar'))
{
    use_helper('stProgressBar');
    echo progress_bar('stTask', 'stTaskProgressBar', 'execute', $sf_user->getParameter('progress_bar'));
}
else
{
    include sfConfig::get('sf_module_cache_dir').'/auto'.ucfirst($sf_context->getModuleName()).'/templates/_list.php';
}