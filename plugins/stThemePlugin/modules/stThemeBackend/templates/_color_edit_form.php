<form action="<?php echo st_url_for('stThemeBackend/colorEdit?id='.$theme_config->getId()) ?>" enctype="multipart/form-data" method="post" name="sf_admin_edit_form" id="sf_admin_edit_form" class="admin_form">
   <fieldset>
      <h2><?php echo __('Paleta kolorów') ?></h2>
      <div class="content">
         <?php st_theme_generate_editor_fields(array('_less', 'palette'), $editor_config, $theme_config) ?>
      </div>
   </fieldset>
   <fieldset>
      <h2><?php echo __('Kolory') ?></h2>
      <div class="content">
         <?php st_theme_generate_editor_fields(array('_less', 'colors'), $editor_config, $theme_config) ?>
      </div>
   </fieldset>      
   <?php st_include_partial('stThemeBackend/editor_edit_actions', array('theme_config' => $theme_config, 'type' => 'color')) ?>
</form>