<?php use_helper('Validation', 'I18N', 'stUrl') ?>
<div class="login_form">
     <?php echo form_tag('@homepage', array('class' => 'st_form', 'name'=>'register', 'method'=>'get')) ?>
      <div class="logo">
         <img src="/images/backend/beta/logo.jpg" alt="" />
      </div>
      <div style="font-size: 14px; margin-bottom: 10px;">
        <?php echo __('Rejestracja konta administratora') ?>
      </div>
      <div class="row_reg<?php if ($sf_request->hasError('register{email}')): ?> form-error<?php endif; ?>">
         <label for="username"><?php echo __('Użytkownik') ?>:</label>
         <div class="st_field"><b><?php echo $register['email']; ?></b></div>
      </div>
      <div class="row_reg<?php if ($sf_request->hasError('register{password1}')): ?> form-error<?php endif; ?>">
         <label for="password"><?php echo __('Hasło') ?>:</label>
         <div class="st_field"><b><?php echo $register['password1']; ?></b></div>
      </div>
      <div class="row_reg<?php if ($sf_request->hasError('register{license}')): ?> form-error<?php endif; ?>">
         <label for="password"><?php echo __('Licencja') ?>:</label>
         <div class="st_field"><b><?php echo $register['license']; ?></b></div>  
      </div>
      <div class="row">
         <ul>
            <li><a href="#" rel="#password_reminder"></a></li>
            <li><button id="redirect_to_backend" type="button" data-redirect="<?php echo url_for('@homepage') ?>"><?php echo __('Przejdź do panelu') ?></button></li>
         </ul>
      </div>
   </form>
</div>

<script>
   jQuery(function($) {
      $('#redirect_to_backend').click(function() {
         window.location = $(this).data('redirect');
      });
   });
</script>