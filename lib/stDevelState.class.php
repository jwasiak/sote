<?php
/**
 * @package    stUpdate
 * @subpackage lib
 * @author     Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * Optimizastion pear state class for backend and frontend.
 */
class stDevelState
{
    /**
     * Check if beta state is set
     * stDevelState::isBeta()
     * @see Function apps/update/modules/stInstallerWeb/actions/actions.class.php executePearState()
     * @return bool true - beta, false - stable
     */
    static public function isBeta()
    {
        $pearrc = file(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'.pearrc');
        if (isset($pearrc[1]))
        {
            $config = unserialize($pearrc[1]);
            if (isset($config['__channels']['pear.sote.pl']['preferred_state']) && $config['__channels']['pear.sote.pl']['preferred_state'] == 'beta')
            {
                return true;
            }
        }
        return false;
    }
}