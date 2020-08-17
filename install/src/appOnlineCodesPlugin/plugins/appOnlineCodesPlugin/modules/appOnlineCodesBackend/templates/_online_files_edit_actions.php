<?php 
echo st_get_admin_actions_head('style = "margin-top: 10px; float: right"');
    echo st_get_admin_action('list', __('Lista', null, 'stAdminGeneratorPlugin'), 'appOnlineCodesBackend/onlineFilesList', array ('name' => 'list'));
    if ($online_files->isNew()) echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array ('name' => 'save'));
echo st_get_admin_actions_foot();