<?php use_helper('stAdminGenerator', 'I18N', 'Date', 'Validation') ?>
<?php use_stylesheet('backend/beta/style.css'); ?>
<?php use_stylesheet('backend/stShopInfoPlugin.css'); ?>
<?php echo st_get_admin_head('stShopInfoPlugin', __('Konfiguracja', null, 'stBackend'), "", array(0 => 'stTextPlugin')) ?>
<?php echo st_get_component('stAdminGenerator', 'menu', array('items' => $menu_items)) ?>
<div id="sf_admin_content">
    <?php echo form_tag('stShopInfoBackend/index', array('id' => 'sf_admin_config_form', 'class' => 'admin_form')) ?>    
        <?php if ($sf_flash->has('notice')): ?>
            <div class="save-ok">
                <h2><?php echo $sf_flash->get('notice') ?></h2>
            </div>
        <?php endif; ?>
        <fieldset>
            <div class="st_header">
                <div>
                    <h2><?php echo __('Informacje o sklepie') ?></h2>
                </div>
            </div>
            <div>
                <div class="row">
                    <?php echo label_for('st_form-register-field1',__('Nazwa sprzedawcy / Firma').':') ?>
                    <div class="field">
                        <span id="st_form-licence_info-company">
                            <?php echo input_tag('st_shop_info[company]', $config->get('company'), $config->get('company'), array('maxlength'=>'255')) ?> 
                        </span>
                    </div>
                </div>   
                <div class="row">
                    <?php echo label_for('st_form-register-field6',__('NIP').':') ?>
                    <div class="field">
                        <span id="st_form-licence_info-nip">
                            <?php echo input_tag('st_shop_info[nip]', $config->get('nip'), $config->get('nip'), array('maxlength'=>'255')) ?>
                        </span>
                    </div>
                    <br class="st_clear_all">
                </div>  
                
                <div class="row">
                    <?php echo label_for('st_form-register-field4',__('Ulica, nr domu').':') ?>  
                    <div class="field">
                        <span id="st_form-licence_info-street">
                            <?php echo input_tag('st_shop_info[street]', $config->get('street'), $config->get('street'), array('id'=>'st_form-register-street', 'maxlength'=>'255')) ?> 
                        </span>
                        <span id="st_form-licence_info-house">
                            <?php echo input_tag('st_shop_info[house]', $config->get('house'), $config->get('house'), array('id'=>'st_form-register-house', 'maxlength'=>'255')) ?>
                        </span>
                        <span id="st_form-address-sep">/</span>
                        <span id="st_form-licence_info-flat">
                            <?php echo input_tag('st_shop_info[flat]', $config->get('flat'), $config->get('flat'), array('id'=>'st_form-register-flat', 'maxlength'=>'255')) ?>
                        </span>
                   </div>
                   <br class="st_clear_all">
                </div>
                
                <div class="row">
                    <?php echo label_for('st_form-register-field5',__('Kod, miasto').':') ?>
                    <div class="field">
                        <span id="st_form-licence_info-code">
                            <?php echo input_tag('st_shop_info[code]', $config->get('code'), $config->get('code'), array('id'=>'st_form-register-code', 'maxlength'=>'255')) ?> 
                        </span>
                        <span id="st_form-licence_info-town">
                            <?php echo input_tag('st_shop_info[town]', $config->get('town'), $config->get('town'), array('id'=>'st_form-register-town', 'maxlength'=>'255')) ?> 
                        </span>
                    </div>
                </div>
                
                <?php echo st_admin_get_form_field('st_shop_info[phone]', __('Telefon'), $config->get('phone')) ?>

                <?php echo st_admin_get_form_field('st_shop_info[show_phone]', __('Pokaż telefon'), 1, 'checkbox_tag', array('checked' => $config->get('show_phone'), 'help' => __('Telefon jest widoczny wyłącznie dla urządzeń mobilnych'))) ?>

                <div class="row"> 
                    <?php echo label_for('st_form-register-field7',__('Fax').':') ?>
                    <div class="field">
                        <span id="st_form-licence_info-fax">
                            <?php echo input_tag('st_shop_info[fax]', $config->get('fax'), $config->get('fax'), array('id'=>'st_form-register-fax', 'maxlength'=>'255')) ?>
                        </span>
                    </div>
                </div>

                <div class="row">
                    <?php echo label_for('st_form-register-field7',__('Rachunek bankowy').':') ?>
                    <div class="field">
                        <span id="st_form-licence_info-bank">
                            <?php echo input_tag('st_shop_info[bank]', $config->get('bank'), $config->get('bank'), array('id'=>'st_form-register-bank', 'maxlength'=>'255')) ?>
                        </span>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 5px;">
                    <?php echo label_for('st_form-register-field7',__('Kontaktowy adres e-mail').':') ?>
                    <div class="field">
                        <span id="st_form-licence_info-company">
                            <?php echo input_tag('st_shop_info[email]', $config->get('email'), $config->get('email'), array('id'=>'st_form-register-email', 'maxlength'=>'255')) ?>
                        </span>
                    </div>
                </div>
            </div>
        </fieldset>
        <?php echo st_get_admin_actions_head() ?>
            <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, 'name=save') ?>
        <?php echo st_get_admin_actions_foot() ?>
    </form>
</div>
<?php echo st_get_admin_foot() ?>