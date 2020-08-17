<?php

stPluginHelper::addEnableModule('sfCaptchaGD', 'frontend');
stPluginHelper::addRouting('stcaptchaGDPlugin', '/captcha', 'sfCaptchaGD', 'GetImage', 'frontend');

stPluginHelper::addEnableModule('sfCaptchaGD', 'backend');
stPluginHelper::addRouting('stcaptchaGDPlugin', '/captcha', 'sfCaptchaGD', 'GetImage', 'backend');