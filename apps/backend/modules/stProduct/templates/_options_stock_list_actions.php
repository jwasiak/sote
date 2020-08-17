<?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
<?php echo st_get_admin_action('list', __('Pokaż listę', null, 'stAdminGeneratorPlugin'), 'stProduct/depositoryList', array("link_to" => "stProduct/depositoryList","name" => "list",)) ?>
<?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('class' => 'update-list-form', 'id' => 'update-list-form')) ?>
<?php echo st_get_admin_actions_foot() ?>