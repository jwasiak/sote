<?php
/** 
 * SOTESHOP/stFrontend
 * 
 * Ten plik należy do aplikacji stFrontend opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stFrontend
 * @subpackage  helper
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stUsersOnlineHelper.php 6078 2010-07-06 13:42:51Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */  

/**
 * Get number of the on-line users.
 * @return int 
 * Modes: fast_cache_save & symfony 
 */
function st_get_online_users()
{  
    static $user_count = null;

    if (defined('ST_FAST_CACHE_SAVE_MODE') && (ST_FAST_CACHE_SAVE_MODE==1)) return stFastCacheCode::code('users_online');

    if (null === $user_count)
    {
        $root = defined('SF_ROOT_DIR') ? SF_ROOT_DIR : sfConfig::get('sf_root_dir');

        $file = $root.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'online_users.json';

        $refresh = 300;
        
        if (is_file($file)) 
        {
            $f = fopen($file, 'r+b');

            $data = fread($f, filesize($file));

            $users = json_decode($data, true);
        }
        else
        {
            $f = fopen($file, 'w+b');

            $users = array();
        }

        $current_time = time(); 

        $refresh_time = $current_time - $refresh;

        $session_id = session_id();

        if (preg_match('/chrome|firefox|msie|opera|mozilla|safari|konqueror/i', $_SERVER['HTTP_USER_AGENT']) && (!isset($users[$session_id]) || $refresh_time >= $users[$session_id]))
        {
            $users[$session_id] = $current_time;

            foreach ($users as $session_id => $time)
            {
                if ($refresh_time >= $time)
                {
                    unset($users[$session_id]);
                }
            }

            // blokujemy plik przed wielokrotnym zapisem
            if (flock($f, LOCK_EX | LOCK_NB))
            {
                rewind($f);
                ftruncate($f, 0);
                rewind($f);
                fwrite($f, json_encode($users));
                flock($f, LOCK_UN);
            }
        }

        fclose($f);

        $user_count = count($users);
    }

    return $user_count;
}

/**
 * Get show configuration
 * @return bool
 */
function st_show_online_users()
{
    return stConfig::getInstance('stUser')->get('show_users_online');
}