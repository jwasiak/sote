<?php

/** 
 * SOTESHOP/stProductOptionsPlugin
 * Ten plik należy do aplikacji stProductOptionsPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stProductOptionsPlugin
 * @subpackage  libs
 */
class ProductOptionsFieldPeer extends BaseProductOptionsFieldPeer
{
	/**
	 * Method perform an INSERT on the database, given a ProductOptionsField or Criteria object.
	 *
	 * @param      mixed $values Criteria or ProductOptionsField object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseProductOptionsFieldPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseProductOptionsFieldPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
			$criteria->remove(ProductOptionsFieldPeer::ID);
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from ProductOptionsField object
			if (!$values->isColumnModified(ProductOptionsFieldPeer::ID)) {
				$criteria->remove(ProductOptionsFieldPeer::ID); // remove pkey col since this table uses auto-increment
			}
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			// use transaction because $criteria could contain info
			// for more than one table (I guess, conceivably)
			$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseProductOptionsFieldPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseProductOptionsFieldPeer', $values, $con, $pk);
    }

    return $pk;
	}
}