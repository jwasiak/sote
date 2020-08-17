<?php use_helper('Validation', 'I18N') ?>
<div class="login_form">
     <?php echo form_tag('stRegister/register', array('class' => 'st_form', 'name'=>'register')) ?>
      <div class="logo">
         <img src="/images/backend/beta/logo.jpg" alt="" />
      </div>
      <div>
        <?php echo __('Rejestracja danych użytkownika w procesie instalacji') ?>
      </div>
      <div class="row<?php if ($sf_request->hasError('register{email}')): ?> form-error<?php endif; ?>">
         <?php echo input_tag('register[email]', $register['email'], array('id'=>'st_form-register-email', 'maxlength'=>'255', 'placeholder'=>'Login / e-mail', 'class'=>form_has_error('register{email}') ? 'st_form-error' : '')) ?>
         <?php if ($sf_request->hasError('register{email}')): ?>
            <div class="form-error-msg"><?php echo $sf_request->getError('register{email}') ?> </div>
         <?php endif; ?>            
      </div>
      <div class="row<?php if ($sf_request->hasError('register{password1}')): ?> form-error<?php endif; ?>">
         <?php $p = __('Hasło'); ?>
         <?php echo input_password_tag('register[password1]', $register['password1'], array('id'=>'st_form-register-password1', 'maxlength'=>'255', 'placeholder'=>$p, 'class'=>form_has_error('register{password1}') ? 'st_form-error' : '')) ?>
         <?php if ($sf_request->hasError('register{password1}')): ?>
            <div class="form-error-msg"><?php echo $sf_request->getError('register{password1}') ?> </div>
         <?php endif; ?>            
      </div>
      <div class="row<?php if ($sf_request->hasError('register{password2}')): ?> form-error<?php endif; ?>">
         <?php $rp = __('Powtórz hasło'); ?>
         <?php echo input_password_tag('register[password2]', $register['password2'], array('id'=>'st_form-register-password2', 'maxlength'=>'255', 'placeholder'=>$rp, 'class'=>form_has_error('register{password2}') ? 'st_form-error' : '')) ?>
         <?php if ($sf_request->hasError('register{password2}')): ?>
            <div class="form-error-msg"><?php echo $sf_request->getError('register{password2}') ?> </div>
         <?php endif; ?>            
      </div>
      <div class="row<?php if ($sf_request->hasError('register{license}')): ?> form-error<?php endif; ?>">
            <?php $license = __('Licencja'); ?>
            <?php if ($readOnly):?>
                <?php echo input_tag('register[license]', $register['license'], array('id'=>'st_form-register-license', 'maxlength'=>'255', 'readonly' => true, 'placeholder'=>$license, 'class'=>form_has_error('register{license}') ? 'st_form-error' : '')) ?>
            <?php else:?>
                <?php echo input_tag('register[license]', $register['license'], array('id'=>'st_form-register-license', 'maxlength'=>'255', 'placeholder'=>$license, 'class'=>form_has_error('register{license}') ? 'st_form-error' : '')) ?>
            <?php endif;?>
            <?php if ($sf_request->hasError('register{license}')): ?>
            <div class="form-error-msg"><?php echo $sf_request->getError('register{license}') ?> </div>
         <?php endif; ?>            
      </div>
      <div class="row">
         <ul>
            <li><a href="#" rel="#password_reminder"></a></li>
            <li><button type="submit"><?php echo __('Zarejestruj') ?></button></li>
         </ul>
      </div>    
   </form>
</div>