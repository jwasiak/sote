<?php echo st_get_admin_actions_head() ?>
   <?php if (ThemePeer::doSelectActive()->getIsSystemDefault(false)): ?>
      <?php echo st_get_admin_action('save', __('Przywróć domyślne'), '@stAssetImageConfiguration?action=restoreDefaults&for='.(is_array($for) ? implode(',', $for) : $for), array('confirm' => __('Jesteś pewien?', null, 'stAdminGeneratorPlugin'))) ?>
   <?php endif ?>
   <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array ('name' => 'save')) ?>
<?php echo st_get_admin_actions_foot() ?>