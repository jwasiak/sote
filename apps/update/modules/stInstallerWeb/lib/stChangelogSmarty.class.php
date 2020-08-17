<?php
/**
 * Changelog Smarty  class
 *
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * Changelog
 */
class stChangelogSmarty extends stChangelogBase
{
	/**
	 * @var string unique changed smarty files
	 */
	var $files=array();
	 
	/**
	 * Instance
	 */
	protected static $instance = null;

	/**
	 * Singleton
	 *
	 * @return stChangeLogSmarty
	 */
	public static function getInstance()
	{
		$base_class = __CLASS__;
		if (null === self::$instance) self::$instance = new $base_class();
		return self::$instance;
	}

	/**
	 * Smarty templatecs changed, detect and remember data
	 *
	 * @param string $app   Application
	 * @param mixed $params Parameters
	 * @return array('return'=>bool,'result'=>mixed)
	 */
	public function condition($app,$params)
	{
		$exists=0;

		// get default theme
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();
		$path = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'soteshop.yml';
		$config = sfYaml::load($path);
		$developerTheme = $config['all']['.view']['theme'];
		if (! $developerTheme)
		{
			$c = new Criteria();
			$c->add(ThemePeer::ACTIVE, 1);
			$theme_object = ThemePeer::doSelectOne($c);
			$theme = $theme_object->getTheme();
		}
		else $theme = $developerTheme;
		$databaseManager->shutdown();
		// end

		// ignore default theme names
		if (($theme == 'default') || ($theme=='default2') || ($theme == 'homeelectronics'))
		{
			return true;
		}

		if (empty($params['files'])) return true;

		$files = $params['files'];
		$mytheme_files=array();
		foreach ($files as $id=>$file)
		{
			$file=preg_replace("/\[MY_THEME\]/",$theme,$file);
			$path=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file;
			if (file_exists($path))
			{
				$exists=1;
				$mytheme_files[]=$file;
			}
		}

		if ($exists==1) return array('return'=>true,'result'=>$mytheme_files,'theme'=>$theme);
		else return array('return'=>false);
	}
	 
	/**
	 * Remember unique files for each changelog keyname for app
	 * @param mixed $params result from stChangelogSmarty::execute['result']
	 * @return string HTML
	 */
	public function runkeyname($app,$params)
	{
		foreach ($params as $id=>$filename)
		{
			$this->files[$app][$filename]=1;
		}

		return NULL;
	}
	 
	/**
	 * Return all changed files for app.
	 * @param mixed $params result from stChangelogSmarty::execute['result']
	 * @return array Unique files for app
	 */
	public function runapp($app,$params)
	{
		$i18n = sfContext::getInstance()->getI18N();
		if (! empty($this->files[$app]))
		{
			$content='';
			$content.="<p />";
			$content.="<b>".$i18n->__('Pliki:')."</b>";
			$content.="<ul>\n";
			foreach ($this->files[$app] as $filename=>$tmp)
			{
				if (strlen($filename)>96)
				{
					$max=96;
					$f1=substr($filename,0,$max);
					$f2=substr($filename,$max,strlen($filename)-$max);
					$filename=$f1.' -<br />&nbsp;&nbsp;&nbsp;&nbsp;- '.$f2;
				}
				$content.="<li>$filename</li>\n";
			}
			$content.="</ul>\n";

			return $content;
		} else return NULL;
	}
	 
	/**
	 * Backup files
	 * @return string token for backup
	 */
	public function doBackup()
	{
		// backup $this->files
		$files_all=array();
		foreach ($this->files as $app=>$files)
		{
			$files_all=array_merge($files,$files_all);
		}
		 
		$files_list=array();
		foreach ($files_all as $file=>$tmp)
		{
			$files_list[]=$file;
		}
		$backup = stUpdateBackup::getInstance();
		$token=$backup->doBackup($files_list);
		return $token;
	}
	 
	/**
	 * Return all changed files for all app.
	 * @return array Unique files for app
	 */
	public function getAllFiles()
	{
		$result=array();
		if (! empty($this->files))
		{

			foreach ($this->files as $app=>$files)
			{
				foreach ($files as $filename=>$tmp)
				{
					$result[]=$filename;
				}
			}
		} else $result=NULL;
		 
		return $result;
	}
}