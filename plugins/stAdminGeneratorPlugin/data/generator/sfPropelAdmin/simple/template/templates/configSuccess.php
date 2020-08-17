
[?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?]

<?php if ($stylesheets = $this->getParameterValue('config.use_stylesheet')): ?>
[?php
<?php foreach ($stylesheets as $stylesheet): ?>
use_stylesheet('<?php echo $stylesheet ?>');
<?php endforeach; ?>
?]
<?php endif; ?>

<?php if ($javascripts = $this->getParameterValue('config.use_javascript')): ?>
[?php
<?php foreach ($javascripts as $javascript): ?>
use_javascript('<?php echo $javascript ?>');
<?php endforeach; ?>
?]
<?php endif; ?>

[?php
<?php if ($helpers = $this->getParameterValue('config.use_helper')): ?>
<?php foreach ($helpers as $helper): $tmp = explode('/', $helper) ?>
<?php if (isset($tmp[1])): ?>
sfLoader::loadHelpers('<?php echo $tmp[1] ?>', '<?php echo $tmp[0] ?>');
<?php else: ?>
sfLoader::loadHelpers('<?php echo $tmp[0] ?>', '<?php echo $this->getModuleName() ?>');
<?php endif; ?>
<?php endforeach ?>
<?php endif; ?>
?]

[?php st_include_partial('<?php echo $this->getModuleName() ?>/header', array('related_object' => null, 'title' => <?php echo $this->getI18NString('config.title', null, false) ?><?php if ($this->showConfigCulturePicker('config')): ?>, 'culture' => $config->getCulture()<?php endif; ?>, 'route' => '<?php echo $this->getModuleName().'/'.$this->getCustomActionNameCamelized('', 'Config', 'config') ?>')) ?]

<?php if ($menu = $this->getMenuComponentBy('config.menu.use')): ?>
[?php st_include_component('<?php echo $this->getModuleName() ?>', '<?php echo $menu ?>', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object)) ?]
<?php else: ?>
[?php st_include_component('<?php echo $this->getModuleName() ?>', 'configMenu', array('forward_parameters' => $forward_parameters)) ?]
<?php endif; ?>  

   
<div id="sf_admin_content">
   [?php st_include_partial('<?php echo $this->getModuleName() ?>/config_messages', array('config' => $config, 'labels' => $labels, 'forward_parameters' => $forward_parameters)) ?]
   [?php st_include_partial('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>config_form', array('config' => $config, 'labels' => $labels, 'forward_parameters' => $forward_parameters)) ?]  
</div>
    
[?php st_include_partial('<?php echo $this->getModuleName() ?>/footer', array('related_object' => null, 'forward_parameters' => $forward_parameters)) ?]