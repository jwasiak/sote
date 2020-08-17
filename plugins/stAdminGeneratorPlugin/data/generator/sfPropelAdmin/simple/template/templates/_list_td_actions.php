<?php if ($this->getParameterValue('list.object_actions')): ?>
<td>
<ul class="st_object_actions">     
<?php foreach ($this->getParameterValue('list.object_actions') as $actionName => $params): if ($actionName == '_edit') continue; ?>
  
  <?php if ($actionName == '_delete' && !isset($params['action'])) $params['action'] = $this->getCustomActionNameCamelized('', 'Delete', 'delete') ?>

  <?php if ($actionName == '_delete'): ?>
  [?php if (method_exists($<?php echo $this->getSingularName() ?>, 'getIsSystemDefault') == false || (method_exists($<?php echo $this->getSingularName() ?>, 'getIsSystemDefault') &&  !$<?php echo $this->getSingularName() ?>->getIsSystemDefault())): ?]
  <?php endif; ?>
  
  <?php echo $this->addCredentialCondition($this->getLinkToAction($actionName, $params, true), $params) ?>
  
  <?php if ($actionName == '_delete'): ?>
  [?php endif; ?]
  <?php endif; ?>  
<?php endforeach; ?>
</ul>
</td>
<?php else: ?>
<td>&nbsp;</td>
<?php endif; ?>
