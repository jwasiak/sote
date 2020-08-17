
[?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'VisualEffect', 'stAdminGenerator', 'stDate') ?]
<?php $class_name = $this->getClassName() ?>
<?php if ($stylesheets = $this->getParameterValue('edit.use_stylesheet')): ?>
[?php
<?php foreach ($stylesheets as $stylesheet): ?>
use_stylesheet('<?php echo $stylesheet ?>');
<?php endforeach; ?>
?]
<?php endif; ?>

<?php if ($javascripts = $this->getParameterValue('edit.use_javascript')): ?>
[?php
<?php foreach ($javascripts as $javascript): ?>
use_javascript('<?php echo $javascript ?>');
<?php endforeach; ?>
?]
<?php endif; ?>

[?php
<?php if ($helpers = $this->getParameterValue('edit.use_helper')): ?>
<?php foreach ($helpers as $helper): $tmp = explode('/', $helper) ?>
<?php if (isset($tmp[1])): ?>
sfLoader::loadHelpers('<?php echo $tmp[1] ?>', '<?php echo $tmp[0] ?>');
<?php else: ?>
sfLoader::loadHelpers('<?php echo $tmp[0] ?>', '<?php echo $this->getModuleName() ?>');
<?php endif; ?>
<?php endforeach ?>
<?php endif; ?>
?]

[?php st_include_partial('<?php echo $this->getModuleName() ?>/header', array('related_object' => $related_object, 'title' => $<?php echo $this->getSingularName() ?>->isNew() ? <?php echo $this->getI18NString('create.title', 'Dodaj nowy', false) ?> : <?php echo $this->getI18NString('edit.title', null, false) ?><?php if (method_exists(new $class_name(), 'setCulture')): ?>, 'culture' => !$<?php echo $this->getSingularName() ?>->isNew() ? $<?php echo $this->getSingularName() ?>->getCulture() : null<?php endif; ?>, 'route' => <?php echo $this->getEditActionUrl() ?>)) ?]
<?php if ($this->getParameterValue('edit.menu.display')): ?>
[?php
if (!$<?php echo $this->getSingularName() ?>->isNew() || isset($related_object) && !$related_object->isNew())
{ 
   st_include_component('<?php echo $this->getModuleName() ?>', '<?php echo $this->getCustomActionNameCamelized('', 'Edit', 'edit') ?>Menu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object));
}
?]
<?php elseif ($menu = $this->getMenuComponentBy('edit.menu.use')): ?>
[?php
if (!$<?php echo $this->getSingularName() ?>->isNew() || isset($related_object) && !$related_object->isNew())
{ 
   st_include_component('<?php echo $this->getModuleName() ?>', '<?php echo $menu ?>', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object));
}
?]
<?php elseif ($menu != 'none'): ?>
   [?php st_include_component('<?php echo $this->getModuleName() ?>', 'listMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object)); ?]   
<?php endif; ?>  

<div id="sf_admin_content">
   [?php st_include_partial('<?php echo $this->getModuleName() ?>/edit_messages', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'labels' => $labels, 'forward_parameters' => $forward_parameters)) ?]
   [?php st_include_partial('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>edit_form', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'labels' => $labels, 'forward_parameters' => $forward_parameters, 'related_object' => $related_object)) ?]
</div>

[?php st_include_partial('<?php echo $this->getModuleName() ?>/footer', array('related_object' => $related_object, 'forward_parameters' => $forward_parameters)) ?]