<?php use_helper('Validation', 'I18N') ?>
<?php use_stylesheet('/css/update/stUpdateLogin.css?version=1'); ?>
<div id="sf_guard_container" align="center">
    <img src="/images/update/layout/logo_sote.jpg" alt="">
    <div id="sf_frame_login_middle">
        <div id="background_frame_login">
            <div id="frame_login">
                <?php echo form_tag('stAuth/login', array('name'=>'register')) ?>
                <fieldset>
                
                    <div class="form-row" id="sf_guard_auth_username">
                        <div id="sf_guard_auth_username_input">
                            
                            <input type="text" name="register[email]" id="register_email" value="" placeholder="Login / e-mail">
                            <?php echo form_error('register[email]', array('suffix'=>'', 'prefix'=>'')); ?>
                        </div>
                    </div>
                    
                    <div class="form-row" id="sf_guard_auth_password">
                        <div id="sf_guard_auth_username_input">
                            
                            <input type="password" name="register[password1]" id="register_password1" value="" placeholder="<?php echo __('Hasło') ?>">
                            <?php echo form_error('register[password1]', array('suffix'=>'', 'prefix'=>'')); ?>
                        </div>
                        
                    </div>
                        
                </fieldset>

                <div id="submit_login">    
                    <?php echo submit_tag(__('Zaloguj się'));?>
                    <div class="clear"></div>
                </div>
                </form>

                

            </div>
        </div>
    </div>
    <div id="sf_frame_login_bottom"></div>
    <div class="clear"></div>
</div>
<div class="site_address"><?php echo __('odwiedź stronę sklepu', null, 'sfGuardUser').': ' ?><a href="http://<?php echo $sf_request->getHost() ?>" target="_blank"><?php echo $sf_request->getHost() ?></a></div>

