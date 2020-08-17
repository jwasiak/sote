<script type="text/javascript" src="/sf/sf_web_debug/js/main.js"></script>
<script type="text/javascript" src="/sfPrototypePlugin/js/prototype.js"></script>
<script type="text/javascript" src="/sfPrototypePlugin/js/effects.js"></script>
<script type="text/javascript" src="/sfPrototypePlugin/js/controls.js"></script>
<?php use_stylesheet('backend/stAttributeTemplate.css') ?>

<ul id="st_attribute_template-field-list">
    <?php foreach ($attribute_template->getAttributeFields() as $index => $attribute_field): ?>
         <?php st_include_partial('stAttributeFieldBackend/attribute_row', array('attribute_field' => $attribute_field, 'index' => $index + 1)) ?>
    <?php endforeach; ?>
</ul>

<br />
<?php echo form_tag('attribute_field/addAttribute', array('id' => 'sf_admin_edit_form', 'name' => 'sf_admin_edit_form', 'multipart' => true,)) ?>
    <?php echo object_input_hidden_tag($attribute_template, 'getId') ?>
    <fieldset>
        <div class="st_fieldset-content" id="sf_fieldset_zarz__dzaj_atrybutami_slide">
            <div class="form-row">
                <?php echo label_for('attribute_template[name]', __('Nazwa atrybutu:'), array("class"=>"st_application-st_attribute_template_attribute_template_name")) ?>
                <div class="content<?php if ($sf_request->hasError('attribute_template{name}')): ?> form-error<?php endif; ?>">
                    <?php if ($sf_request->hasError('attribute_template{name}')): ?>
                        <?php echo form_error('attribute_template{name}', array('class' => 'form-error-msg')) ?>
                    <?php endif; ?>
                    <?php echo input_tag('attribute_template[name]') ?>
                </div>            
                <?php echo st_get_admin_actions_head() ?>
                    <div id="st_application-st_attribute_template-add_button" ><?php echo st_get_admin_action('add', __('Dodaj')) ?></div>
                    <div id="st_application-st_attribute_template-html_button"><?php echo st_get_admin_action('_generateHTML', __('Przejdź do szablonu'), 'attribute_template/list', array ()) ?></div>                    
                <?php echo st_get_admin_actions_foot() ?>
            </div>
        </div>
    </fieldset>
</form>
<br />     
