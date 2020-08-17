<?php sfLoader::loadHelpers('stThemeBackend', 'stThemeBackend') ?>
<?php if (null !== $allegro_template->getTheme()): 
$theme = $allegro_template->getThemeInstance();
$theme_editor = new stThemeEditorConfig();
$theme_editor->load($theme->getThemeConfig());
?>
<?php 
$i18n = $sf_context->getI18N();
$i18n->setCurrentCatalogue('stThemeBackend');
st_theme_generate_editor_fields('allegro_template', $theme_editor, $theme->getThemeConfig());
$i18n->revertToPreviousCatalogue();
?>
<?php endif ?>