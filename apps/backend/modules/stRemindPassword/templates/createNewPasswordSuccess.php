<?php use_helper('Validation', 'I18N', 'stCaptchaGD') ?>
<div id="password_reminded">
    <div class="login_form">
        <?php if($passwordChange!=1): ?>
            <div style='color: #000000; font-size: 16px; font-weight: normal; text-align: center; margin-bottom: 20px;'><?php echo __('Utwórz nowe hasło', null, 'stRemindPassword') ?></div>
            <?php echo form_tag('stRemindPassword/createNewPassword', array('class' => 'st_form')) ?>
                <div class="row<?php if ($sf_request->hasError('remind{email}')): ?> form-error<?php endif; ?>">
                    <input type="text" name="remind[email]" id="remind[email]" placeholder="Login / e-mail" value="<?php echo $login ?>" />
                    <?php if ($sf_request->hasError('remind{email}')): ?>
                        <div class="form-error-msg"><?php echo $sf_request->getError('remind[email]') ?> </div>
                    <?php endif; ?>      
                </div>
                <div class="row<?php if ($sf_request->hasError('remind{password1}')): ?> form-error<?php endif; ?>">
                    <input type="password" name="remind[password1]" id="remind[password1]" placeholder="<?php echo __('Nowe hasło') ?>" />
                    <?php if ($sf_request->hasError('remind{password1}')): ?>
                        <div class="form-error-msg"><?php echo $sf_request->getError('remind[password1]') ?> </div>
                    <?php endif; ?>      
                </div>
                <div class="row<?php if ($sf_request->hasError('remind{password2}')): ?> form-error<?php endif; ?>">
                    <input type="password" name="remind[password2]" id="remind[password2]" placeholder="<?php echo __('Potwierdź hasło') ?>" />
                    <?php if ($sf_request->hasError('remind{password2}')): ?>
                        <div class="form-error-msg"><?php echo $sf_request->getError('remind[password2]') ?> </div>
                    <?php endif; ?>      
                </div>
               <div class="row<?php if ($sf_request->hasError('captcha')): ?> form-error<?php endif; ?>">
                  <div class="captcha">
                     <?php echo get_captcha(); ?>
                     <p><input type="text" name="captcha" id="captcha" value="" placeholder="<?php echo __('Wpisz cyfry z obrazka', null, 'sfGuardUser') ?>" /></p>
                     <?php if ($sf_request->hasError('captcha')): ?>
                        <div class="form-error-msg"><?php echo $sf_request->getError('captcha') ?> </div>
                     <?php endif; ?>           
                  </div>
               </div>
                <?php echo input_hidden_tag('hash_code', $hashCode); ?>
                <div class="submit">
                    <button type="submit"><?php echo __('Zmień hasło') ?></button>
                </div>
            </form>
        <?php else: ?>
            <div class="logo">
                <img src="/images/backend/beta/logo.jpg" alt="" />
            </div>
            <div style="font-size: 14px; padding: 40px 0; text-align: center;">
                <?php echo __('Hasło dla administratora zostało zmienione.'); ?>
            </div>
            <div class="submit">
                <a href="/backend.php"><button type="submit"><?php echo __('Zamknij', null, 'sfGuardUser') ?></button></a>
            </div>
        <?php endif; ?>
    </div>
</div>