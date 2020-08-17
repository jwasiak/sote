[?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?]
<?php $editActions = $this->getParameterValue('config.actions') ?>
<?php if (null !== $editActions): ?>
<?php foreach ((array) $editActions as $actionName => $params): ?>
  <?php if ($actionName == '_delete') continue ?>
  <?php if ($actionName == '_list' && !isset($params['action'])) $params['action'] = $this->getCustomActionNameCamelized('', 'List', 'list') ?>
  <?php echo $this->addCredentialCondition($this->getButtonToAction($actionName, $params, false), $params) ?>
<?php endforeach; ?>
<?php else: ?>
  <?php echo $this->getButtonToAction('_list', array('action' => $this->getCustomActionNameCamelized('', 'List', 'list')), false) ?>
  <?php echo $this->getButtonToAction('_save', array(), false) ?>
<?php endif; ?>

[?php echo st_get_admin_actions_foot() ?]
