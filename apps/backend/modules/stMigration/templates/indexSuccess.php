<?php use_helper('Form', 'Validation', 'I18N', 'stAdminGenerator') ?>

<?php echo st_get_admin_head('stMigration',  __('Import danych z zewnętrznych systemów'), __('Import danych z zewnętrznych systemów')) ?>

<?php st_include_partial('stMigration/index_messages', array('labels' => $labels)) ?>

<?php init_tooltip('#admin_config_form .help') ?>

<?php echo form_tag('stMigration/process', array('style' => 'margin: 10px;')) ?>
    <fieldset id="sf_fieldset_database">
    <div class="st_fieldset-content">
        <div class="form-row">     
            <?php echo label_for('migration[type]', __($labels['migration{type}']) . ':') ?>
<?php if ($sf_request->hasError('migration{type}')): ?> 
            <div class="content form-error">
                <?php echo form_error('migration{type}', array('class' => 'form-error-msg')) ?>
<?php else: ?>
            <div class="content">
<?php endif; ?>
                <?php echo select_tag('migration[type]', options_for_select($migration_options, $sf_request->getParameter('migration[type]'))) ?>
            </div>
            <br class="st_clear_all" />
        </div>         
        <div class="form-row">     
            <?php echo label_for('migration[www]', __($labels['migration{www}']) . "<a href='#'' class='help' title='" . __('Adres www przenoszonego sklepu') . "'></a>:", 'class="required"') ?>
<?php if ($sf_request->hasError('migration{www}')): ?> 
            <div class="content form-error">
                <?php echo form_error('migration{www}', array('class' => 'form-error-msg')) ?>
<?php else: ?>
            <div class="content">
<?php endif; ?>
                <?php echo input_tag('migration[www]', $sf_request->getParameter('migration[www]', 'http://')) ?>
            </div>
            <br class="st_clear_all" />
        </div> 
        <div class="form-row">     
            <?php echo label_for('migration[erase_data]', __($labels['migration{erase_data}']) . "<a href='#'' class='help' title='" . __('Dotychczasowe dane w sklepie w wersji 5.0 zostaną skasowane przed rozpoczęciem migracji.') . "'></a>:") ?>
<?php if ($sf_request->hasError('migration{erase_data}')): ?> 
            <div class="content form-error">
                <?php echo form_error('migration{erase_data}', array('class' => 'form-error-msg')) ?>
<?php else: ?>
            <div class="content">
<?php endif; ?>
                <?php echo checkbox_tag('migration[erase_data]', true, $sf_request->getParameter('migration[erase_data]')) ?>
            </div>
            <br class="st_clear_all" />
        </div>         
    </div>        
    </fieldset>
    <fieldset id="sf_fieldset_database">
    <div class="st_header">
        <div>
            <h2><?php echo __('Baza danych przenoszonego sklepu') ?></h2>
        </div>
    </div>    
    <div class="st_fieldset-content">
        <div class="form-row">     
            <?php echo label_for('migration[host]', __($labels['migration{host}']) . ':', 'class="required"') ?>
<?php if ($sf_request->hasError('migration{host}')): ?> 
            <div class="content form-error">
                <?php echo form_error('migration{host}', array('class' => 'form-error-msg')) ?>
<?php else: ?>
            <div class="content">
<?php endif; ?>
                <?php echo input_tag('migration[host]', $sf_request->getParameter('migration[host]', 'localhost')) ?>
            </div>
            <br class="st_clear_all" />
        </div>   
        <div class="form-row">     
            <?php echo label_for('migration[port]', __($labels['migration{port}']) . ':', 'class="required"') ?>
<?php if ($sf_request->hasError('migration{port}')): ?> 
            <div class="content form-error">
                <?php echo form_error('migration{port}', array('class' => 'form-error-msg')) ?>
<?php else: ?>
            <div class="content">
<?php endif; ?>
                <?php echo input_tag('migration[port]', $sf_request->getParameter('migration[port]', 3306), 'size=5') ?>
            </div>
            <br class="st_clear_all" />
        </div>               
        <div class="form-row">     
            <?php echo label_for('migration[database]', __($labels['migration{database}']) . ':', 'class="required"') ?>
<?php if ($sf_request->hasError('migration{database}')): ?> 
            <div class="content form-error">
                <?php echo form_error('migration{database}', array('class' => 'form-error-msg')) ?>
<?php else: ?>
            <div class="content">
<?php endif; ?>
                <?php echo input_tag('migration[database]', $sf_request->getParameter('migration[database]')) ?>
            </div>
            <br class="st_clear_all" />
        </div>    
        <div class="form-row">     
            <?php echo label_for('migration[username]', __($labels['migration{username}']) . ':', 'class="required"') ?>
<?php if ($sf_request->hasError('migration{username}')): ?> 
            <div class="content form-error">
                <?php echo form_error('migration{username}', array('class' => 'form-error-msg')) ?>
<?php else: ?>
            <div class="content">
<?php endif; ?>
                <?php echo input_tag('migration[username]', $sf_request->getParameter('migration[username]')) ?>
            </div>
            <br class="st_clear_all" />
        </div>
        <div class="form-row">     
            <?php echo label_for('migration[password]', __($labels['migration{password}']) . ':') ?>
<?php if ($sf_request->hasError('migration{password}')): ?> 
            <div class="content form-error">
                <?php echo form_error('migration{password}', array('class' => 'form-error-msg')) ?>
<?php else: ?>
            <div class="content">
<?php endif; ?>
                <?php echo input_password_tag('migration[password]', null, 'autocomplete="off"') ?>
            </div>
            <br class="st_clear_all" />
        </div>
    </div>               
    </fieldset>

    <?php echo stSocketView::openComponents('stMigration.custom.Content'); ?>
    
    <?php echo st_get_admin_actions_head() ?>
    <?php echo st_get_admin_action('save', __('Importuj')) ?>
    <?php echo st_get_admin_actions_foot() ?>    
</form>


<?php echo st_get_admin_foot() ?>
