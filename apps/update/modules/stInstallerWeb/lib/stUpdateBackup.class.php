<?php
/**
 * Update backup
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * PEAR Tar library
 */
require_once('Archive/Tar.php');
          
/**
 * Update backup
 */
class stUpdateBackup
{
     /**
      * Instance
      */
     protected static $instance = null;

     /**
      * Singleton
      *
      * @param string $base_class
      * @return stUpdateBackup
      */
      public static function getInstance()
      {
          $base_class = __CLASS__;
          if (null === self::$instance) self::$instance = new $base_class();
          return self::$instance;
      }
      
      /**
       * Get backup Token ID
       */
      protected function getToken($files)
      {
          $md5_sign=NULL;
          if (! empty($this->token)) return $this->token;
          foreach ($files as $file)
          {
              $file_path=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file;
              if (file_exists($file_path))
              {
                  $data=file_get_contents($file_path);
                  $md5_data=md5($data);

                  $md5sign=md5($md5sign.$md5_data);
                  unset($data);
              }
          }         
          
          $this->token=$md5sign;          

          if (empty($this->token)) throw new Exception("Empty backup token");          
          return $this->token;
      }
      
      /**
       * Create report file
       * @param array $files
       */
      protected function createReport($files)
      {
          $report='';
          $report.="Date: ".date('Y/m/d H:i:s')."\n";
          $report.="IP: ".$_SERVER['REMOTE_ADDR']."\n";
          $report.="\n";
          $report.="Files:\n";
          foreach ($files as $file)
          {
              $file_path=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file;
              if (file_exists($file_path))
              {
                  $data=file_get_contents($file_path);
                  $md5=md5($data);
                  unset($data);
              } else $md5='not found';
              $report.= " - $file      \tmd5: $md5\n";
          }
          file_put_contents($this->getDir().DIRECTORY_SEPARATOR.'report.txt',$report);
      }
            
      /**
       * Get backup dir
       * @param string $token
       * @return string backup dir
       */
      protected function getDir($token=NULL)
      {
          if (! empty($this->backup_dir)) return $this->backup_dir;
          
          $dir=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'backups'.DIRECTORY_SEPARATOR.$token;
          if (! is_dir($dir))
          {
              if (! mkdir($dir)) throw new Exception("Unable mkdir $dir");
          }                     
          $this->backup_dir=$dir;
          return $this->backup_dir;                   
      }
      
      /**
       * Get backup file
       * @param string $token
       * @return string
       */
      public function getBackupFile($token)
      {
          $file='backups'.DIRECTORY_SEPARATOR.$token.DIRECTORY_SEPARATOR.'backup-'.$token.'.tgz';
          return $file;
      }
      
      
      /**
       * Backup files
       * @param array $files
       * @return string token
       */
      public function doBackup($files)
      {
          
          $token=$this->getToken($files);
          $backup_dir=$this->getDir($token);              
          $backup_files_arch=array();
          
          foreach ($files as $file)
          {
              $from=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file;
              $tdir=$backup_dir;
              $to=$tdir.DIRECTORY_SEPARATOR.$file;
              $dirs=preg_split('/\//',dirname($file));
              foreach ($dirs as $d)
              {
                  $tdir.=DIRECTORY_SEPARATOR.$d;
                  // echo "tdir=$tdir $d <br>";
                  if (! is_dir($tdir))
                  {
                     if (! mkdir($tdir)) throw new Exception("Unable mkdir $tdir");
                  }
              }
              
              if (! copy($from,$to)) throw new Exception("Unable copy $from $to");
              $backup_files_arch[]=$from;
          }   
          
          // create report file in backup dir
          $this->createReport($files);
          
          $dest_package = $backup_dir.DIRECTORY_SEPARATOR.basename($this->getBackupFile($token));
          $compress = true;
          $arch_files = sfFinder::type('file')->name('*')->relative()->discard(basename($dest_package))->in($backup_dir);
          
          $cwd=getcwd();chdir($backup_dir);          
          $tar = new Archive_Tar($dest_package, $compress);
          $tar->create($arch_files);
          chdir($cwd);
          $this->saveLastBackupInformation($backup_files_arch,$token);
      
          return $this->getToken();
      }
      
      /**
       * Save last backup information 
       * @param array $files
       * @param strtong $token
       * @return true;
       */
      protected function saveLastBackupInformation($files,$token)
      {
          $path = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.last_backup.reg';
          $data=array("data"=>$files,"token"=>$token);
          if (! file_put_contents($path, serialize($data))) throw new Exception("Unable save backup information in ".$path);
          return true;
      }
      
      /**
       * Remove archived files
       */
      static public function cleanBackup()
      {
          $path = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.last_backup.reg';
          if (file_exists($path))
          {
              $data_raw=file_get_contents($path);
              $data=unserialize($data_raw);
              if (is_array($data))
              {
                  if ((isset($data['data'])) && (isset($data['token'])))
                  {
                      if (! empty($data['token'])) $token=$data['token']; else $token=NULL;
                      if (is_array($data['data']))
                      {
                          foreach ($data['data'] as $file)
                          {
                              if (file_exists($file))
                              {
                                  if (! unlink($file)) throw new Exception ("Unable delete file $file. Backup token: $token");
                              }
                          }
                      }
                  } else
                  {
                      throw new Exception("Wrong serialized data in $path. Undefined array keys 'data' or 'token'. Check backup. Token: $token");
                  }
              } else throw new Exception("Wrong serialized data in $path. Check backup. Token: $token");
          } 
          if (file_exists($path)) unlink ($path);
      }
}