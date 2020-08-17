<?php
$pearlib = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'pear'.DIRECTORY_SEPARATOR.'php'; 
if (is_dir($pearlib)) ini_set('include_path', '.:'.$pearlib.':'.ini_get('include_path')); 

include('Archive'.DIRECTORY_SEPARATOR.'Tar.php');

class stThemeDownloader {

	protected $themeName = null;

	protected $stFile = null;

	public function __construct($themeName)
	{
		$this->themeName = $themeName;
		$this->themeCopyPath = sfConfig::get('sf_cache_dir').DIRECTORY_SEPARATOR.'themePackage'.DIRECTORY_SEPARATOR.$this->themeName;
		$this->stFile = new stFile();
	}

	public function makePackage()
	{
		$this->prepareDirectory();
		$this->copyFiles();
		$this->archive();
	}

	protected function prepareDirectory()
	{
		if(file_exists($this->themeCopyPath)) $this->stFile->rmdir($this->themeCopyPath);
		$this->stFile->mkdir($this->themeCopyPath);
	}

	protected function copyFiles()
	{
        $update_log_theme = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.$this->themeName.'.plugin';
		$css = glob(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.$this->themeName.DIRECTORY_SEPARATOR.'*');
		$images = glob(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.$this->themeName.DIRECTORY_SEPARATOR.'*');
		$templates = glob(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.$this->themeName.DIRECTORY_SEPARATOR.'*');
		$modules = glob(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.$this->themeName.DIRECTORY_SEPARATOR.'*');
		$plugins = glob(sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.$this->themeName.DIRECTORY_SEPARATOR.'*');
		$config = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'_editor'.DIRECTORY_SEPARATOR.$this->themeName.'.conf';
    	$configTheme = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.$this->themeName.'.yml';
        
        $duplicate = '';
        $update = ''; 
        if (file_exists($update_log_theme)) {
            $pluginName = file_get_contents($update_log_theme);
      		$duplicate = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'duplicate'.DIRECTORY_SEPARATOR.$pluginName.DIRECTORY_SEPARATOR.'stPackageDuplicate.class.php';
            $update = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'update'.DIRECTORY_SEPARATOR.$pluginName.'.php';
        }

		$files = array_merge(   (is_array($css))?$css:array(), 
                                (is_array($images))?$images:array(), 
                                (is_array($templates))?$templates:array(), 
                                (is_array($modules))?$modules:array(), 
                                (is_array($plugins))?$plugins:array(), 
                                array($config,$configTheme,$duplicate,$update));


		foreach ($files as $file) {
			if (file_exists($file)) $this->stFile->copy($file, $this->themeCopyPath.(str_replace(sfConfig::get('sf_root_dir'), '', $file)));
		}
	}

	protected function archive()
	{
		$files = glob($this->themeCopyPath.DIRECTORY_SEPARATOR.'*');

		$tmpFiles = $files;
		$files = array();
		foreach ($tmpFiles as $file) $files[] = str_replace($this->themeCopyPath.DIRECTORY_SEPARATOR, '', $file);

		$cwd = getcwd();
		chdir($this->themeCopyPath);

		$archive = new Archive_Tar($this->getPackagePath(), true);
		$archive->create($files);

		chdir($cwd);

        $this->stFile->rmdir($this->themeCopyPath);
	}

	public function getPackagePath()
	{
		return $this->themeCopyPath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$this->themeName.'.tgz';
	}
}