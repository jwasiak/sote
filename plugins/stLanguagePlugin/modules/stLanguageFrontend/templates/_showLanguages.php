<?php
use_helper('stUrl');
if (empty($smarty)) $smarty = new stSmarty('stLanguageFrontend');
$showLanguages = array();

$stWebRequest = new stWebRequest();
if($stWebRequest->getPathInfo() != '/' && ereg('Googlebot', $stWebRequest->getHttpUserAgent()))
{
}
else
{
    if(!$sf_flash->has('stLanguage-hideLanguages'))
    {
        $stLanguage = stLanguage::getInstance($sf_context);
        $languages = LanguagePeer::doSelectActive();
        if (is_array($languages) && count($languages) > 1)
        {
            foreach ($languages as $key => $language)
            {
                if($language->getOriginalLanguage() == stLanguage::getHydrateCulture())
                {
                    if($language->getActiveImage())
                    {
                        $showLanguages[$key] = image_tag('/'.sfConfig::get('sf_upload_dir_name').'/stLanguagePlugin/'.$language->getActiveImage(), array('alt' => ''));
                    }
                    else
                    {
                        $showLanguages[$key] = $language->getShortcut();
                    }
                }
                else
                {
                    if($language->getInactiveImage())
                    {
                        if($stLanguage->hasLangParameterInUrl($language->getShortcut()))
                        {
                            $showLanguages[$key] = st_link_to(image_tag('/'.sfConfig::get('sf_upload_dir_name').'/stLanguagePlugin/'.$language->getInactiveImage(), array('alt' => '')), $stLanguage->getPath($language->getShortcut()), array('for_lang' => $language->getShortcut()));
                        }
                        else
                        {
                            $showLanguages[$key] = st_link_to(image_tag('/'.sfConfig::get('sf_upload_dir_name').'/stLanguagePlugin/'.$language->getInactiveImage(), array('alt' => '')), $stLanguage->getPath($language->getShortcut()), array('absolute' => true, 'for_host' => $stLanguage->hasLangParameterInUrl($language->getShortcut(), true), 'for_lang' => $language->getShortcut()));
                        }
                    }
                    else
                    {
                        if($stLanguage->hasLangParameterInUrl($language->getShortcut()))
                        {
                            $showLanguages[$key] = st_link_to($language->getShortcut(), $stLanguage->getPath($language->getShortcut()), array('for_lang' => $language->getShortcut()));
                        }
                        else
                        {
                            $showLanguages[$key] = st_link_to($language->getShortcut(), $stLanguage->getPath($language->getShortcut()), array('absolute' => true, 'for_host' => $stLanguage->hasLangParameterInUrl($language->getShortcut(), true), 'for_lang' => $language->getShortcut()));
                        }
                    }
                }
            }
        }
    }else
    {
        $sf_flash->get('stLanguage-hideLanguages');
    }
}
$smarty->assign('languages', $showLanguages);
$smarty->display('language_show_languages.html');
?>