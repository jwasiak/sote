<?php

include_once 'addon/propel/builder/SfMapBuilderBuilder.php';

class SfOptimizedMapBuilderBuilder extends SfMapBuilderBuilder
{
    protected function addDoBuild(&$script)
    {
        parent::addDoBuild($script);

        // $script = preg_replace("/\\\$tMap\->addColumn\('([^']+)', '([^']+)', '([^']+)', CreoleTypes\:\:DECIMAL, (false|true), ([0-9]+,[0-9]+)\)/e", '"\\\$tMap->addColumn(\'$1\', \'$2\', \'$3\', CreoleTypes::DECIMAL, $4, null)"', $script);
    }
}
