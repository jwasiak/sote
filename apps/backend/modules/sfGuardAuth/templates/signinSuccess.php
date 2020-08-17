<?php use_helper('Validation', 'I18N') ?>
<div class="login_form">
   <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
      <div class="logo">
         <img src="/images/backend/beta/logo.jpg" alt="" />
      </div>
      <div class="row<?php if ($sf_request->hasError('username')): ?> form-error<?php endif; ?>">
         <input type="text" name="username" id="username" placeholder="Login / e-mail" value="<?php echo $sf_request->getParameter('username') ?>" />
         <?php if ($sf_request->hasError('username')): ?>
            <div class="form-error-msg"><?php echo $sf_request->getError('username') ?> </div>
         <?php endif; ?>            
      </div>
      <div class="row<?php if ($sf_request->hasError('password')): ?> form-error<?php endif; ?>">
         <input type="password" name="password" id="password" placeholder="<?php echo __('Hasło') ?>" /> 
         <?php if ($sf_request->hasError('password')): ?>
            <div class="form-error-msg"><?php echo $sf_request->getError('password') ?> </div>
         <?php endif; ?>            
      </div>
      <div class="remind">
         <a href="#" rel="#password_reminder"><?php echo __('Zapomniałeś hasła?', null, 'sfGuardUser') ?></a>
      </div>
      <div class="clr"></div>
      <div class="submit">
         <button type="submit"><?php echo __('Zaloguj się', null, 'sfGuardUser') ?></button>
      </div>
   </form>   
</div>
<div class="site_address"><?php echo __('odwiedź stronę sklepu', null, 'sfGuardUser').': ' ?><a href="http://<?php echo $sf_request->getHost() ?>" target="_blank"><?php echo $sf_request->getHost() ?></a></div>
<div id="password_reminder" class="popup_window">
   <div class="close"><a id="reminder_close" href="#"><img src="/images/frontend/theme/default2/buttons/close.png" alt="" /></a></div>
   <h2><?php echo __('Przypomnij hasło', null, 'stRemindPassword') ?></h2>
   <div class="content preloader_160x24">
      <?php st_include_component('stRemindPassword', 'remind') ?>
   </div>
</div>
<script type="text/javascript">
jQuery(function($) {
   $('a[rel=#password_reminder]').overlay({
      speed: 'fast',
      close: $('#password_reminder .close a'),
      mask: {
         color: '#444',
         loadSpeed: 'fast',
         opacity: 0.5,
         top: 130
      },
      closeOnClick: true,
      onClose: function() {
         $('#password_reminder_form').css({ visibility: 'hidden' });
      },
      onBeforeLoad: function() {
         $('#password_reminder_form').css({ visibility: 'hidden' });
         $.get('<?php echo url_for("stRemindPassword/ajaxShow") ?>', {}, function(html) {
            $('#password_reminder > .content').html(html);
            $('#remind_email').val($('#username').val());
         });         
         
      }
   }); 
});
</script>

