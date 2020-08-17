<?php
/** 
 * SOTESHOP/stUpdate 
 * 
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE. 
 * Do not modify this file, system will overwrite it during upgrade.
 * 
 * @package     stUpdate
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: stToken.php 3160 2010-01-26 13:30:27Z marek $
 */

/** 
 * Directory with tickets.
 */
if (!defined("INSTALL_CACHE_PATH")) define("INSTALL_CACHE_PATH", dirname(dirname(dirname(dirname(__FILE__)))).DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'cache');

/** 
 * Error message. Unable create ticket.
 */
if (!defined("CREATE_ERROR")) define("CREATE_ERROR", "Nie można utworzyć pliku ticketa");


/** 
 * Create hash.
 *
 * @return   string
 */
function makeHash() {
    $mt = microtime();
    return md5($mt.rand(-2147483647,2147483647));
}

/** 
 * Create ticket file. Return file name.
 *
 * @return   string
 * @throws CREATE_ERROR
 */
function createToken() {

    // if hash is duplicated create new hash
    $filename = makeHash();
    while (file_exists(INSTALL_CACHE_PATH.DIRECTORY_SEPARATOR.$filename)){
        $filename = makeHash();
    }

    // create new ticket file
    if (!touch(INSTALL_CACHE_PATH.DIRECTORY_SEPARATOR.$filename)) {
        throw new Exception(CREATE_ERROR,1);
    }else {
        file_put_contents(INSTALL_CACHE_PATH.DIRECTORY_SEPARATOR.$filename,md5($filename));
    }

    // return ticket
    return $filename;
}

/** 
 * Check if ticket exists.
 *
 * @param        string      $ticket
 * @param       boolean     $unlink
 * @return   boolean
 */
function checkToken($ticket, $unlink = true) {

    $filename = INSTALL_CACHE_PATH.DIRECTORY_SEPARATOR.$ticket;

    if(file_exists($filename) && is_readable($filename)) {
        $content = file_get_contents($filename);
        // check ticket content
        if ($content == md5($ticket)) {
            if ($unlink) { return unlink($filename); }
        }
    }
    return false;
}
