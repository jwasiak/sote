<form action="<?php echo url_for('stThemeBackend/graphicSave?id='.$theme_config->getId()) ?>" enctype="multipart/form-data" method="post" name="sf_admin_edit_form" id="sf_admin_edit_form" class="admin_form">
   <?php foreach ($editor_config->getGraphicCategories() as $index => $category): if ($category == '_less' || !$editor_config->getGraphicCategoryLabel($category)) continue; ?>
      <fieldset id="st_fieldset_<?php echo $category ?>">
         <h2><?php echo __($editor_config->getGraphicCategoryLabel($category)) ?></h2>
         <div class="content">
            <?php st_theme_generate_editor_fields($category, $editor_config, $theme_config) ?>
         </div>
      </fieldset>
   <?php endforeach ?>
   <?php st_include_partial('stThemeBackend/editor_edit_actions', array('theme_config' => $theme_config, 'type' => 'graphic')) ?>
</form>
<script type="text/javascript">
jQuery(function($) {
   $(document).ready(function() {
      $('.st_theme_image_preview').load(function() {
         if (this.width < 2)
         {
            this.width = 50;
         }
         
         if (this.height < 2)
         {
            this.height = 50;
         }      
      });
   });
});
</script>