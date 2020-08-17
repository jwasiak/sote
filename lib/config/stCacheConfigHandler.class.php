<?php
/**
 * SOTESHOP/stBase
 *
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBase
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stCacheConfigHandler.class.php 4475 2010-04-12 08:35:08Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Rozszerzenie cache o możliwość definiowania dołączanych dynamicznie plików CSS/JS
 *
 * @package     stBase
 * @subpackage  libs
 */
class stCacheConfigHandler extends sfCacheConfigHandler
{
    /**
     * Returns a single addCache statement.
     *
     * @param string The action name
     *
     * @return string PHP code for the addCache statement
     */
    protected function addCache($actionName = '')
    {
        $data = array();

        // enabled?
        $enabled = $this->getConfigValue('enabled', $actionName);

        // cache with or without loayout
        $withLayout = $this->getConfigValue('with_layout', $actionName) ? 'true' : 'false';

        // lifetime
        $lifeTime = !$enabled ? '0' : $this->getConfigValue('lifetime', $actionName, '0');

        // client_lifetime
        $clientLifetime = !$enabled ? '0' : $this->getConfigValue('client_lifetime', $actionName, $lifeTime, '0');

        // contextual
        $contextual = $this->getConfigValue('contextual', $actionName) ? 'true' : 'false';

        // vary
        $vary = $this->getConfigValue('vary', $actionName, array());
        if (!is_array($vary))
        {
            $vary = array($vary);
        }

        $view = $this->getAssets($actionName);

        // add cache information to cache manager
        $data[] = sprintf("\$this->addCache(\$moduleName, '%s', array('withLayout' => %s, 'lifeTime' => %s, 'clientLifeTime' => %s, 'contextual' => %s, 'vary' => %s, 'enabled' => %s, 'view' => %s));\n",
                $actionName, $withLayout, $lifeTime, $clientLifetime, $contextual, str_replace("\n", '', var_export($vary, true)), $enabled ? 'true' : 'false', var_export($view, true));

        return implode("\n", $data);
    }

    protected function getAssets($actionName = '')
    {
        $view = array();

        $stylesheets = $this->getAsset('stylesheets', $actionName);

        $view['stylesheets'] = $this->compileAssets($stylesheets);

        $javascripts = $this->getAsset('javascripts', $actionName);

        $view['javascripts'] = $this->compileAssets($javascripts);

        return $view;
    }

    /**
     * Zwróć listę js/css w zależności od akcji
     *
     * @param                 $asset      Nazwa               zasobu
     * @param                 $actionName Nazwa               akcji
     * @return   array
     */
    protected function getAsset($asset, $actionName = '')
    {
        $view = $this->getConfigValue('view', $actionName, array());

        return isset($view[$asset]) ? $view[$asset] : array();
    }

    protected function compileAssets($assets)
    {
        $data = array();

        foreach ($assets as $asset)
        {
            if (is_array($asset))
            {
                $filename = key($asset);

                $data[] = array(
                    'filename' => $filename, 
                    'position' => isset($asset[$filename]['position']) ? $asset[$filename]['position'] : '', 
                    'max_theme_version' => isset($asset[$filename]['max_theme_version']) ? $asset[$filename]['max_theme_version'] : '');
            }
            else
            {
                $data[] = array('filename' => $asset, 'position' => '', 'max_theme_version' => '');
            }
        }

        return $data;
    }
}