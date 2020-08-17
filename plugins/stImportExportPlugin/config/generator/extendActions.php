<?php if ($this->getParameterValue('export')) : ?>
    public function executeExport()
    {
        stAuthUsersListener::checkAccessCredentials($this, $this->getRequest(), $this->getModuleName());
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
        $this->errors = false;
        // obluga wyslanego formualrza
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $this->exporter_name = $this->getRequestParameter('exporter');
            $this->profile = $this->getRequestParameter('profile',0);
            if (class_exists($this->exporter_name)) {
                $exporter = new <?php echo $this->getModuleName() ?>ImportExport('export',$this->exporter_name,'',$this->profile);
                if ($this->getRequestParameter('sample_file')) {
                    $this->setLayout(false);
                    $response = $this->getContext()->getResponse();
                    $response->setContentType("application/octet-stream");
                    $response->setHttpHeader('Content-Disposition', 'attachment; filename="sample.'.$exporter->class_handle->output_file_extension.'"');
                    return $this->renderText($exporter->sampleFile());
                }
                $dataCount = $exporter->getDataCount();
                $this->pb = new stProgressBar('<?php echo $this->getModuleName() ?>','doExport',$dataCount);
                $this->pb->setParam("exporter",$this->exporter_name);
                $this->pb->setParam("profile",$this->profile);
                stImportExportLog::clearLogs('export');
                $this->actual_step = $exporter->doProcess(0);
                $this->export = true;
                if ($dataCount==0 || $this->actual_step>=$dataCount) {
                    $this->errors = $exporter->getImporterExporter()->getLogger()->hasLog();
                    $this->logFile = basename($exporter->getImporterExporter()->getLogger()->getFilename());
                    $link = $this->getController()->genUrl("<?php echo $this->getModuleName() ?>/exportDownload?filename=export_".$exporter->model.".tmp&ext=".$exporter->class_handle->output_file_extension , true);
                    sfLoader::loadHelpers('Partial');
                    $this->pb->setMsg(get_partial('export_link', array('link'=>$link)));
                }
                return sfView::SUCCESS;
            }
        } else {
            $this->profiles = stImportExportPropel::getProfiles('<?php echo $this->getClassName() ?>');
        }
        $this->export = false;
    }

    public function executeDoExport()
    {
        $this->errors = false;
        $this->actual_step = $this->getRequestParameter('step');
        $this->pb = new stProgressBar('<?php echo $this->getModuleName() ?>','doExport');
        $exporter = new <?php echo $this->getModuleName() ?>ImportExport('export', $this->pb->getParam('exporter'),'',$this->pb->getParam('profile'));
        $this->actual_step = $exporter->doProcess($this->actual_step);
        if ($this->actual_step>=$this->pb->getParam('steps')) {
            $this->errors = $exporter->getImporterExporter()->getLogger()->hasLog();
            $this->logFile = basename($exporter->getImporterExporter()->getLogger()->getFilename());
            $link = $this->getController()->genUrl("<?php echo $this->getModuleName() ?>/exportDownload?filename=export_".$exporter->model.".tmp&ext=".$exporter->class_handle->output_file_extension , true);
            sfLoader::loadHelpers('Partial');
            $this->pb->setMsg(get_partial('export_link', array('link'=>$link)));
        }
        
    }

    public function executeExportLog()
    {
        $logFile = $this->getRequestParameter('file');
        $logger = new stImportExportLog(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.$logFile);
        $this->logs = $logger->getLog();
    }

    public function executeExportDownload()
    {
        $this->filename = $this->getRequestParameter('filename');
        $file_extension = $this->getRequestParameter('ext');
        $tmp = sfConfig::get('sf_cache_dir').DIRECTORY_SEPARATOR.$this->filename;

        $path_info = pathinfo($tmp);

        $this->setLayout(false);
        $response = $this->getContext()->getResponse();
        $response->setContentType("application/octet-stream");
        $response->setHttpHeader('Content-Disposition', 'attachment; filename="'.$path_info['filename'].'.'.$file_extension.'"');
        $response->sendHttpHeaders();    

        
        $handle = fopen($tmp,'r');


        if ($handle) 
        {
            while (!feof($handle)) 
            {
                print fread($handle, 8192);
                ob_flush();
                flush();
            }

            fclose($handle);
        } 

        return sfView::NONE;
    }    
<?php endif; ?>


