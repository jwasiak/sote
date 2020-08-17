<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin', 'stCaptchaGD', 'stUrl') ?>


<div class="show_hide_contact_form"><span style="color: #4B7195; outline: medium none; text-decoration: underline;"><?php echo __('Przypomnij hasło') ?></span></div>
<?php if ($sf_request->hasError('remind{email}') || $sf_request->hasError('captcha')): ?>
    <div class="slidingDiv_contact_form">
<?php elseif ($sf_params->get('remind[email]')): ?>
    <div class="slidingDiv_contact_form">
<?php else: ?>
    <div class="slidingDiv_contact_form" style="display:none;">
<?php endif; ?>
        <?php echo form_tag('stRemindPassword/remindPassword', array('class' => 'sf_admin_config_form')) ?>
            <fieldset id="sf_fieldset-none" style="border: none;">
                <div class="st_fieldset-content" style="padding-bottom: 10px; padding-top: 10px;">
                    <?php if($send_true!=1): ?>
                        <div class="row" style="padding: 4px 10px;">
                            <label for="remind_email" style="float: left; padding-right: 10px; text-align: right; width: 260px; color: #000000; font-weight: normal;"><?php echo __('E-mail (login):') ?></label>
                            <div class="field<?php if ($sf_request->hasError('remind{email}')): ?> form-error<?php endif; ?>" style="float: left;">
                                <?php if ($sf_request->hasError('remind{email}')): ?>
                                    <?php echo form_error('remind{email}', array('class' => 'form-error-msg')) ?>
                                <?php endif; ?>
                                <?php echo input_tag('remind[email]', $sf_params->get('remind[email]'), array('maxlength'=>'255', 'size' =>'32')) ?>
                            </div>
                            <div class="clr"></div>
                        </div>
                        <div class="row" style="padding: 4px 10px;">
                            <label for="remind_get_captcha" style="float: left; padding-right: 10px; text-align: right; width: 260px;"></label>
                            <div class="field" style="margin-left: 94px;">
                                <?php echo get_captcha(); ?>
                            </div>
                            <div class="clr"></div>
                        </div>
                        <div class="row" style="padding: 4px 10px;">
                            <label for="captcha" style="float: left; padding-right: 10px; text-align: right; width: 260px;  color: #000000; font-weight: normal;"><?php echo __('Cyfry z obrazka:') ?></label>
                            <div class="field<?php if ($sf_request->hasError('captcha')): ?> form-error<?php endif; ?>" style="float: left;">
                                <?php if ($sf_request->hasError('captcha')): ?>
                                    <?php echo form_error('captcha', array('class' => 'form-error-msg')) ?>
                                <?php endif; ?>
                                <?php echo input_tag('captcha', '', array('maxlength'=>'255', 'size' =>'32')) ?>
                            </div>
                            <div class="clr"></div>
                        </div>
                        
                        <div id="submit_login" align="center" style="clear: right; margin-left: 280px; padding-top: 10px;">
                            <div id="submit_left"></div>
                            <div id="submit_middle">
                                <?php echo submit_tag(__('Przypomnij'), array('name' => 'remindPassword')); ?>
                                <?php echo image_tag('backend/icons/arrow_right.gif') ?>
                            </div>
                            <div id="submit_right"></div>              
                        </div>
                    <?php else: ?>
                        <div class="slidingDiv_contact_form" style="text-align: center; margin-top:20px;">
                            <?php echo __('E-mail z linkiem do utworzenia nowego hasła został wysłany na adres').":<b><br>".$sf_params->get('remind[email]')."</b>"; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </fieldset>
        </form>
</div>
<br class="st_clear_all" />

<script type="text/javascript">
jQuery(function ($)
{
   $(document).ready(function(){
    $(".show_hide_contact_form").show();
    $('.show_hide_contact_form').click(function(){
        $( this ).next( ".slidingDiv_contact_form" ).slideToggle();
    });
    });
});
</script>