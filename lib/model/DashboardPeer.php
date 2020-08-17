<?php

/**
 * Subclass for performing query and update operations on the 'st_dashboard' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DashboardPeer extends BaseDashboardPeer
{
	public static function doSelectByUserId($user_id)
	{
		$c = new Criteria();

		$c->add(self::SF_GUARD_USER_ID, $user_id);

		return self::doSelectOrdered($c);
	}

	public static function doSelectOrdered(Criteria $c = null)
	{
		$c = $c ? clone $c : new Criteria();

		$c->addAscendingOrderByColumn(self::ID);

		return DashboardPeer::doSelect($c);
	}

    public static function doRefreshById($id)
    {
        $select = new Criteria();

        $select->add(self::ID, $id);

        $update = new Criteria();

        $update->add(self::UPDATED_AT, time());

        $con = Propel::getConnection();

        BasePeer::doUpdate($select, $update, $con);
    }

    public static function doRefreshAll()
    {
        $con = Propel::getConnection();

        $ps = $con->prepareStatement(sprintf("UPDATE %s SET %s = ?", self::TABLE_NAME, self::UPDATED_AT));

        $ps->setInt(1, time());

        $ps->executeQuery();
    }
}
