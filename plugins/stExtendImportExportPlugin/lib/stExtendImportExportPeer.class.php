<?php

class stExtendImportExportPeer extends ProductPeer
{
	protected static $languageVersions = null;

	public static function doSelect(Criteria $c, $con = null)
	{
		$c = clone $c;

		$versions = self::getLanguageVersions();

		$c->setOffset($c->getOffset() / count($versions));

		$products = ProductPeer::doSelect($c);

		unset($versions[stLanguage::getOptLanguage()]);

		$results = array();

		foreach ($products as $product) 
		{
			$results[] = clone $product;

			foreach ($versions as $version)
			{
				$product->setCulture($version);

				$results[] = clone $product;
			}		
		}

		return $results;
	}

	public static function doCount(Criteria $c, $distinct = false, $con = null)
	{
		$c = clone $c;

		$versions = self::getLanguageVersions();

		$count = ProductPeer::doCount($c) * count($versions);

		return $count;
	}

	public static function getLanguageVersions()
	{
		if (null === self::$languageVersions)
		{
			$c = new Criteria();

			$c->addSelectColumn(LanguagePeer::LANGUAGE);

			$rs = LanguagePeer::doSelectRs($c);

			$versions = array();

			while($rs->next())
			{
				$row = $rs->getRow();

				$versions[$row[0]] = $row[0];
			}

			self::$languageVersions = $versions;
		}

		return self::$languageVersions;
	}
}