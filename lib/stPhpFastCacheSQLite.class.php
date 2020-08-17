<?php

class stPhpFastCacheSQLite
{
    /**
     *
     */
    const INDEXING_FILE = 'indexing';

    /**
     * @var int
     */
    public $max_size = 10; // 10 mb

    /**
     * @var array
     */
    public $instant = array();
    /**
     * @var null
     */
    public $indexing = null;
    /**
     * @var string
     */
    public $path = "";

    /**
     * @var int
     */
    public $currentDB = 1;


    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * INIT NEW DB
     * @param \PDO $db
     */
    public function initDB(PDO $db)
    {
        $db->exec('drop table if exists "caching"');
        $db->exec('CREATE TABLE "caching" ("id" INTEGER PRIMARY KEY AUTOINCREMENT, "keyword" VARCHAR UNIQUE, "data" BLOB, "exp" INTEGER)');
        $db->exec('CREATE UNIQUE INDEX "keyword" ON "caching" ("keyword")');
    }

    /**
     * INIT Indexing DB
     * @param \PDO $db
     */
    public function initIndexing(PDO $db)
    {
        $db->exec('drop table if exists "balancing"');
        $db->exec('CREATE TABLE "balancing" ("keyword" VARCHAR PRIMARY KEY NOT NULL UNIQUE, "db" INTEGER)');
        $db->exec('CREATE INDEX "db" ON "balancing" ("db")');
        $db->exec('CREATE UNIQUE INDEX "lookup" ON "balancing" ("keyword")');

    }

    /**
     * INIT Instant DB
     * Return Database of Keyword
     * @param $keyword
     * @return int
     */
    public function indexing($keyword)
    {
        if ($this->indexing == null) {
            $createTable = false;
            if (!file_exists($this->path . "/indexing")) {
                $createTable = true;
            }

            $PDO = new PDO("sqlite:" . $this->path . "/" . self::INDEXING_FILE);
            $PDO->setAttribute(PDO::ATTR_ERRMODE,
              PDO::ERRMODE_EXCEPTION);
            $PDO->exec('PRAGMA synchronous=FULL');
            $PDO->exec('PRAGMA count_changes=OFF');
            $PDO->exec('PRAGMA tmp_store=MEMORY');
            $PDO->exec('PRAGMA page_size=4096');

            if ($createTable == true) {
                $this->initIndexing($PDO);
            }
            $this->indexing = $PDO;
            unset($PDO);

            $stm = $this->indexing->prepare("SELECT MAX(`db`) as `db` FROM `balancing`");
            $stm->execute();
            $row = $stm->fetch(PDO::FETCH_ASSOC);
            if (!isset($row[ 'db' ])) {
                $db = 1;
            } elseif ($row[ 'db' ] <= 1) {
                $db = 1;
            } else {
                $db = $row[ 'db' ];
            }

            // check file size

            $size = file_exists($this->path . "/db" . $db) ? filesize($this->path . "/db" . $db) : 1;
            $size = round($size / 1024 / 1024, 1);


            if ($size > $this->max_size) {
                $db = $db + 1;
            }
            $this->currentDB = $db;

        }

        // look for keyword
        $stm = $this->indexing->prepare("SELECT * FROM `balancing` WHERE `keyword`=:keyword LIMIT 1");
        $stm->execute(array(
          ":keyword" => $keyword,
        ));
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        if (isset($row[ 'db' ]) && $row[ 'db' ] != "") {
            $db = $row[ 'db' ];
        } else {
            /*
             * Insert new to Indexing
             */
            $db = $this->currentDB;
            $stm = $this->indexing->prepare("INSERT INTO `balancing` (`keyword`,`db`) VALUES(:keyword, :db)");
            $stm->execute(array(
              ":keyword" => $keyword,
              ":db" => $db,
            ));
        }

        return $db;
    }

