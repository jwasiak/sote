<br class="st_clear_all"/>
<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin', 'stCaptchaGD', 'stUrl') ?>

<?php  use_stylesheet('backend/stRemindPassword.css'); ?>
<?php echo st_get_admin_head(array('stRemindPassword', 'Przypomnij hasło'), __('Przypomnij hasło dla administratora'), __('Odzyskaj hasło dla konta administratora')) ?>

<?php if($passwordChange!=1): ?>
    <div id="st_remind">
        
        <?php echo form_tag('stRemindPassword/createNewPassword', array('class' => 'st_form')) ?>
            <fieldset>
            <div id="st_form-remind-field1" class="st_row">
            <?php echo label_for('st_form-remind-field1',__('E-mail (login)')) ?>
                <div class="st_field">
                    <?php echo form_error('remind[email]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                    <?php echo input_tag('remind[email]', $login, array('id'=>'st_form-remind-email', 'maxlength'=>'255', 'disabled'=>'disabled')) ?>
                </div>
                <br class="st_clear_all">
            </div>
                
            <div id="st_form-remind-field2" class="st_row" style="margin-top:3px;">
            <?php echo label_for('st_form-remind-field1',__('Nowe hasło')) ?>
                <div class="st_field">
                    <?php echo form_error('remind[password1]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                    <?php echo input_password_tag('remind[password1]', $sf_params->get('remind[password1]'), array('id'=>'st_form-remind-password1', 'maxlength'=>'255')) ?>
                </div>
               <br class="st_clear_all">
            </div>
            
            <div id="st_form-remind-field3" class="st_row">
            <?php echo label_for('st_form-remind-field1',__('Potwierdź hasło')) ?>
                <div class="st_field">
                    <?php echo form_error('remind[password2]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                    <?php echo input_password_tag('remind[password2]', $sf_params->get('remind[password2]'), array('id'=>'st_form-remind-password2', 'maxlength'=>'255')) ?>
                </div>
                <br class="st_clear_all">
            </div>

            <div id="st_form-remind-field4" class="st_row" style="margin-left:160px; height: 55px; margin-top:3px;">
                <?php echo get_captcha(); ?>
            </div>

            <div id="st_form-remind-field5" class="st_row">
            <?php echo label_for('st_form-remind-field1',__('Cyfry z obrazka')) ?>
                <div class="st_field">
                    <?php echo form_error('captcha', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                    <?php echo input_tag('captcha', '', array('id'=>'st_form-remind-captcha', 'maxlength'=>'255')) ?>
                </div>
            </div>

            <?php echo input_hidden_tag('hash_code', $hashCode); ?>

            <div id="st_form-remind-field4" class="st_row">
            <div id="submit_button">
                <?php echo st_get_admin_actions_head() ?>
                    <?php echo st_get_admin_action(null, __('Zmień hasło'), null, 'name=save') ?>
                <?php echo st_get_admin_actions_foot() ?>
            </div>
            </div>

            </fieldset>
        </form>

    </div>
<?php else: ?>
<div style="text-align: center; margin:100px;">
<?php echo __('Hasło dla administratora zostało zmienione.'); ?>
</div>
<?php endif; ?>
<?php echo link_to(__('Powrót do strony logowania'),"/"); ?>
<?php echo st_get_admin_foot() ?>