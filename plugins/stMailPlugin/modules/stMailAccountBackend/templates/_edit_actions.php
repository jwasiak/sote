<?php $result = ((MailSmtpProfilePeer::doCount(new Criteria())) <= 0); ?>
<?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
    <?php echo st_get_admin_action('list', __('Lista', null, 'stAdminGeneratorPlugin'), 'stMailAccountBackend/list?id='.$mail_account->getId(), array ()) ?>
    <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array ('name' => 'save', 'disabled' => $result)) ?>
    <?php echo st_get_admin_action('save_and_add', __('Zapisz i dodaj', null, 'stAdminGeneratorPlugin'), null, array ('name' => 'save_and_add', 'disabled' => $result)) ?>
<?php echo st_get_admin_actions_foot() ?>