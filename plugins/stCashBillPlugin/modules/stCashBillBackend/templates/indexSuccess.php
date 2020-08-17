<?php use_helper('I18N', 'stAdminGenerator', 'Validation');?>
<?php echo st_get_admin_head('stCashBillPlugin', __('Konfiguracja'), '', array('stPayment'));?>
    <div id="sf_admin_content">
        <?php if ($sf_request->hasErrors()):?>
            <div class="form-errors">
                <h2><?php echo __('Popraw dane w formularzu.', null, 'stAdminGeneratorPlugin');?></h2>
                <?php if (isset($labels)):?>
                    <dl>
                        <?php foreach ($sf_request->getErrorNames() as $name):?>
                            <dt><?php echo $labels[$name];?></dt>
                            <dd><?php echo $sf_request->getError($name);?></dd>
                        <?php endforeach;?>
                    </dl>
                <?php endif;?>
            </div>
        <?php elseif ($sf_flash->has('notice')):?>
            <div class="save-ok">
                <h2><?php echo $sf_flash->get('notice');?></h2>
            </div>
        <?php endif;?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('cashbill/index', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form'));?>
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Ustawienia główne');?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row <?php if($sf_request->hasError('config{shop_id}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[shop_id]', __('Identyfikator Punktu Płatności'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[shop_id]', $sf_params->get('config[shop_id]'), array('size' => '32'));?>
                            <?php else:?>
                                <?php echo input_tag('config[shop_id]', $config->get('shop_id'), array('size' => '32'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{secret_key}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[secret_key]', __('Klucz Punktu Płatności'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[secret_key]', $sf_params->get('config[secret_key]'), array('size' => '32'));?>
                            <?php else:?>
                                <?php echo input_tag('config[secret_key]', $config->get('secret_key'), array('size' => '32'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[test]', __('Włącz tryb testowy'), array());?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo checkbox_tag('config[test]', true, $sf_params->get('config[test]'));?>
                            <?php else:?>
                                <?php echo checkbox_tag('config[test]', true, $config->get('test'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[show_variant]', __('Wybór kanału płatności (banku)'), array());?>
                            <?php $options = array('none' => __('W serwisie CashBill (zalecana)'), 'image' => __('W sklepie, graficzna'), 'text' => __('W sklepie, tekstowa'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo select_tag('config[show_variant]', options_for_select($options, $sf_params->get('config[show_variant]')));?>
                            <?php else:?>
                                <?php echo select_tag('config[show_variant]', options_for_select($options, $config->get('show_variant')));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <?php echo label_for('config[url_report]', __('Adres serwerowego potwierdzenia transakcji'), array());?>
                            <nobr>http://<?php echo $webRequest->getHost(); ?>/cashbill/reportStatus</nobr>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Przewodnik Płatności CashBill dla SOTE');?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <div> 
                                <?php echo __('Zobacz krótki przewodnik uruchomienia Płatności CashBill. Sprawdź promocyjne warunki dla klientów SOTE.');?>
                            </div>
                            <div class="admin_actions" style="float: left;">
                                <a style="background-color: #eee; padding: 2px 5px 4px; display: block; text-decoration: none; border: 1px solid #ccc; color: #000;" href="http://www.cashbill.pl/download/integracje/Platnosci/PlatnosciCashBillSOTE.pdf" target="_blank"><img style="position: relative; top: 4px; margin-right: 3px;" src="/images/backend/icons/download_theme.png" title="<?php echo __('Pobierz przewodnik');?>" alt="<?php echo __('Pobierz przewodnik');?>"><?php echo __('Pobierz przewodnik');?></a>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"');?>
                    <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save'));?>
                <?php echo st_get_admin_actions_foot();?>
            </form>
        </div>
    </div>
    <br class="st_clear_all" />
<?php echo st_get_admin_foot();?>