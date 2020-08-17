<?php
/**
 * SOTESHOP/stCurrencyPlugin
 *
 * Ten plik należy do aplikacji stCurrencyPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCurrencyPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: CurrencyPeer.php 10414 2011-01-21 11:49:57Z michal $
 * @author      Marcin Olejnczak <marcin.olejniczak@sote.pl>
 */

/**
 * Klasa CurrencyPeer
 *
 * @package     stCurrencyPlugin
 * @subpackage  libs
 */
class CurrencyPeer extends BaseCurrencyPeer
{
    protected static $currencies = null;

    protected static $activeCurrencies = null;

    protected static $main = null;

    public static function retrieveMain()
    {
        if (null === self::$main)
        {
            foreach (self::doSelectActive() as $currency) 
            {
                if ($currency->getMain())
                {
                    self::$main = $currency;
                    break;
                }
            }
        }

        return self::$main;
    }

    public static function retrieveByPKCached($id)
    {
        foreach (self::doSelectActive() as $currency)
        {
            if ($currency->getId() == $id)
            {
                return $currency;
            }
        }

        return null;
    }

	public static function doSelectCached()
	{
        if (null === self::$currencies)
        {
    		$c = new Criteria();
    		$fc = new stFunctionCache('stCurrency');
    		self::$currencies = $fc->cacheCall(array('CurrencyPeer', 'doSelect'), array($c));
        }

        return self::$currencies;
	}

    public static function doSelectActive()
    {
        if (null === self::$activeCurrencies)
        {
            $currencies = array();

            foreach (self::doSelectCached() as $currency)
            {
                if ($currency->getActive())
                {
                    $currencies[] = $currency;
                }
            }

            self::$activeCurrencies = $currencies;
        }

        return self::$activeCurrencies;
    }

	/**
	 * Wybór aktywnej waluty
	 *
	 * @param      Criteria    $c
	 * @param     $con
	 * @return   object
	 */
	public static function doSelectActiveOne(Criteria $c, $con = null)
	{
		$c = clone $c;
        $c->add(CurrencyPeer::ACTIVE, true);
        $c->setLimit(1);
		$currencies = self::doSelect($c, $con);

		return $currencies ? $currencies[0] : null;
	}

	public static function doSelectSystemDefault(Criteria $c, $con = null)
	{
		$c = clone $c;

		$config = stConfig::getInstance(null, 'stCurrencyPlugin');

		$c->add(self::SHORTCUT, $config->get('default_currency'));

		return self::doSelectOne($c);
	}

	/**
	 * Zwraca walutę po jej kodzie ISO
	 *
	 * @param string $shortcut
	 * @return Currency|null
	 */
	public static function retrieveByIso($iso)
	{
		$currencies = self::doSelectCached();

		foreach ($currencies as $currency)
		{
			if ($currency->getShortcut() == $iso)
			{
				return $currency;
			}
		}

		return null;
	}

	public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
	{
		if ($culture === null)
		{
			$culture = stLanguage::getHydrateCulture();
		}

		return parent::doSelectWithI18n($c, $culture, $con);
	}

	public static function doCountWithI18n(Criteria $c, $con = null)
	{
		$c->addJoin(CurrencyI18nPeer::ID, CurrencyPeer::ID);

		$c->add(CurrencyI18nPeer::CULTURE, stLanguage::getHydrateCulture());

		return self::doCount($c, $con);
	}
}
