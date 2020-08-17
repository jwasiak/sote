<?php $editActions = $this->getParameterValue('edit.actions') ?>
[?php echo st_get_admin_actions_head('style="float: left"') ?]
<?php if (null === $editActions || (null !== $editActions && array_key_exists('_delete', $editActions))): ?>
[?php if (method_exists($<?php echo $this->getSingularName() ?>, 'getIsSystemDefault') == false || (method_exists($<?php echo $this->getSingularName() ?>, 'getIsSystemDefault') && !$<?php echo $this->getSingularName() ?>->getIsSystemDefault())): ?]
	<?php if (!isset($editActions['_delete']['action'])) $editActions['_delete']['action'] = $this->getCustomActionNameCamelized('', 'Delete', 'delete') ?>
	<?php echo $this->addCredentialCondition($this->getButtonToAction('_delete', $editActions['_delete'], true), $editActions['_delete']) ?>
[?php endif; ?]
<?php endif; ?>
</ul>

[?php echo st_get_admin_actions_head('style="float: right"') ?]

<?php if (null !== $editActions): ?>
<?php foreach ((array) $editActions as $actionName => $params): ?>
  <?php if ($actionName == '_delete') continue ?>
  <?php if ($actionName == '_list' && !isset($params['action'])) $params['action'] = $this->getCustomActionNameCamelized('', 'List', 'list') ?>
  <?php echo $this->addCredentialCondition($this->getButtonToAction($actionName, $params, $actionName == '_list' ? false : true), $params) ?>
<?php endforeach; ?>
<?php else: ?>
  <?php echo $this->getButtonToAction('_list', array('action' => $this->getCustomActionNameCamelized('', 'List', 'list')), false) ?>
  <?php echo $this->getButtonToAction('_save', array(), true) ?>
  <?php echo $this->getButtonToAction('_save_and_add', array(), true) ?>
<?php endif; ?>
[?php echo st_get_admin_actions_foot() ?]