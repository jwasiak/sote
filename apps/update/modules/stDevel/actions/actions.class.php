<?php
/** 
 * SOTESHOP/stUpdate 
 * 
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE. 
 * Do not modify this file, system will overwrite it during upgrade.
 * 
 * @package     stUpdate
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: actions.class.php 10660 2011-01-30 12:54:51Z marek $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * stDevelActions
 *
 * @package     stUpdate
 * @subpackage  actions
 */
class stDevelActions extends sfActions
{
    public function executePhpInfo()
    {
        $iframe=$this->getRequestParameter('iframe');
        if (! empty($iframe))
        {
            $this->iframe=1;
            $this->setLayout(false);
        } else {
            $this->iframe_uri=$this->getRequest()->getUri().'/iframe/1';
            $this->iframe=0;
        }
    }

    public function executeDevel()
    {
        $this->hostname = sfContext::getInstance()->getRequest()->getHost();
        $apps = array('index'=>'frontend', 'backend'=>'backend', 'update'=>'update');
        $this->stWebRequest = new stWebRequest();
        $this->hasDevel = false;

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequest()->hasParameter('devel[devel]'))
            {
                if ($this->getRequest()->getParameter('devel[devel]') == 1)
                {
                    $ip = $this->getRequest()->getParameter('devel[ip]');
                    $content_head = "<?php\nif(\$_SERVER['REMOTE_ADDR'] != '$ip') die();?>"; 

                    foreach($apps as $file=>$app)
                    {
                        $app_web=sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.$file.'.php';
                        $app_web_devel=sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.$app.'_dev.php';
                        $app_web_content=file_get_contents($app_web);                    
                        $content=$this->setDevel($content_head.$app_web_content);
                        file_put_contents($app_web_devel, $content);
                    }
                }
            } else {
                foreach($apps as $file=>$app)
                {
                    $file = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.$app.'_dev.php';
                    @unlink($file);
                }                
            }                      
        }
        
        foreach($apps as $app)
        {
            $file = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.$app.'_dev.php';
            if (file_exists($file)) $this->hasDevel = true;
        }
        
        // @todo ass set hasBeta
    }
    
    /** 
     * Change files web/{$app}.php to developer mode.
     *
     * @param        string      $app
     * @return   string
     */
    private function setDevel($content)
    {
        $content=str_replace("define('SF_ENVIRONMENT', 'prod')","define('SF_ENVIRONMENT', 'dev')",$content);
        $content=str_replace("define('SF_DEBUG',       false)","define('SF_DEBUG',       true)",$content);
        return $content;
    }
    

    
}