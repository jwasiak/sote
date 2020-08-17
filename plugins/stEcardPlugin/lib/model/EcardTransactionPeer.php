<?php

/**
 * Subclass for performing query and update operations on the 'st_ecard_transaction' table.
 *
 * 
 *
 * @package plugins.stEcardPlugin.lib.model
 */ 
class EcardTransactionPeer extends BaseEcardTransactionPeer
{
    public static function doInsert($values, $con = null)
    {

        foreach (sfMixer::getCallables('BaseEcardTransactionPeer:doInsert:pre') as $callable)
        {
            $ret = call_user_func($callable, 'BaseEcardTransactionPeer', $values, $con);
            if (false !== $ret)
            {
                return $ret;
            }
        }


        if ($con === null) {
            $con = Propel::getConnection(self::DATABASE_NAME);
        }

        if ($values instanceof Criteria) 
        {
            $criteria = clone $values;      
        } 
        else 
        {
            $criteria = $values->buildCriteria();       
        }

        $criteria->setDbName(self::DATABASE_NAME);

        try 
        {
            $con->begin();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } 
        catch(PropelException $e) 
        {
            $con->rollback();
            throw $e;
        }


        foreach (sfMixer::getCallables('BaseEcardTransactionPeer:doInsert:post') as $callable)
        {
            call_user_func($callable, 'BaseEcardTransactionPeer', $values, $con, $pk);
        }

        return $pk;
    }
}
