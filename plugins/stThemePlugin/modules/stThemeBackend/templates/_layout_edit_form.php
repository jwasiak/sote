<form action="<?php echo url_for('stThemeBackend/layoutSave?id='.$theme_config->getId()) ?>" enctype="multipart/form-data" method="post" name="sf_admin_edit_form" id="sf_admin_edit_form" class="admin_form">
   <fieldset>
      <div class="content">
         <?php foreach ($config->getCategories('layout_config') as $category): ?>
            <?php st_theme_layout_field($category, $config, $theme_config) ?>
         <?php endforeach ?>
      </div>
   </fieldset>
   <?php st_include_partial('stThemeBackend/layout_edit_actions', array('theme_config' => $theme_config)) ?>
</form>