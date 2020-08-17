<div id="edit_actions">
    <?php echo st_get_admin_actions_head(array('style' => 'float: right')) ?>            
    <?php echo st_get_admin_action('save', __('Zapisz'), null, array('name' => 'save')) ?> 
    <?php echo st_get_admin_actions_foot() ?>
</div>

<script type="text/javascript">
jQuery(function($) {
    $('#edit_actions').stickyBox();
});
</script>    