    /**
     * @param $keyword
     * @param bool $reset
     * @return mixed
     */
    public function db($keyword, $reset = false)
    {
        /**
         * Default is fastcache
         */
        $instant = $this->indexing($keyword);

        /**time
         * init instant
         */
        if (!isset($this->instant[ $instant ])) {
            // check DB Files ready or not
            $createTable = false;
            if (!file_exists($this->path . "/db" . $instant) || $reset == true) {
                $createTable = true;
            }
            $PDO = new PDO("sqlite:" . $this->path . "/db" . $instant);
            $PDO->setAttribute(PDO::ATTR_ERRMODE,
              PDO::ERRMODE_EXCEPTION);
            $PDO->exec('PRAGMA synchronous=OFF');
            $PDO->exec('PRAGMA journal_mode=MEMORY');
            $PDO->exec('PRAGMA count_changes=OFF');
            $PDO->exec('PRAGMA tmp_store=MEMORY');
            $PDO->exec('PRAGMA page_size=4096');
            

            if ($createTable == true) {
                $this->initDB($PDO);
            }

            $this->instant[ $instant ] = $PDO;
            unset($PDO);

        }

        return $this->instant[ $instant ];
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return bool
     */
    public function checkdriver()
    {
        if (extension_loaded('pdo_sqlite') && is_writeable($this->getPath())) {
            return true;
        }
        $this->fallback = true;
        return false;
    }


    /**
     * @param $keyword
     * @param string $value
     * @param int $time
     * @param array $option
     * @return bool
     */
    public function set($keyword, $value = "") {


            try {
                $stm = $this->db($keyword)
                  ->prepare("INSERT OR REPLACE INTO `caching` (`keyword`,`data`,`exp`) values(:keyword,:data,:exp)");
                $stm->execute(array(
                  ":keyword" => $keyword,
                  ":data" => $value,
                  ":exp" => time(),
                ));

                return true;
            } catch (PDOException $e) {

                try {
                    $stm = $this->db($keyword, true)
                      ->prepare("INSERT OR REPLACE INTO `caching` (`keyword`,`data`,`exp`) values(:keyword,:data,:exp)");
                    $stm->execute(array(
                      ":keyword" => $keyword,
                      ":data" => $value,
                      ":exp" => time(),
                    ));
                } catch (PDOException $e) {
                    return false;
                }
            }
        
        return false;
    }

    /**
     * @param $keyword
     * @param array $option
     * @return mixed|null
     */
    public function get($keyword, $expired = null)
    {
        try {
            $stm = $this->db($keyword)
              ->prepare("SELECT * FROM `caching` WHERE `keyword`=:keyword LIMIT 1");
            $stm->execute(array(
              ":keyword" => $keyword,
            ));
            $row = $stm->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            try {
                $stm = $this->db($keyword, true)
                  ->prepare("SELECT * FROM `caching` WHERE `keyword`=:keyword LIMIT 1");
                $stm->execute(array(
                  ":keyword" => $keyword,
                ));
                $row = $stm->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return null;
            }

        }

        if ($this->isExpired($row, $expired)) {
            return null;
        }

        if (isset($row[ 'id' ])) {
            return $row[ 'data' ];
        }

        return null;
    }

    /**
     * @param $row
     * @return bool
     */
    public function isExpired($row, $expired)
    {
        return $expired && time() >= $row[ 'exp' ] + $expired;
    }

    /**
     * @param $keyword
     * @param array $option
     * @return bool
     */
    public function delete($keyword)
    {
        try {
            $stm = $this->db($keyword)
              ->prepare("DELETE FROM `caching` WHERE (`keyword`=:keyword)");
            $stm->execute(array(
              ":keyword" => $keyword
            ));
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * @param array $option
     */
    public function clean($option = array())
    {

        // close connection
        $this->instant = array();
        $this->indexing = null;

        // delete everything before reset indexing
        $dir = opendir($this->path);
        while ($file = readdir($dir)) {
            if ($file != "." && $file != "..") {
                unlink($this->path . "/" . $file);
            }
        }
    }

    /**
     * @param $keyword
     * @return bool
     */
    public function has($keyword)
    {
        try {
            $stm = $this->db($keyword)
              ->prepare("SELECT COUNT(`id`) as `total` FROM `caching` WHERE `keyword`=:keyword");
            $stm->execute(array(
              ":keyword" => $keyword,
            ));
            $data = $stm->fetch(PDO::FETCH_ASSOC);
            if ($data[ 'total' ] >= 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
}