<?php if ($this->getParameterValue('import')) : ?>
    public function executeImport()
    {
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');

        // obluga wyslanego formualrza
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            if($this->getRequest()->getFileName('filename') || $this->getRequestParameter('sample_file') || $this->getRequestParameter('server_file')) {
                $this->importer_name = $this->getRequestParameter('importer');
                if (class_exists($this->importer_name)) {
                    $filename = sfConfig::get('sf_cache_dir').DIRECTORY_SEPARATOR.'import_Product.tmp';
                    if ($this->getRequestParameter('server_file')) {copy(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'import'.DIRECTORY_SEPARATOR.$this->getRequestParameter('server_file') ,$filename);}
                    else { $this->getRequest()->moveFile('filename',$filename); }
                    $importer = new <?php echo $this->getModuleName() ?>ImportExport('import',$this->importer_name, $filename);
                    if ($this->getRequestParameter('sample_file')) {
                        $this->setLayout(false);
                        $response = $this->getContext()->getResponse();
                        $response->setContentType("application/octet-stream");
                        $response->setHttpHeader('Content-Disposition', 'attachment; filename="sample.'.$importer->class_handle->input_file_extension.'"');
                        return $this->renderText($importer->sampleFile());
                    }
                    stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
                    $valid = $importer->validateFile(); 
                    $items = $importer->getDataCount();
                    if ($items && $valid) {
                        $this->pb = new stProgressBar('<?php echo $this->getModuleName() ?>','doImport',$items);
                        $this->pb->setParam("importer",$this->importer_name);
                        $this->pb->setParam("filename",$filename);
                        stImportExportLog::clearLogs('import');
                        $this->import=true;
                        return sfView::SUCCESS;
                    } else {
                        $this->getRequest()->setError('filename', sfContext::getInstance()->getI18n()->__('Nieprawidłowy format pliku', array(), 'stImportExportBackend'));
                        $this->import = false;
                    }
                }
            }
        }
        $this->import = false;
        $finder = sfFinder::type('file');
        $this->importFiles = $finder->in(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'import');
    }
    
    public function executeDoImport()
    {
        stFastCacheManager::disableClearCache();
        stFunctionCache::disableClearCache(array('stTax'));
        stPartialCache::disableClearCache();

        $this->setLayout(false);
        $this->errors = false;
        $this->actual_step = $this->getRequestParameter('step');
        $this->pb = new stProgressBar('<?php echo $this->getModuleName() ?>','doImport');
        $filename = $this->pb->getParam("filename");
        $importer = new <?php echo $this->getModuleName() ?>ImportExport('import', $this->pb->getParam('importer'),$filename);
        $this->actual_step = $importer->doProcess($this->actual_step);
        if ($this->actual_step>=$this->pb->getParam('steps')) {
            if ($importer->getImporterExporter()->getLogger()->hasLog())
            {
                $this->errors = $importer->getImporterExporter()->getLogger()->hasLog();
                $this->logFile = basename($importer->getImporterExporter()->getLogger()->getFilename());
                $this->pb->setMsg(sfContext::getInstance()->getI18n()->__('Wystąpiły błędy podczas importu danych.', array(), 'stImportExportBackend'));
            }
            else
            {
                $this->pb->setMsg(sfContext::getInstance()->getI18n()->__('Dane zostały zaimportowane pomyślnie', array(), 'stImportExportBackend'));
            }

            stFunctionCache::enableClearCache();
            stPartialCache::enableClearCache();
            stFastCacheManager::enableClearCache();
            
            stFunctionCache::clearAll();
            stPartialCache::clearAll('frontend');
            stFastCacheManager::clearCache();  
        }
        
    }

    public function executeImportLog()
    {
        $logFile = $this->getRequestParameter('file');
        $logger = new stImportExportLog(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.$logFile);
        $this->logs = $logger->getLog();

    }

    public function handleErrorImport()
    {
       $this->import= false;
       $finder = sfFinder::type('file');
       $this->importFiles = $finder->in(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'import');
       return sfView::SUCCESS;
    }


    public function validateImport()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
    
            $importer = $this->getRequestParameter('importer');
     
            // The name field is required
            if (!$importer)
            {
                $this->getRequest()->setError('importer', sfContext::getInstance()->getI18n()->__('Proszę wybrać format pliku', array(), 'stImportExportBackend'));
                return false;
            }
         
            $filename = $this->getRequest()->getFileName('filename');
     
            // The name field is required
            if (!$filename && !$this->getRequestParameter('sample_file'))
            {
                if (!$this->getRequestParameter('server_file')) {
                    $this->getRequest()->setError('filename', sfContext::getInstance()->getI18n()->__('Nie wybrano pliku z danymi', array(), 'stImportExportBackend'));
                    return false;
                }
            }
        } 
        return true;
    }
<?php endif; ?>