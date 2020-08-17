<?php
class stGuardUserThemeValidator extends sfGuardUserValidator
{
    public function execute(&$value, &$error)
    {
        $i18n = sfContext::getInstance()->getI18N();

        $path = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'soteshop.yml';

        $config = sfYaml::load($path);

        $developerTheme = $config['all']['.view']['theme'];

        if ($developerTheme)
        {
            $error = $i18n->__('W sklepie wdrożono indywidualną grafikę. Edycja grafiki możliwa tylko przez programistów.');
            
            return false;
        }

        return parent::execute($value, $error);
    }
}