<?php
stPluginHelper::addRouting('stUserData', '/user_data/:action/*', 'stUserData', 'userPanel', 'frontend');
stPluginHelper::addRouting('stUser', '/user/:action/*', 'stUser', 'index', 'frontend');
stPluginHelper::addRouting('stConfirmForUser', '/user/emailConfirm/:user/:hash_code/:language', 'stUser', 'emailConfirm', 'frontend', array('confirm' => true));
stPluginHelper::addRouting('stConfirmDeleteForUser', '/user/deleteAccount/:user/:hash_code/:language', 'stUser', 'deleteAccount', 'frontend', array('confirm' => true));
stPluginHelper::addRouting('stChangePassForUser', '/user/createNewPassword/:hash_code', 'stUser', 'createNewPassword', 'frontend', array('confirm' => true));
stPluginHelper::addRouting('stGoToUser', '/user/edit/id/:user', 'stUser', 'edit', 'frontend');
stPluginHelper::addRouting('stGoToLogin', '/user/loginUser', 'stUser', 'loginUser', 'frontend');
