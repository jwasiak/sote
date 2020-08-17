<?php
/**
 * SOTESHOP/stProduct
 *
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProduct
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProductHelper.php 2416 2009-12-02 12:17:02Z marcin $
 */

/**
 * Zwraca właściwy link do list produktu
 *
 */
function st_search_link_to($name, $action, $for_link, $custom_params = array(), $params = array()) {
    $tmp = array_merge($for_link,$custom_params);
    $params['rel'] = 'nofollow';
    return st_link_to($name, array_merge($tmp, array('action'=>'search', 'module'=>'stSearchFrontend')), $params);
}