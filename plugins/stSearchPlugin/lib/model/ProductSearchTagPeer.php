<?php

/**
 * Subclass for performing query and update operations on the 'st_product_search_tag' table.
 *
 * 
 *
 * @package plugins.stSearchPlugin.lib.model
 */ 
class ProductSearchTagPeer extends BaseProductSearchTagPeer
{
    public static function doSelectIdsByTags($tags)
    {
        $c = new Criteria();
        $c->addSelectColumn(self::ID);
        
        $cnt = count($tags);

        if ($cnt > 1)
        {
            $c->add(self::TAG, $tags, Criteria::IN);         
        }
        elseif ($cnt == 1)
        {
            $c->add(self::TAG, $tags[0].'%', Criteria::LIKE);
        }    

        $rs = self::doSelectRs($c);
        $ids = array();
        while($rs->next())
        {
            $row = $rs->getRow();
            $ids[] = $row[0];
        }

        return $ids;
    }

    public static function doCountProduct(Criteria $c)
    {
        $c = clone $c;

        $con = Propel::getConnection($c->getDbName());

        $c->clearOrderByColumns();

        $c->addSelectColumn(ProductPeer::ID);

        $sql = BasePeer::createSqlQuery($c);

        $rs = $con->executeQuery('SELECT count(*) as cnt FROM ('.$sql.') as temp');

        return $rs->next() ? $rs->getInt('cnt') : 0;
    }    
}
