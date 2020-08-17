<br class="st_clear_all"/>
<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin') ?>
<?php  use_stylesheet('backend/stRegister.css'); ?>
<?php echo st_get_admin_head('stRegister', __('Rejestracja danych użytkownika w procesie instalacji'), __('Rejestracja danych')) ?>      

<div id="st_register">
        <?php echo form_tag('stRegister/register', array('class' => 'st_form', 'name'=>'register')) ?>
        
        <div style="width: 250px; float:left;"> 
        
        <?php echo form_error('register[dbError]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
               
        <div id="st_form-register-field9" class="st_row">
            <b><?php echo label_for('st_form-register-field9',__('adres bazy danych')) ?></b>
            <div class="st_field">
                <?php echo form_error('register[dbHost]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                <?php echo input_tag('register[dbHost]', $register['dbHost'], array('id'=>'st_form-register-dbHost', 'maxlength'=>'255', 'class'=>form_has_error('register{dbHost}') ? 'st_form-error' : '')) ?>
            </div>
        </div>   
        
        <div id="st_form-register-field10" class="st_row">
            <b><?php echo label_for('st_form-register-field10',__('nazwa bazy danych')) ?></b>
            <div class="st_field">
                <?php echo form_error('register[dbName]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                <?php echo input_tag('register[dbName]', $register['dbName'], array('id'=>'st_form-register-dbName', 'maxlength'=>'255', 'class'=>form_has_error('register{dbName}') ? 'st_form-error' : '')) ?>
            </div>
        </div>   
        
        <div id="st_form-register-field11" class="st_row">
            <b><?php echo label_for('st_form-register-field11',__('użytkownik bazy danych')) ?></b>
            <div class="st_field">
                <?php echo form_error('register[dbUser]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                <?php echo input_tag('register[dbUser]', $register['dbUser'], array('id'=>'st_form-register-dbUser', 'maxlength'=>'255', 'class'=>form_has_error('register{dbUser}') ? 'st_form-error' : '')) ?>
            </div>
        </div>   
        
        <div id="st_form-register-field12" class="st_row">
            <b><?php echo label_for('st_form-register-field12',__('hasło bazy danych')) ?></b>
            <div class="st_field">
                <?php echo form_error('register[dbPassword]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                <?php echo input_tag('register[dbPassword]', $register['dbPassword'], array('id'=>'st_form-register-dbPassword', 'maxlength'=>'255', 'class'=>form_has_error('register{dbPassword}') ? 'st_form-error' : '')) ?>
            </div>
        </div>   
        
        </div><div style="width: 250px; float:left;">
        
        <div id="st_form-register-field8" class="st_row">
            <b><?php echo label_for('st_form-register-field8',__('licencja')) ?></b>
            <div class="st_field">
                <?php echo form_error('register[licence]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                <?php echo input_tag('register[licence]', $register['licence'], array('id'=>'st_form-register-licence', 'maxlength'=>'255', 'class'=>form_has_error('register{licence}') ? 'st_form-error' : '')) ?>
            </div>
        </div>   
        
        <?php echo input_hidden_tag('register[www]', $_SERVER['SERVER_NAME']) ?>
        
        </div>
        <br class="st_clear_all" />         
           
            <div id="submit_button">
                <?php echo st_get_admin_actions_head() ?>
                    <?php echo st_get_admin_action('save', __('Zarejestruj'), null, 'name=save') ?>
                <?php echo st_get_admin_actions_foot() ?>
            </div>   
        </form>
    </div>

<?php echo st_get_admin_foot() ?>