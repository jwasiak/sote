<?php if(!$sf_user->getGuardUser()->getIsSuperAdmin() || $sf_user->getGuardUser()->getId() == $sf_guard_user->getId()): ?>
<?php echo checkbox_tag('sf_guard_user[is_super_admin]', true, $sf_guard_user->getIsSuperAdmin(), array('disabled' => true)); ?>
<?php echo input_hidden_tag('sf_guard_user[is_super_admin]', $sf_guard_user->getIsSuperAdmin()) ?>
<?php else: ?>
<?php echo checkbox_tag('sf_guard_user[is_super_admin]', true, $sf_guard_user->getIsSuperAdmin()); ?>
<?php endif; ?>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
   $('#sf_guard_user_is_super_admin').change(function() {
      $('#group, #permission, #module_permission').attr('disabled', this.checked);
   });
});
//]]>   
</script>
