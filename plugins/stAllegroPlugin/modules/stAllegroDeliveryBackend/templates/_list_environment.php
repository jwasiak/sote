<?php
$environments = stAllegroEnv::getEnvironments();
echo ($environments[$allegro_delivery->getEnvironment()]);