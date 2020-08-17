<?php use_helper('stCaptchaGD') ?> 
<div id="password_reminder_form">
<form action="<?php echo url_for('stRemindPassword/remind') ?>" method="post">
   <div class="remind_email<?php if ($sf_request->hasError('remind_email')): ?> form-error<?php endif; ?>">
      <input type="text" name="remind_email" id="remind_email" placeholder="Login / e-mail" value="<?php echo $sf_request->getParameter('remind_email') ?>" />
      <?php if ($sf_request->hasError('remind_email')): ?>
         <div class="form-error-msg"><?php echo $sf_request->getError('remind_email') ?> </div>
      <?php endif; ?>      
   </div>
   <div class="row<?php if ($sf_request->hasError('remind_captcha')): ?> form-error<?php endif; ?>">
      <div class="captcha">
         <?php echo get_captcha(); ?>
         <p><input type="text" name="remind_captcha" id="remind_captcha" value="" placeholder="<?php echo __('Wpisz cyfry z obrazka', null, 'sfGuardUser') ?>" /></p>
         <?php if ($sf_request->hasError('remind_captcha')): ?>
            <div class="form-error-msg"><?php echo $sf_request->getError('remind_captcha') ?> </div>
         <?php endif; ?>           
      </div>
   </div>
   <div class="submit">
      <button type="submit"><?php echo __('Przypomnij') ?></button>
   </div>     
</form>
</div>
<script type="text/javascript">
jQuery(function($) {
   $('#password_reminder_form > form').submit(function(event) {
      var form = $(this);
      $('#password_reminder_form').css({ visibility: 'hidden' });
      $.post(form.attr('action'), form.serializeArray(), function(html) {
         $('#password_reminder > .content').html(html);
      });
      event.preventDefault();
   }); 
});
</script>
  