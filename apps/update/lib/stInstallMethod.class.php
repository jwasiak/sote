<?php
/**
 * Install method recognition
 *
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
 
/**
 * Install method
 */
class stInstallMethod
{
    public static function getWebInstall()
    {
        ///install/src/.registry/.channel.pear.sote.pl
        $reg_file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.webinstall';
        if (file_exists($reg_file))
        {
            return true;
        } else return false;
    }
}