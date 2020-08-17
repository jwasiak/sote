[?php $routing = sfRouting::getInstance(); ?]
[?php $module = stConfiguration::getInstance()->getDesktopModule($sf_context->getModuleName()); ?]
[?php $module_name = sfContext::getInstance()->getModuleName(); ?]
[?php $action_name = sfContext::getInstance()->getActionName(); ?]
[?php init_tooltip('.help') ?]
[?php init_tooltip('.float_right_config .tooltip, .header .menu > ul > .expandable a.relatedmodules', array('width' => 'auto', 'position' => 'bottom right')) ?]
[?php use_stylesheet('backend/beta/style.css?v17', 'first') ?]

<div class="application-menu">
    <ul>
        [?php foreach ($items as $action => $name): $url = url_for($action) ?]
            <li class="[?php echo $selected_item_path == $url ? 'selected' : 'none' ?]"><a href="[?php echo $url ?]">[?php echo $name ?]</a></li>
        [?php endforeach; ?]
    </ul>
    <br style="clear: left" />
</div>

<div class="header" style="margin-bottom: 10px;">
    [?php if($module_name == 'stProduct' && $action_name == 'list' || $action_name == 'listLong'): ?]
    [?php $choose_list = $sf_context->getActionStack()->getLastEntry()->getActionName(); ?]

    <div class="pager_bar">
      <form class="list_view" action="[?php echo st_url_for ('stProduct/chooseList') ?]" method="get">
        <select name="type" onchange="this.form.submit()" style="width: 120px;">
          <option value="long"[?php if ($choose_list=="listLong"): ?] selected="selected"[?php endif ?]>
            [?php echo __('Lista pełna', null, 'stBackendMain') ?]
          </option>
          <option value="list"[?php if ($choose_list=="list"): ?] selected="selected"[?php endif ?]>
            [?php echo __('Lista skrócona', null, 'stBackendMain') ?]
          </option>
        </select>
      </form>
      <div class="clr"></div>
    </div>

    <div class="menu float_left_categories">
      <ul>
        <li class="expandable"><span class="categories" class="categories tooltip" title="[?php echo __('Kategorie', null, 'stBackendMain') ?]"><img src="/images/backend/beta/icons/20x20/categories.png" style="vertical-align: middle; padding-right: 10px;">[?php echo __('Kategorie', null, 'stBackendMain') ?]</span>
          [?php st_include_component('stCategory', 'tree') ?]
        </li>
      </ul>
    </div>

    <div class="clr"></div>
  [?php st_include_component('stCategory', 'treeBreadcrumbs') ?]
    
  [?php elseif($module_name == 'appProductAttributeBackend' && $action_name == 'list'): ?]

    [?php 
      $url = st_url_for('@appProductAttributesPlugin'); 
      $selected = $sf_user->getAttribute('category_filter', 0, 'soteshop/appProductAttribute');
    ?]

    <div class="menu float_left_categories">
      <ul>
        <li class="expandable"><span class="categories" class="categories tooltip" title="[?php echo __('Kategorie', null, 'stBackendMain') ?]"><img src="/images/backend/beta/icons/20x20/categories.png" style="vertical-align: middle; padding-right: 10px;">[?php echo __('Kategorie', null, 'stBackendMain') ?]</span>
          [?php st_include_component('stCategory', 'tree', array('url' => $url, 'selected' => $selected)) ?]
        </li>
      </ul>

      <script type="text/javascript">
        jQuery(function($) {
        $( ".show" ).click(function() {
        $(this).next().next().toggleClass('open');  
        });
        });
      </script>

    <div class="clr"></div>
  </div>
  [?php st_include_component('stCategory', 'treeBreadcrumbs', array('url' => $url, 'selected' => $selected)) ?]
  
  [?php endif; ?]
  <div class="clr"></div>


</div>