<?php echo form_tag('attribute_template/save', array('id' => 'sf_admin_edit_form', 'name' => 'sf_admin_edit_form', 'multipart' => true,)) ?>
    <fieldset id="sf_fieldset_none">
        <div class="st_header">
            <div>
                <h2><?php echo __('Dodaj nowy szablon') ?></h2>
            </div>
        </div>
        <div class="st_fieldset-content" id="sf_fieldset_none_slide">
            <div class="form-row">
                <?php echo label_for('attribute_template[name]', __('Nazwa').':') ?>
                <div class="content<?php if ($sf_request->hasError('attribute_template{name}')): ?> form-error<?php endif; ?>">
                    <?php if ($sf_request->hasError('attribute_template{name}')): ?>
                        <?php echo form_error('attribute_template{name}', array('class' => 'form-error-msg')) ?>
                    <?php endif; ?>
                    <?php echo input_tag('attribute_template[name]') ?>
                </div>
            </div>
            <div class="form-row">
                <?php echo st_get_admin_actions_head() ?>
                    <?php echo st_get_admin_action('add', __('Dodaj'), null, 'name=save_and_list') ?>
                <?php echo st_get_admin_actions_foot() ?>
            </div>    
        </div>
    </fieldset>
</form>