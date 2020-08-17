<?php

/** 
 * Subclass for performing query and update operations on the 'st_user_data' table.
 *
 * @package     stUser
 * @subpackage  libs
 */
class UserDataPeer extends BaseUserDataPeer
{
    /** 
     * Zwraca ilość zarejestrowanych klientów w sklepie
     *
     * @return   $c
     */
    public static function getUsersByTime()
    {
        $c = new Criteria();
        $c->add(UserDataPeer::IS_BILLING, 1);
        return $c;
    }



}