<?php

if (version_compare($version_old, '7.5.0.6', '<='))
{
    if (floatval(phpversion()) < 7)
    {
        unlink(sfConfig::get('sf_root_dir'). '/data/.php7switch');
    }
}