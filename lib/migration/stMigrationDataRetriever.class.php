<?php
/** 
 * SOTESHOP/stMigration 
 * 
 * Ten plik należy do aplikacji stMigration opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *  
 * @package     stMigration
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stMigrationDataRetriever.class.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 * Klasa odpowiadająca za pobieranie danych dla aplikacji stMigration
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigration
 * @subpackage  libs
 */
class stMigrationDataRetriever
{
    /**
     * Nazwa dla połączenia z bazą danych
     * 
     * @var const
     */
    const DATABASE_CONNECTION = 'migration';
    
    /**
     * Limit pobieranych rekordów z tabeli
     * 
     * @var int
     */
    const TABLE_RECORD_LIMIT = 100;
    
    /** 
     * Instancja obiektu stMigrationDataRetriever
     * 
     * @var stMigrationDataRetriever
     */
    protected static $instance = null;
    
    /**
     * Połączenie z bazą danych
     * 
     * @var Connection
     */
    protected $databaseConnection = null;
    
    /**
     * Parametry połączenia z bazą danych
     * 
     * @var array
     */
    protected $databaseConnectionPatams = array();
    
    /** 
     * Zwraca instancje obiektu
     *
     * @param array $params Parametry połączenia z bazą danych (format: 'nazwa_parametru' => 'wartosc')
     * @return stMigrationDataRetriever
     */
    public static function getInstance($params = array())
    {
        if (!isset(self::$instance))
        {
            $class = __CLASS__;
            
            self::$instance = new $class();
            self::$instance->initialize($params);
        }
        
        return self::$instance;
    }
    
    /**
     * Ustawia parametry dla połączenia z bazą danych
     * 
     * @param array $params Parametry połączenia z bazą danych (format: 'nazwa_parametru' => 'wartosc')
     * @return stMigrationDataRetriever
     */
    public function initialize($params)
    {
        $this->databaseConnectionParams = $params;
        
        return $this;
    }
    
    /**
     * Zwraca połączenie z bazą danych
     * 
     * @return Connection
     */
    public function getDatabaseConnection()
    {
        if (is_null($this->databaseConnection))
        {
	        $database = new sfPropelDatabase();
	        
	        $database->initialize(array(
		        'phptype' => version_compare(phpversion(), '7.0.0', '<') ? 'mysql' : 'mysqli',
		        'host' => $this->databaseConnectionParams['host'], 
		        'database' => $this->databaseConnectionParams['database'], 
		        'username' => $this->databaseConnectionParams['username'], 
		        'encoding' => 'utf8', 
		        'password' => $this->databaseConnectionParams['password']
	        ), self::DATABASE_CONNECTION);
	       
	        $this->databaseConnection = $database->getConnection();
        }
        
        return $this->databaseConnection;
    }
    

    /**
     * Zwraca obiekt PreparedStatement
     * 
     * @param string $sql Zapytanie SQL 
     * @return PreparedStatement
     */
    public function prepareStatement($sql)
    {
        $stmt = $this->getDatabaseConnection()->prepareStatement($sql);
        
        $stmt->setLimit(self::TABLE_RECORD_LIMIT);
        
        return $stmt;
    }
    
    public function executeQuery($sql, $fetchmode = null)
    {
       return $this->getDatabaseConnection()->executeQuery($sql, $fetchmode);
    }
    
    public function countAllRecords($sql)
    {
       $sql = preg_replace('/SELECT (.*?) FROM/', 'SELECT COUNT(*) AS cnt FROM', $sql);
       
       $stmt = $this->getDatabaseConnection()->prepareStatement($sql);
       
       $rs = $stmt->executeQuery();
       
       $rs->next();
       
       return $rs->getInt('cnt');   
    }
}
?>