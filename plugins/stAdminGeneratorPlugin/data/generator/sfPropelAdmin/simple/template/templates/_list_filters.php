[?php echo form_tag('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?><?php echo $this->getForwardParametersForUrl('$', '?', 'list') ?>, array('id' => 'filter_list_form', 'class' => 'admin_form')) ?]
<div class="list_filters">
<ul class="header">  
<?php foreach ($this->getColumns('list.display') as $column): ?>
<?php
$filterable = $this->getParameterValue('list.fields.'.$column->getName().'.filterable', true);

if ($filterable == false) 
{
  continue;
}

$namespace = 'list.filters.'.$column->getName();

$i18n_catalogue = $this->getParameterValue('list.fields.'.$column->getName().'.i18n', $this->getModuleName());

$label = $this->getParameterValue('list.fields.'.$column->getName().'.name');

$label = $this->getParameterValue($namespace.'.name', $label);

if (null === $label) 
{
   $label = $column->getName();
}

$callback = $this->getParameterValue('list.fields.'.$column->getName().'.label_callback');

$name = $column->getName();

$credentials = $this->getParameterValue('list.fields.'.$column->getName().'.credentials');

if ($credentials)
{
  $credentials = str_replace("\n", ' ', var_export($credentials, true));
}

$p = array();

if ($filter_field = $this->getParameterValue($namespace.'.filter_field')) 
{ 
  $p = array('alternative_name' => $column->getName()); 
  $column = $this->getAdminColumnFromField($filter_field); 
} 

$type = $column->getCreoleType(); 

$component = $this->getParameterValue($namespace.'.component'); 

$partial = $this->getParameterValue($namespace.'.partial');
?>
<?php $install_version = $this->getParameterValue('list.fields.'.$column->getName().'.hide_install_version') ?>
<?php if ($install_version): ?>
  [?php if (!stSoteshop::checkInstallVersion('<?php echo $install_version ?>')): ?]
<?php endif ?>
<?php $old_config = $this->getParameterValue('list.fields.'.$column->getName().'.old_config') ?>
<?php if ($old_config): ?>
[?php if (!stTheme::hideOldConfiguration()): ?]
<?php endif ?>
<?php if ($credentials): ?>
[?php if ($sf_user->hasCredential(<?php echo $credentials ?>)): ?]
<?php endif; ?>
  <li>
<?php if ($component || $partial || $column->isReal()): ?>   
   <?php if ($callback): ?>   
       [?php echo label_for('filters[<?php echo $name ?>]',  <?php echo $callback ?>('<?php echo $label ?>')) ?]
   <?php else: ?>
       [?php echo label_for('filters[<?php echo $name ?>]', __('<?php echo $label ?>', null, '<?php echo $i18n_catalogue ?>')) ?]
   <?php endif; ?>
<?php endif; ?>
<?php if ($component): $component = (substr($component, 0, 1)) . substr(sfInflector::camelize($component), 1) ?>
    [?php st_include_component('<?php echo $this->getParameterValue($namespace.'.module', $this->getModuleName()) ?>', '<?php echo $component ?>', array('forward_parameters' => $forward_parameters, 'filters' => $filters)) ?]
<?php elseif ($partial): ?>    
    [?php st_include_partial('<?php echo $this->getParameterValue($namespace.'.module', $this->getModuleName()) ?>/<?php echo $partial ?>', array('forward_parameters' => $forward_parameters, 'filters' => $filters)) ?] 
<?php elseif ($column->isReal()): ?>   
[?php echo <?php echo $this->getColumnFilterTag($column, $p) ?> ?]  
<?php endif; ?> 
  </li>
<?php if ($credentials): ?>
[?php endif; ?]
<?php endif; ?>
<?php if ($old_config): ?>
[?php endif; ?]
<?php endif ?>
<?php if ($install_version): ?>
[?php endif; ?]
<?php endif ?>
<?php endforeach; ?>
<?php if ($this->getParameterValue('list.build_options.through_class')): ?>
   <li>
      [?php echo label_for('filters[assigned]',  __('Przypisany', null, 'stAdminGeneratorPlugin')) ?]
      [?php echo select_tag('filters[assigned]', options_for_select(array('' => '---', 1 => __('tak', null, 'stAdminGeneratorPlugin'), 0 => __('nie', null, 'stAdminGeneratorPlugin')), isset($filters['assigned']) ? $filters['assigned'] : null)) ?]
   </li>
<?php endif; ?>
<?php if ($this->getParameterValue('list.mark_as')): ?>
  <li>
    [?php echo label_for('filters[_is_marked_as]', __('Oznaczone jako', null, 'stAdminGeneratorPlugin')) ?]
        
    [?php echo select_tag('filters[_is_marked_as]', options_for_select(array('read' => __('Przeczytane', array(), 'stAdminGeneratorPlugin'), 'unread' => __('Nieprzeczytane', array(), 'stAdminGeneratorPlugin')), isset($filters['_is_marked_as']) ? $filters['_is_marked_as'] : null, array (
      'include_custom' => __("---", null, 'stAdminGeneratorPlugin'),
    )), array (
    )) ?]  
  </li>
<?php endif ?>
  <li>
    <input type="submit" value="[?php echo __('Filtruj', null, 'stAdminGeneratorPlugin') ?]" style='background-image: url("/images/backend/beta/icons/16x16/search.png"); cursor: pointer; background-repeat: no-repeat; background-position: 5px center; background-color: #eee; line-height: 16px; min-height: 26px; padding: 3px 5px box-sizing: padding-box; -webkit-box-sizing:padding-box; -moz-box-sizing: padding-box; -ms-box-sizing: padding-box; margin-left: 10px; padding-left: 30px; padding-top: 5px; margin-top: -1px;' />
  </li>
[?php if ($filters): ?]    
  <li>
    <input type="image" src="/images/backend/beta/icons/16x16/remove.png" onclick="this.form.action += '?filters_clear=1'" style="" />
  </li>  
[?php endif; ?]
<?php if ($this->getParameterValue('list.additional_filters')): ?>
    <li style="float: right; padding-left: 10px; padding-right: 0px">
        <a href="#" class="advanced_search_trigger"></a>
    </li>
<?php endif; ?>
</ul>
<div class="clr"></div>
<?php if ($this->getParameterValue('list.additional_filters')): ?>
<div class="advanced_search">
<?php foreach ($this->getColumns('list.additional_filters') as $column): ?>
<?php
$namespace = 'list.filters.'.$column->getName();

$i18n_catalogue = $this->getParameterValue('list.fields.'.$column->getName().'.i18n', $this->getModuleName());

$label = $this->getParameterValue('list.fields.'.$column->getName().'.name', $column->getName());

$label = $this->getParameterValue($namespace.'.name', $label);

$name = $column->getName();

$credentials = $this->getParameterValue('list.fields.'.$column->getName().'.credentials');

if ($credentials)
{
  $credentials = str_replace("\n", ' ', var_export($credentials, true));
}

$p = array();

if ($filter_field = $this->getParameterValue($namespace.'.filter_field')) 
{ 
  $p = array('alternative_name' => $column->getName()); 
  $column = $this->getAdminColumnFromField($filter_field); 
}

$type = $column->getCreoleType(); 


?>
<?php $install_version = $this->getParameterValue('list.fields.'.$column->getName().'.hide_install_version') ?>
<?php if ($install_version): ?>
  [?php if (!stSoteshop::checkInstallVersion('<?php echo $install_version ?>')): ?]
<?php endif ?>
<?php $old_config = $this->getParameterValue('list.fields.'.$column->getName().'.old_config') ?>
<?php if ($old_config): ?>
[?php if (!stTheme::hideOldConfiguration()): ?]
<?php endif ?>
<?php if ($credentials): ?>
[?php if ($sf_user->hasCredential(<?php echo $credentials ?>)): ?]
<?php endif; ?>
<?php if ($component = $this->getParameterValue($namespace.'.component')): $component = (substr($component, 0, 1)) . substr(sfInflector::camelize($component), 1) ?>
         <div class="row">
            [?php echo label_for('filters[<?php echo $name ?>]',  __('<?php echo $label ?>', null, '<?php echo $i18n_catalogue ?>')) ?]
            <div class="field">
            [?php st_include_component('<?php echo $this->getParameterValue($namespace.'.module', $this->getModuleName()) ?>', '<?php echo $component ?>', array('forward_parameters' => $forward_parameters, 'filters' => $filters)) ?]
            </div>
         </div>
<?php elseif ($partial = $this->getParameterValue($namespace.'.partial')): ?>
         <div class="row">
            [?php echo label_for('filters[<?php echo $name ?>]',  __('<?php echo $label ?>', null, '<?php echo $i18n_catalogue ?>')) ?]
            <div class="field">
            [?php st_include_partial('<?php echo $this->getParameterValue($namespace.'.module', $this->getModuleName()) ?>/<?php echo $partial ?>', array('forward_parameters' => $forward_parameters, 'filters' => $filters)) ?]
            </div>
         </div>
<?php elseif ($column->isReal()): ?>
         <div class="row">
            [?php echo label_for('filters[<?php echo $name ?>]',  __('<?php echo $label ?>', null, '<?php echo $i18n_catalogue ?>')) ?]
            <div class="field">
               [?php echo <?php echo $this->getAdvancedFilterTag($column, $p) ?> ?]
            </div>
         </div>
<?php endif; ?>
<?php if ($credentials): ?>
[?php endif; ?]
<?php endif; ?>
<?php if ($old_config): ?>
[?php endif; ?]
<?php endif ?>
<?php if ($install_version): ?>
  [?php endif ?]
<?php endif ?>
<?php endforeach; ?>
  <div class="clr"></div>
</div>
<?php endif; ?>
</div>

</form>

<?php if ($this->getParameterValue('list.additional_filters')): ?>
<script type="text/javascript">
jQuery(function($) {
  var cookies = jaaulde.utils.cookies;

  var path = window.location.pathname.split('/');

  var cookie_options = { path: '/'+path[1]+'/'+path[2] , domain: document.domain, expiresAt: -1, secure: false };

  var advanced_search_trigger = cookies.get('advanced_search_trigger');

  var search_trigger = $('#filter_list_form a.advanced_search_trigger');

  if (advanced_search_trigger) {
    $('#filter_list_form div.advanced_search').show();
    search_trigger.addClass('expanded');
  }

  search_trigger.toggle(
      function() {
        if (advanced_search_trigger) {
          $('#filter_list_form div.advanced_search').hide();
          search_trigger.removeClass('expanded');
          cookies.set('advanced_search_trigger', 0, cookie_options);
        } else {
          $('#filter_list_form div.advanced_search').show();
          search_trigger.addClass('expanded');
          cookies.set('advanced_search_trigger', 1, cookie_options);        
        }
      },
      function() {
        if (advanced_search_trigger) {
          $('#filter_list_form div.advanced_search').show();
          search_trigger.addClass('expanded');
          cookies.set('advanced_search_trigger', 1, cookie_options);
        } else {
          $('#filter_list_form div.advanced_search').hide();
          search_trigger.removeClass('expanded');
          cookies.set('advanced_search_trigger', 0, cookie_options);
        }
      }
    );

  [?php if (isset($filters['_expanded'])): ?]
    if (!search_trigger.hasClass('expanded')) {
      search_trigger.click();
    }
  [?php endif ?]
});
</script>
<?php endif; ?>