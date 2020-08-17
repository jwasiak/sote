<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>

<?php echo st_get_admin_head('stAttributeTemplatePlugin', __('Szablony dla produktu - Edycja szablonu \'%%name%%\'', 
array('%%name%%' => $attribute_template->getName())), __('Tworzenie szablonów atrybutów dla produktów.', 
array()), array (
  0 => 'stProduct',
)) ?>
            <?php st_include_partial('stAttributeFieldBackend/menu', array()) ?>
            
            <div id="sf_admin_header">
            <?php st_include_partial('stAttributeFieldBackend/edit_header', array('attribute_template' => $attribute_template)) ?>
            </div>
            
            <div id="sf_admin_content">
            <?php st_include_partial('stAttributeFieldBackend/edit_messages', array('attribute_template' => $attribute_template, 'labels' => $labels)) ?>
            <?php st_include_partial('stAttributeFieldBackend/edit_form', array('attribute_template' => $attribute_template, 'labels' => $labels)) ?>
            </div>
            <br class="st_clear_all" />
            
            <div id="sf_admin_footer">
            <?php st_include_partial('stAttributeFieldBackend/edit_footer', array('attribute_template' => $attribute_template)) ?>
            </div>
<?php echo st_get_admin_foot() ?>