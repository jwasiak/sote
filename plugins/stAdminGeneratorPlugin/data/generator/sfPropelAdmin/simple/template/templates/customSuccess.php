[?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?]

[?php st_include_partial('<?php echo $this->getModuleName() ?>/header', array('related_object' => $related_object, 'title' => <?php echo $this->getI18NString('custom.title', null, false) ?>, 'culture' => null, 'route' => '<?php echo $this->getModuleName().'/'.$this->getCustomActionNameCamelized('', 'Custom', 'custom') ?>')) ?]

<?php if ($stylesheets = $this->getParameterValue('custom.use_stylesheet')): ?>
[?php
<?php foreach ($stylesheets as $stylesheet): ?>
use_stylesheet('<?php echo $stylesheet ?>');
<?php endforeach; ?>
?]
<?php endif; ?>

<?php if ($javascripts = $this->getParameterValue('custom.use_javascript')): ?>
[?php
<?php foreach ($javascripts as $javascript): ?>
use_javascript('<?php echo $javascript ?>');
<?php endforeach; ?>
?]
<?php endif; ?>

[?php
<?php if ($helpers = $this->getParameterValue('custom.use_helper')): ?>
<?php foreach ($helpers as $helper): $tmp = explode('/', $helper) ?>
<?php if (isset($tmp[1])): ?>
sfLoader::loadHelpers('<?php echo $tmp[1] ?>', '<?php echo $tmp[0] ?>');
<?php else: ?>
sfLoader::loadHelpers('<?php echo $tmp[0] ?>', '<?php echo $this->getModuleName() ?>');
<?php endif; ?>
<?php endforeach ?>
<?php endif; ?>
?]

<?php if ($menu = $this->getMenuComponentBy('custom.menu.use')): ?>
[?php st_include_component('<?php echo $this->getModuleName() ?>', '<?php echo $menu ?>', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object)) ?]
<?php else: ?>
[?php st_include_component('<?php echo $this->getModuleName() ?>', 'customMenu', array('forward_parameters' => $forward_parameters)) ?]
<?php endif; ?>  

<div id="sf_admin_header">
   [?php echo stSocketView::openComponents('<?php echo $this->getModuleName() ?>.<?php echo$this->getCustomActionNameCamelized('', 'Custom', 'custom') ?>.Header'); ?]
</div>
    
<div id="sf_admin_content">
   [?php st_include_partial('<?php echo $this->getModuleName() ?>/custom_messages', array('forward_parameters' => $forward_parameters)) ?]
   [?php echo stSocketView::openComponents('<?php echo $this->getModuleName() ?>.<?php echo$this->getCustomActionNameCamelized('', 'Custom', 'custom') ?>.Content'); ?]
</div>
    
<div id="sf_admin_footer">
   [?php echo stSocketView::openComponents('<?php echo $this->getModuleName() ?>.<?php echo$this->getCustomActionNameCamelized('', 'Custom', 'custom') ?>.Footer'); ?]
</div>
[?php st_include_partial('<?php echo $this->getModuleName() ?>/footer', array('related_object' => null, 'forward_parameters' => $forward_parameters)) ?]