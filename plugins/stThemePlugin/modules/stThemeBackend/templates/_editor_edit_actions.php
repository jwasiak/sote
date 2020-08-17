<div id="edit_actions">
    <?php if ($theme_config->hasType($type)): ?>
      <?php echo st_get_admin_actions_head(array('style' => 'float: left; margin-right: 5px')) ?>
      <?php echo st_get_admin_action('reset', __('Przywróć domyślną konfigurację'), 'stThemeBackend/restore?id='.$theme_config->getId().'&type='.$type, array('name' => 'restore', 'confirm' => __('Chcesz przywrocić domyślną konfigurację. Jesteś pewien?'))) ?>
      </ul>  
    <?php endif; ?>
    <?php echo st_get_admin_actions_head(array('style' => 'float: right')) ?>          
    <?php echo st_get_admin_action('save', __('Zapisz'), null, array('name' => 'save')) ?> 
    <?php echo st_get_admin_action('view', __('Podgląd'), null, array('name' => 'preview_save')) ?>    
    <?php echo st_get_admin_action('save', __('Zapisz i zastosuj'), null, array('name' => 'save_and_apply', 'confirm' => __('Twoje zmiany będą widoczne na stronie sklepu. Jesteś pewien?'))) ?> 
    <?php echo st_get_admin_actions_foot() ?>
</div>

<script type="text/javascript">
jQuery(function($) {
    $('#edit_actions').stickyBox();
});
</script>    