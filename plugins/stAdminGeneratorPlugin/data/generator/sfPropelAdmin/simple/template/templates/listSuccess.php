
[?php use_helper('I18N', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin', 'stDate') ?]

<?php if ($stylesheets = $this->getParameterValue('list.use_stylesheet')): ?>
[?php
<?php foreach ($stylesheets as $stylesheet): ?>
use_stylesheet('<?php echo $stylesheet ?>');
<?php endforeach; ?>
?]
<?php endif; ?>

<?php if ($javascripts = $this->getParameterValue('list.use_javascript')): ?>
[?php
<?php foreach ($javascripts as $javascript): ?>
use_javascript('<?php echo $javascript ?>');
<?php endforeach; ?>
?]
<?php endif; ?>

[?php
<?php if ($helpers = $this->getParameterValue('list.use_helper')): ?>
<?php foreach ($helpers as $helper): $tmp = explode('/', $helper) ?>
<?php if (isset($tmp[1])): ?>
sfLoader::loadHelpers('<?php echo $tmp[1] ?>', '<?php echo $tmp[0] ?>');
<?php else: ?>
sfLoader::loadHelpers('<?php echo $tmp[0] ?>', '<?php echo $this->getModuleName() ?>');
<?php endif; ?>
<?php endforeach ?>
<?php endif; ?>
?]

[?php st_include_partial('<?php echo $this->getModuleName() ?>/header', array('related_object' => $related_object, 'title' => <?php echo $this->getI18NString('list.title', null, false) ?>, 'route' => '<?php echo $this->getModuleName().'/'.$this->getCustomActionNameCamelized('', 'List', 'list') ?>')) ?]

<?php if ($menu = $this->getMenuComponentBy('list.menu.use')): ?>
[?php st_include_component('<?php echo $this->getModuleName() ?>', '<?php echo $menu ?>', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object)) ?]
<?php else: ?>
[?php st_include_component('<?php echo $this->getModuleName() ?>', 'listMenu', array('forward_parameters' => $forward_parameters)) ?]
<?php endif; ?>

<div id="sf_admin_content">
    [?php st_include_partial('<?php echo $this->getModuleName() ?>/list_messages', array('pager' => $pager, 'forward_parameters' => $forward_parameters, 'labels' => $labels)) ?]
    [?php $list_actions = st_get_partial('<?php echo $this->getCustomActionName('', '_') ?>list_actions', array('pager' => $pager, 'forward_parameters' => $forward_parameters)) ?] 

    <div<?php if (!$this->getParameterValue('list.auto_width')): ?> style="display: table; width: 100%; clear: both;"<?php endif; ?>>     
    [?php if ($pager->getNbResults() > 10 || $filters): ?]
    [?php st_include_partial('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>list_filters', array('filters' => $filters, 'forward_parameters' => $forward_parameters)) ?]   
    [?php endif; ?]
    [?php echo form_tag('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?><?php echo $this->getForwardParametersForUrl('$', '?', 'list') ?>, array('id' => 'record_list_form', 'class' => 'admin_form')) ?]
    <?php foreach ($this->getParameterValue('list.forward_parameters', array()) as $name): ?>
    [?php echo input_hidden_tag('forward_parameters[<?php echo $name ?>]', $forward_parameters['<?php echo $name ?>']) ?]
    <?php endforeach; ?>
    [?php echo input_hidden_tag('page', $pager->getPage()) ?]   
     
    [?php if ($pager->getNbResults() || $filters): ?]
    [?php st_include_partial('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>list_pager', array('pager' => $pager, 'forward_parameters' => $forward_parameters, 'url' => st_url_for('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?><?php echo $this->getForwardParametersForUrl('$', '?', 'list') ?>), 'prefix' => 'head')) ?]    
    [?php st_include_partial('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>list', array('pager' => $pager, 'forward_parameters' => $forward_parameters, '<?php echo $this->getSingularName() ?>_action_select_options' => $<?php echo $this->getSingularName() ?>_action_select_options)) ?]
    [?php else: ?]
    [?php st_include_partial('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>list_empty_message', array('pager' => $pager, 'forward_parameters' => $forward_parameters)) ?]
    [?php endif; ?]    
    <div id="list_actions">
    [?php if ($pager->getNbResults() || $filters): ?]  
        <div class="float_left">[?php st_include_partial('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>list_select_control', array('pager' => $pager, 'forward_parameters' => $forward_parameters, '<?php echo $this->getSingularName() ?>_action_select_options' => $<?php echo $this->getSingularName() ?>_action_select_options)) ?]</div>       
    [?php endif; ?]       
        [?php echo $list_actions ?]
    </div>
    </form>

    </div>
    <div class="clr"></div>
</div>

[?php st_include_partial('<?php echo $this->getModuleName() ?>/footer', array('related_object' => $related_object)) ?]
<script type="text/javascript">
jQuery(function($) {
      $('#list_actions').stickyBox();
});
</script>