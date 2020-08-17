
    <?php use_helper('Validation') ?>
<?php st_theme_use_stylesheet('stUser.css') ?>
<div id="st_application-user-login" class="st_application" >

    <div id="st_application-user-login-header">
        <h1 class="st_title"><?php echo __('Edytor grafiki') ?></h1>
        <p><?php echo __('Zaloguj się podając dane dostępowe do panelu administracyjnego.') ?></p>
        <br class="st_clear_all" />
    </div>
    
    <div class="st_content">
    
    <div style=" width: 400px;margin:0px auto;">    
    <?php echo form_tag('@sf_guard_signin', array('class' => 'st_form')) ?>
        
        <fieldset>
        
            <div class="st_row">
                <?php echo form_error('username', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                <?php echo label_for('username',__('Użytkownik')) ?>
                <div class="st_field">
                      <?php echo input_tag('username', $sf_data->get('sf_params')->get('username'), array('id'=>'st_form-password','class'=>form_has_error('username') ? 'st_form-error' : '')) ?> 
                </div>
            </div>  
            
            <div class="st_row">
                <?php echo form_error('password', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>
                <?php echo label_for('password',__('Hasło')) ?>
                <div class="st_field">
                    <?php echo input_password_tag('password', $sf_params->get('password'), array('id'=>'st_form-password','class'=>form_has_error('password') ? 'st_form-error' : '')) ?> 
                </div>
            </div>  
                    
            <div class="st_row">
                <div id="st_button-user-login_success" class="st_button-container">
                        <div class="st_button st_align-right">
                            <div class="st_button-left">
                            <?php echo submit_tag(__('Zaloguj')) ?>
                            </div>
                        </div>
                </div>
            </div>
        
        </fieldset>    
        
        </form>
</div>                       
        
        <br class="st_clear_all" />

    </div>
    
</div>