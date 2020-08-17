<?php
/**
 * Changelog function class 
 *
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * Changelog
 */
class stChangelogFunctions
{
    var $result=false;  
        
    /**
     * Smarty templatecs changed. 
     *
     * @param array $params
     * @param string $mode execute|content 
     * @return mixed
     */
    public function smartyTemplatesChanged($app,$params,$method='condition',$keyname_params=NULL)
    {
        
        $smarty_changelog = stChangelogSmarty::getInstance();
        switch ($method)
        {
            case 'condition':  return $smarty_changelog->condition($app,$params); break;        
            case 'runkeyname': return $smarty_changelog->runkeyname($app,$params,$keyname_params); break;
            case 'runapp':     return $smarty_changelog->runapp($app,$params); break;              
        }
    }    
    
    /**
     * Description for changes
     *
     * @param array $params
     * @param string $mode execute|content 
     * @return mixed
     */
    public function description($app,$params,$method='condition',$keyname_params)
    {
        $description = stChangelogDescription::getInstance();
        switch ($method)
        {
            case 'condition':  return $description->condition($app,$params); break;        
            case 'runkeyname': return $description->runkeyname($app,$params,$keyname_params); break;
            case 'runapp':     return NULL; break;    
        }
    }    
    
}