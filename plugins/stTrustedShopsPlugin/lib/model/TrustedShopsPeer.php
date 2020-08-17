<?php

class TrustedShopsPeer extends BaseTrustedShopsPeer {

	protected static $culture = null;
	
	public static function retrieveByCulture($culture) {

	    if (is_null(self::$culture)) {
	        $stCache = new stFunctionCache('stTrustedShopsPlugin');
	
	        if ($culture == 'pl_PL') $language = 'pl';
	        elseif ($culture == 'en_US') $language = 'en';
	        else $language = $culture;
	
	        $c = new Criteria();
	        $c->add(self::LANGUAGE, $language);
	        self::$culture = $stCache->add('domainAndCulture_'.$culture, "TrustedShopsPeer::doSelectOne", $c);
	    }

	    return self::$culture;
	}

	public static function doSelectRating() {
		$c = new Criteria();
		$c->add(self::STATUS, 'INVALID_TS_ID');
		$c->add(self::RATING_STATUS, 1);
		$c->setLimit(1);
		$r = self::doSelect($c);
		if(isset($r[0])) return $r[0];
		return null;
	}
}
