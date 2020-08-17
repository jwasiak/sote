<br class="st_clear_all"/>
<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin', 'stCaptchaGD', 'stUrl') ?>

<?php  use_stylesheet('backend/stRemindPassword.css'); ?>
<?php echo st_get_admin_head(array('stRemindPassword', 'Przypomnij hasło'), __('Przypomnij hasło dla administratora'), __('Odzyskaj hasło dla konta administratora')) ?>


<?php if($send_true!=1): ?>
    <div id="st_remind">
        
        <?php echo form_tag('stRemindPassword/remindPassword', array('class' => 'st_form')) ?>
            <fieldset>
            <div id="st_form-remind-field1" class="st_row">
            <?php echo label_for('st_form-remind-field1',__('E-mail (login)')) ?>
                <div class="st_field">
                    <?php echo form_error('remind[email]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                    <?php echo input_tag('remind[email]', $sf_params->get('remind[email]'), array('id'=>'st_form-remind-email', 'maxlength'=>'255')) ?>
                </div>
                <br class="st_clear_all">
            </div>

            <div id="st_form-remind-field2" class="st_row" style="margin-left:160px; height: 50px; margin-top:3px;">
                <?php echo get_captcha(); ?>
            </div>

            <div id="st_form-remind-field3" class="st_row">
            <?php echo label_for('st_form-remind-field1',__('Cyfry z obrazka')) ?>
                <div class="st_field">
                    <?php echo form_error('captcha', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                    <?php echo input_tag('captcha', '', array('id'=>'st_form-remind-captcha', 'maxlength'=>'255')) ?>
                </div>
            </div>

            <div id="st_form-remind-field4" class="st_row">
            <div id="submit_button">
                <?php echo st_get_admin_actions_head() ?>
                    <?php echo st_get_admin_action(null, __('Przypomnij'), null, 'name=save') ?>
                <?php echo st_get_admin_actions_foot() ?>
            </div>
            </div>

            </fieldset>
        </form>

    </div>
<?php else: ?>
<div style="text-align: center; margin:100px;">
<?php echo __('E-mail z linkiem do utworzenia nowego hasła został wysłany na adres').":<b><br>".$sf_params->get('remind[email]')."</b>"; ?>
</div>
<?php endif; ?>
<?php echo link_to(__('Powrót do strony logowania'),"/"); ?>
<?php echo st_get_admin_foot() ?>