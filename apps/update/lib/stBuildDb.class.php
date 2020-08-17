<?php
/**
 * Build db progress bar
 * 
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */


/**
 * Build db
 */
class stBuildDb
{
	protected $msg = '';
	
    static public function getSteps()
    {
        return 4;
    }
    
    /**
	 * Build SQL from dump
	 */
	public function step($step)
    {
        
        if ($step==1)
        {
            // new server update config
            $pakeweb = new stPakeWeb();
            $pakeweb->run('setup-update');
        }
        
        if (($step==2) && (! $this->isLocked()))
        {            
            
            /*
            ---
            all: 
            propel: 
            class: sfPropelDatabase
            param: 
            phptype: mysql
            host: localhost
            database: database
            username: user
            encoding: utf8
            password: pass
            */

            // check dump
            $dump = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'soteshop.mysql';
            if (file_exists($dump))
            {
                $dump_sql = file_get_contents($dump);
                $this->sqlresult=$this->parseDump($dump_sql);                        
            } else throw new Exception("Dump SQL $dump not found");     

            $data=sfYaml::load(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'databases.yml');
            $this->dbHost = $data['all']['propel']['param']['host'];        
            $this->dbUsername = $data['all']['propel']['param']['username'];        
            $this->dbPassword = $data['all']['propel']['param']['password'];        
            $this->dbDatabase = $data['all']['propel']['param']['database'];        

            $this->dbError       = true;
            $this->reportMessage = '';
            $this->dbErrorMsg    = '';

            $con = mysql_connect($this->dbHost,$this->dbUsername, $this->dbPassword);
            if ($con && mysql_select_db($this->dbDatabase,$con))
            {         
                foreach ($this->sqlresult as $sql)
                {   
                    $res = mysql_query($sql, $con);
                    if ($res)
                    {
                        // ok
                    } else {
                        throw new Exception($sql." \n ".mysql_error());
                    }
                }
            } else {
                $this->dbErrorMsg = 'Nie można połączyć się z bazą danych, sprawdz dane i spróbuj ponownie.';
            }

            $this->dbError = false;
            $this->lockDB();
        }
        
        if ($step==3)
        {
            // new server update config
            $pakeweb = new stPakeWeb();
            $pakeweb->run('cc');
        }
	    
	    return $step+1;		
	}
	
	/**
	 * Lock builing db
	 * Protection for repeated build db request
	 */
	protected function lockDB()
	{
        $lockfile=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.dbdata.lck';
        if (! file_exists($lockfile))
        {
            touch($lockfile);
        }
        sleep(2);
	}
	
	/**
	 * Check if db building is locked
	 * @return bool true - locked, false not locked
	 */
	public static function isLocked()
	{
        $lockfile=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.dbdata.lck';
	    if (file_exists($lockfile)) return true;
	    else return false; 
	}
	
	
	
	/**
	 * Parse mysqldump file info mysql_quesry commands
	 * @param string $dump_sql raw sqldump: 
	 *    mysqldump --complete-insert --skip-add-drop-table --skip-add-locks --skip-comments --user soteshop --password= soteshop_pear2 > soteshop.mysql 
     * @return string sql from mysql_query     
	 */
	protected function parseDump($dump_sql)
	{
        $lines=preg_split("/\n/",$dump_sql);
        $sql='';$create=false;
        foreach ($lines as $line)
        {
           
            // /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            if (preg_match("/^\/\*\!/",$line))
            {
                preg_match("/^\/\*\![0-9]+\s{1}(.*)\*\/\;$/",$line,$matches);
                if (! empty($matches[1])) 
                {
                    $sql=$matches[1];
                    $allsql[]=$sql;
                }                
            } elseif (preg_match("/^CREATE TABLE/",$line))
            {            
                $sql=$line."\n";
                $create=true;
            } elseif ($create==true)
            {
                if (preg_match("/^\) ENGINE=MyISAM/",$line))
                {
                    $sql.=$line."\n";
                    $create=false;
                    $allsql[]=$sql;
                } else {
                    $sql.=$line."\n";
                }
            } else
            {
                $sql=$line;
                if ((! preg_match("/^[\s]+$/",$line)) && (! empty($line)))
                {
                    $allsql[]=$line;
                }
            }
        }
        
        // echo "<pre>";print_r($allsql);echo "</pre>";
        return $allsql;
	}
	
	
	public function close()
	{
	    sfLoader::loadHelpers('Tag');
		sfLoader::loadHelpers('Javascript');

		$this->msg.="<script type=\"text/javascript\">document.getElementById('stSetup-dbdata_actions').style.visibility=\"visible\";</script>";
	}
	
	/** 
    * Message. Step title.
    *
    * @return   string
    */
	public function getMessage()
	{                                   
		return $this->msg;        
	}
}

