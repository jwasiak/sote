<?php use_helper('Validation') ?>
<?php echo form_tag('stAuth/registerSave', array('name'=>'register')) ?>

<?php echo "Login:" ?>
<?php echo form_error('register[email]', array('suffix'=>'', 'prefix'=>'')); ?>
<?php echo input_tag('register[email]', $sf_data->get('sf_params')->get('register[email]')) ?>
<br/>
<?php echo "Hasło:" ?>
<?php echo form_error('register[password1]', array('suffix'=>'', 'prefix'=>'')); ?>
<?php echo input_password_tag('register[password1]', $sf_data->get('sf_params')->get('register[password1]')) ?>
<br/>
<?php echo "Powtórz hasło:" ?>
<?php echo form_error('register[password2]', array('suffix'=>'', 'prefix'=>'')); ?>
<?php echo input_password_tag('register[password2]', $sf_data->get('sf_params')->get('register[password2]')) ?>

<?php echo submit_tag() ?>

</form>