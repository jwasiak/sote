<?php
if (version_compare($version_old, '1.2.0.1', '<='))
{
    try {
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
    
    //usuwanie kolumny desc z st_backend_alert_i18n
    $con = Propel::getConnection();
	$sql = "SHOW COLUMNS FROM `st_backend_alert_i18n` WHERE Field = 'desc'";
	$stmt = $con->PrepareStatement($sql);
    $rs = $stmt->executeQuery();
	if ($rs->next())  {
		if ($rs->getString('Field') == 'desc')
        {
            $sql = "ALTER TABLE `st_backend_alert_i18n` DROP `desc`";
        	$stmt = $con->PrepareStatement($sql);
            $rs = $stmt->executeQuery();
        }
    }
    $con = Propel::getConnection();
	$sql = "SHOW COLUMNS FROM `st_backend_alert_i18n` WHERE Field = 'description'";
	$stmt = $con->PrepareStatement($sql);
    $rs = $stmt->executeQuery();
	if (!$rs->next())  {
        $sql = "ALTER TABLE `st_backend_alert_i18n` ADD `description` TEXT NULL DEFAULT NULL";
    	$stmt = $con->PrepareStatement($sql);
        $rs = $stmt->executeQuery();
    }


    //usuwanie kolumny desc z st_backend_alert
    $con = Propel::getConnection();
	$sql = "SHOW COLUMNS FROM `st_backend_alert` WHERE Field = 'opt_desc'";
	$stmt = $con->PrepareStatement($sql);
    $rs = $stmt->executeQuery();
	if ($rs->next())  {
		if ($rs->getString('Field') == 'opt_desc')
        {
            $sql = "ALTER TABLE `st_backend_alert` DROP `opt_desc` ";
        	$stmt = $con->PrepareStatement($sql);
            $rs = $stmt->executeQuery();
        }
    }
    $con = Propel::getConnection();
	$sql = "SHOW COLUMNS FROM `st_backend_alert` WHERE Field = 'opt_description'";
	$stmt = $con->PrepareStatement($sql);
    $rs = $stmt->executeQuery();
	if (!$rs->next())  {
        $sql = "ALTER TABLE `st_backend_alert` ADD `opt_description` TEXT NULL DEFAULT NULL";
    	$stmt = $con->PrepareStatement($sql);
        $rs = $stmt->executeQuery();
    }
    } catch (Exception $e) {

    }
}
