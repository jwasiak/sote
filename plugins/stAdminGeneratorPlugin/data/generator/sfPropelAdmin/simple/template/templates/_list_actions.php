<?php if ($this->getParameterValue('list.editable')): ?>
[?php echo st_get_admin_actions_head('style="margin-top: 10px; float: left"') ?]
[?php if ($sf_user->getAttribute('<?php echo $this->getCustomActionNameCamelized('', 'List', 'list')?>.mode', null, 'soteshop/stAdminGenerator/<?php echo $this->getModuleName() ?>/config') == 'edit' && $pager->getNbResults() > 0): ?]
[?php echo st_get_admin_action('list', __('Tryb przegladania', null, 'stAdminGeneratorPlugin'), '<?php echo $this->getModuleName() ?>/setConfiguration?for_action=<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?>&params[mode]=list&page='.$pager->getPage()) ?]
[?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('id' => 'update-list-form')) ?]
[?php elseif ($pager->getNbResults() > 0): ?]
[?php echo st_get_admin_action('edit', __('Tryb edycji', null, 'stAdminGeneratorPlugin'), '<?php echo $this->getModuleName() ?>/setConfiguration?for_action=<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?>&params[mode]=edit&page='.$pager->getPage()) ?]
[?php endif; ?]
</ul>
<?php endif; ?>
[?php echo st_get_admin_actions_head('style="margin-top: 10px;"') ?]
<?php $listActions = $this->getParameterValue('list.actions') ?>
<?php if (null !== $listActions): ?>
  <?php foreach ((array) $listActions as $actionName => $params): ?>
    <?php if ($actionName == '_create' && !isset($params['action'])) $params['action'] = $this->getCustomActionNameCamelized('', 'Create', 'create') ?>
    <?php echo $this->addCredentialCondition($this->getButtonToAction($actionName, $params, false), $params) ?>
  <?php endforeach; ?>
<?php else: ?>
  <?php echo $this->getButtonToAction('_create', array('action' => $this->getCustomActionNameCamelized('', 'Create', 'create')), false) ?>
<?php endif; ?>
[?php echo st_get_admin_actions_foot() ?]
