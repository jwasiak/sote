<?php
stPluginHelper::addEnableModule('stIe', 'backend');

stPluginHelper::addRouting('stIe','/stIe/:action/*','stIe','index','backend');