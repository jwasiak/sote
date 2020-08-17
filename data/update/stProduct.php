<?php
try {
	if (version_compare($version_old, '1.0.11.5', '<='))
	{
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		//    $products = ProductPeer::doSelect(new Criteria());

		$con = Propel::getConnection();

		$con->executeQuery(sprintf('UPDATE %1$s SET %2$s = %3$s * (1 + (%4$s / 100))',
		ProductPeer::TABLE_NAME,
		ProductPeer::OPT_PRICE_BRUTTO,
		ProductPeer::PRICE,
		ProductPeer::OPT_VAT
		));

	}

	if (version_compare($version_old, '1.0.13.14', '<='))
	{
		$config_array=array(
    'only_gross'=>'only_gross_saved',
    'only_net'=>'only_net_saved',
    'gross_net'=>'gross_saved',
    'net_gross'=>'net_saved'
    );

    $context = sfContext::getInstance();
    $config = stConfig::getInstance($context, 'stProduct');
    foreach ($config_array as $wrong_value => $good_value)
    {
    	if ($config->get('saved_price_type')==$wrong_value)
    	{
    		$config->set('saved_price_type', $good_value);
    	}
    }
    sleep(2);
    $config->save();
    $config->load();

	}

	if (version_compare($version_old, '1.0.17.22', '<'))
	{

		$context = sfContext::getInstance();
		$config = stConfig::getInstance($context, 'stProduct');

		if ($config->get('show_producer'))
		{
			$config->set('show_producer', "name");
		}
		else
		{
			$config->set('show_producer', "none");
		}
		$config->save(true);
		$databaseManager = new sfDatabaseManager();

		$databaseManager->initialize();

		$con = Propel::getConnection();

		$sql = sprintf("UPDATE %s SET %s = %s", ProductPeer::TABLE_NAME, ProductPeer::OPT_ASSET_FOLDER, ProductPeer::CODE);

		$con->executeQuery($sql);
	}

    if (version_compare($version_old, '1.2.0.19', '<'))
    {
        $file = 'apps/backend/i18n/stProduct.en.xml';
        $checksum = 'a4348ff973cff984408550ef2735474f';

        if (md5_file(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file) == $checksum || !file_exists(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file)) {
            copy(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'stProduct'.DIRECTORY_SEPARATOR.'stProduct'.DIRECTORY_SEPARATOR.$file, sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file);
        }
    }
} catch (Exception $e) {}

try {
	if (version_compare($version_old, '7.2.0.0', '<=')) {
		$files = array(	'css/jGlideMenu.css',
						'css/jGlideMenuNotAbsolute.css',
						'img/ajax.gif',
						'img/arrow.gif',
						'img/arrow_dn.gif',
						'img/arrow_up.gif',
						'js/jQuery.jGlideMenu.067.js',
						'js/jQuery.jGlideMenu.067.min.js',
						'README.txt',
						'notes.txt',
						'css',
						'img',
						'js',
						'',
					);
		foreach ($files as $file) {
			$file = sfConfig::get('sf_web_dir').'/stGlideMenu/'.$file;
			if (file_exists($file))
                if (is_dir($file))
                    rmdir($file);
                else 
                    unlink($file);
		}
	}
} catch (Exception $e) {
	// @todo: log $e->getMessage();
}

if (version_compare($version_old, '7.2.1.33', '<'))
{
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        Propel::getConnection()->executeQuery('ALTER TABLE `st_product` DROP `opt_image_crop`');
    }
    catch (Exception $e) {}
}

if (version_compare($version_old, '7.2.1.67', '<'))
{
    $file = sfConfig::get('sf_root_dir').'/apps/backend/modules/stProduct/templates/_list_actions.php';

    if (is_file($file)) 
    {
        unlink($file);
    }
}

if (version_compare($version_old, '7.2.1.70', '<'))
{
    $databaseManager = new sfDatabaseManager();

    $databaseManager->initialize();
    
    try
    {
        $con = Propel::getConnection();

        $sql = sprintf('UPDATE %1$s SET %2$s = %3$d WHERE %2$s = 1', ProductPeer::TABLE_NAME, ProductPeer::STOCK_IN_DECIMALS, 2);

        $con->executeQuery($sql);
    }
    catch (Exception $e) {}
}


