<?php
/** 
 * SOTESHOP/stUpdate 
 * 
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE. 
 * Do not modify this file, system will overwrite it during upgrade.
 * 
 * @package     stUpdate
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: stActionsFinder.class.php 11065 2011-02-16 10:38:27Z marek $
 */

/** 
 * Symfony actions finder.
 *
 * @author Marek Jakubowicz <marek.jakubowicz@sote.pl>
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stActionsFinder
{
    /** 
     * Get all actions
     *
     * @return   array
     */
    public function getAllActions()
    {
        $frontend = $this->getActions('frontend');
        $backend  = $this->getActions('backend');
        $plugins  = $this->getPluginsActions(array('frontend','backend'));
        return array(
            'frontend'=> array_merge($frontend,$plugins['frontend']),
            'backend' => array_merge($backend, $plugins['backend']),
        );
    }
    
    /** 
     * Get URL for provided application.
     *
     * @param        string      $app
     * @param   string      $unique             NULL - all actions, 'unique' - only 1 action for module
     * @return   array
     */
    public function getActionsURL($app,$unique=NULL)
    {
        $urls=array();$set=array();
        $hostname=sfContext::getInstance()->getRequest()->getHost();
        $protocol='http';
        if ($app=='frontend') $index='index.php';
        else $index=$app.'.php';
    
        if (empty($this->actions)) $this->actions = $this->getAllActions();
        foreach ($this->actions[$app] as $module=>$actions)
        {
            foreach ($actions as $action)
            {        
                if ($unique=='unique')
                {
                    if (! isset($set[$module]))
                    {
                        $urls[]=$protocol.'://'.$hostname.'/'.$index.'/'.$module.'/'.$action;
                        $set[$module]=1;
                    }
                } else $urls[]=$protocol.'://'.$hostname.'/'.$index.'/'.$module.'/'.$action;
            }
        }
        
        return $urls;
    }
    
    /** 
     * Get application actions.
     */
    private function getActions($app)
    {
        $app_dir = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.sfConfig::get('sf_apps_dir_name').DIRECTORY_SEPARATOR.$app;
        $app_modules_dir = $app_dir.DIRECTORY_SEPARATOR.sfConfig::get('sf_app_module_dir_name');
        $a=$this->getModuleActions($app_modules_dir);        
        return $a;
    }
    
    /** 
     * Get plugins actions.
     *
     * @return   array
     */
    private function getPluginsActions($apps)
    {
        $plugins = sfFinder::type('dir')->name("*")->relative()->maxdepth(0)->in(sfConfig::get('sf_plugins_dir'));
        $result=array();
        foreach ($plugins as $plugin)
        {        
            $app_modules_dir = sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.$plugin.DIRECTORY_SEPARATOR.sfConfig::get('sf_app_module_dir_name');
            $a=$this->getModuleActions($app_modules_dir);        
            foreach ($a as $module=>$data)
            {
                foreach ($apps as $app)
                {
                    preg_match("/(".$app.")/i",$module,$matches);
                    if (! empty($matches[1])) $result[$app][$module]=$data;
                }
            }
        }
        return $result;
    }
    
    /** 
     * Get actions in module.
     *
     * @param        string      $module
     * @return        array       actions
     */
    private function getModuleActions($app_modules_dir)
    {
        $modules = sfFinder::type('dir')->name('*')->maxdepth(0)->relative()->in($app_modules_dir);
        $a=array();
        foreach ($modules as $module)
        {
            $action_file = $app_modules_dir.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'actions'.DIRECTORY_SEPARATOR.'actions.class.php';
            if (file_exists($action_file))
            {
                $actions=$this->getActionsName($action_file);
                if (! empty($actions)) $a[$module]=$actions;
            }
        }
        
        return $a;
    }
    
    
    /** 
     * Get actions name.
     *
     * @param   string      $file               action file
     * @return  array       actions names
     */
    private function getActionsName($file)
    {
        $data=file_get_contents($file);
        $lines=preg_split("/\n/",$data);
        $a=array();
        foreach ($lines as $line)
        {
            preg_match("/function[\s]+execute([a-z0-9_-]+)/i",$line,$matches);
            if (! empty($matches[1])) $a[]=$matches[1];
        }
        
        return $a;
    }
}