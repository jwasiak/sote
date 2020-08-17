    public function executeSoap()
    {
        if (!stWebApi::isEnabled()) return $this->redirect('stBackendMain/list');
        
        $config = stConfig::getInstance('stWebApiBackend');
        if ($config->get('ssl', false) && !$this->getRequest()->isSecure()) throw new SoapFault('SSL', 'Please try via SSL.');

        $WSDLFile = sfConfig::get('sf_module_cache_dir').DIRECTORY_SEPARATOR.'<?php echo $this->getGeneratedModuleName() ?>'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'webapi.wsdl';
        $moduleTpl = sfConfig::get('sf_app_module_dir').DIRECTORY_SEPARATOR.'<?php echo $this->getModuleName() ?>'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'webapi.wsdl';
        $generate = !file_exists($WSDLFile); 


        if ($generate && is_file($moduleTpl)) {
            $contents = file_get_contents($moduleTpl); 
            $contents = str_replace("{HOST}", (stConfig::getInstance('stWebApiBackend')->get('ssl', false) ? 'https://' : 'http://').$this->getRequest()->getHost(), $contents);
            file_put_contents($WSDLFile, $contents);
        }
        elseif ($generate) {
            $WSDLFileTmp = sfConfig::get('sf_module_cache_dir').DIRECTORY_SEPARATOR.'<?php echo $this->getGeneratedModuleName() ?>'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'webapi.xml.php';
            $WSDLContent = file_get_contents($WSDLFileTmp);
            <?php echo 'file_put_contents($WSDLFile,substr($WSDLContent,strpos($WSDLContent,"<?xml")));' ?> 
        }
        
        $this->setLayout(false);
        $response = $this->getResponse();
        $response->setContentType( "text/xml" );
        
        if ($this->hasRequestParameter('wsdl')) {
            return $this->renderText(file_get_contents($WSDLFile) );
        } else {
            ini_set("soap.wsdl_cache_enabled",0);
        
            $soap = new SoapServer($WSDLFile);
            $soap->setClass( "<?php echo ucfirst($this->getModuleName()) ?>WebApi");
            ob_start();
            $soap->handle();
            return $this->renderText(ob_get_clean());
        }
    }
