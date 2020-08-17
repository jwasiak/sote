<?php

class stSecureToken
{
    public static function generate($parameters)
    {
        $shop_hash = stConfig::getInstance('stRegister')->get('shop_hash');

        return sha1(serialize(self::stringify($parameters)).$shop_hash);
    }

    private static function stringify($parameters)
    {
        $results = array();

        foreach ($parameters as $k => $v)
        {
            if (is_array($v))
            {
                $results[(string)$k] = self::stringify($v);
            }
            else
            {
                $results[(string)$k] = (string)$v;
            }
        }

        return $results;
    }
}