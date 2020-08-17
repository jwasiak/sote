<?php if(!$sf_user->getGuardUser()->getIsSuperAdmin() || $sf_user->getGuardUser()->getId() == $sf_guard_user->getId()): ?>
<?php echo checkbox_tag('sf_guard_user[is_active]', true, $sf_guard_user->getIsActive(), array('disabled' => true)); ?>
<?php echo input_hidden_tag('sf_guard_user[is_active]', $sf_guard_user->getIsActive()) ?>
<?php else: ?>
<?php echo checkbox_tag('sf_guard_user[is_active]', true, $sf_guard_user->getIsActive()); ?>
<?php endif; ?>