<?php

class stProductOptionsStockFix
{
    protected static $dbm = null;

    public function executeUpdate($offset)
    {
        self::initDatabase();

        $offset = self::execute($offset);

        self::shutdownDatabase();

        return $offset;
    }

    public function execute($offset)
    {
        $c = new Criteria();

        $c->addSelectColumn(ProductPeer::ID);

        $c->setLimit(100);

        $c->setOffset($offset);

        $rs = ProductPeer::doSelectRs($c);

        $ids = array();

        while($rs->next())
        {
            $row = $rs->getRow();

            $ids[] = $row[0]; 
        }

        $con = Propel::getConnection();
        $con->executeQuery(sprintf("UPDATE st_product_options_value v LEFT JOIN st_product_options_value c ON c.LFT BETWEEN v.LFT AND v.RGT AND c.product_id = v.product_id AND c.RGT - c.LFT = 1 AND c.stock > 0 SET v.stock = IFNULL(c.stock, 0) WHERE v.product_id IN (%s)",
                implode(',', $ids)));

        usleep(500000);

        return $offset + count($ids);
    }

    public static function count()
    {
        return ProductPeer::doCount(new Criteria());
    }

    public static function initDatabase()
    {
        self::$dbm = new sfDatabaseManager();

        self::$dbm->initialize();      
    }

    public static function shutdownDatabase()
    {
        self::$dbm->shutdown();
    }    
}