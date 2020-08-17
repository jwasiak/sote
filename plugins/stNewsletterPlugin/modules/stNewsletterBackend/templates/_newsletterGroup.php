<ul class="sf_admin_checklist">
<?php if (isset($newsletter_message)): ?>
<?php foreach ($groups as $group): $id = $group->getId(); $users = $group->getCountUsers(); ?>
   <li><?php echo checkbox_tag('newsletter_message[newsletter_group]['.$id.']', $id, isset($checked[$id]), array('disabled' => $users == 0)); ?><?php echo label_for('newsletter_message[newsletter_group]['.$id.']', $group->getName().' ('.$users.')') ?></li>
<?php endforeach; ?>
<?php else: ?>
<?php foreach ($groups as $group): $id = $group->getId(); ?>
   <li><?php echo checkbox_tag('newsletter_user[newsletter_group]['.$id.']', $id, isset($checked[$id])); ?><?php echo label_for('newsletter_user[newsletter_group]['.$id.']', $group->getName()) ?></li>
<?php endforeach; ?>
<?php endif; ?>
</ul>
