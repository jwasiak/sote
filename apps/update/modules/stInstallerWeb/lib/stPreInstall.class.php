<?php
/**
 * Class with methods executed before install
 *
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * Pre install class
 */
class stPreInstall 
{
    /**
     * @var string install dir
     */
    var $install_dir;
    
    public function __construct()
    {
        $this->install_dir = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src';
        return true;
    }
    
    /**
     * Return all packages with package/stAppName/preinstall.yml files
     *
     * @return array array(stAppName1, stAppName2, ...)
     */
    public function getApps()
    {
        $dirs=sfFinder::type('dir')->maxdepth(0)->relative()->in($this->install_dir);
        $apps=array();
        foreach ($dirs as $dir)
        {
            $preinstall_yml = $this->getPreinstallConfigPath($dir);
            if(file_exists($preinstall_yml))
            {
                $apps[]=$dir;
            }
        }
    
        return $apps;
    }
    
    /**
     * Returnt path to config file for app
     *
     * @param string $app
     * @return string
     */
    private function getPreinstallConfigPath($app)
    {
        return $this->install_dir.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'preinstall.yml';
    }    
    
    /**
     * Get config for app
     *
     * @param string
     */
    public function getConfig($app)
    {
        $data = sfYaml::load($this->getPreinstallConfigPath($app));
        return $data;
    }
}