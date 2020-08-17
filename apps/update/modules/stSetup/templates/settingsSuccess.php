<?php use_helper('stUpdate');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php echo form_tag('stSetup/settings');?>
    <div id="sf_admin_container">
        <?php include_partial('header');?>
        <div class="bg_content">
            <div class="stSetup-left_menu">
                <?php include_component('stSetup', 'leftMenu', array('step'=>'settings'));?>
            </div>
            <div id="stSetup-right_menu">
                <h2 class="title"><?php echo __("Domyślne ustawienia");?></h2>
                <fieldset>
                    <div class="st_fieldset-content themes">
                        <?php if(count($themes) > 1):?>
                            <div class="form-row images">
                                <div class="frame-themes-name"><?php echo __('Domyślny temat graficzny');?></div>
                                <div id="frame-themes">
                                    <?php $radio = false; $i = 1;?>
                                    <?php foreach($themes as $package => $theme):?>

                                        <label class="box-theme">
                                            <span class="theme_img">
                                                <img class="small" src="/images/update/themes/<?php echo $package;?>.png" alt="" title=""/>
                                            </span>
                                            <span class="box-theme-name">
                                                <?php echo radiobutton_tag('settings[theme]', $package, $theme['name'] == $defaultTheme);?> <?php echo str_replace('rwd', '', $theme['name']);?>
                                            </span>
                                        </label>
                                        <?php $radio = false; $i++;?>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        <?php elseif(count($themes) == 1):?>
                            <?php echo input_hidden_tag('settings[theme]', key($themes));?>
                        <?php endif;?>
                        <div class="form-row"<?php if(count($themes) == 1) echo ' style="border-top: 1px solid #DDDDDD;"'?>>
                            <label><?php echo __('Załaduj przykładowe dane');?></label>
                            <div class="content">
                                <?php echo checkbox_tag('settings[load_fixtures]', 1, true);?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="form-row label-select">
                            <label><?php echo __('Waluta');?></label>
                            <div class="content">
                                <?php echo select_tag('settings[currency]', options_for_select($currency, $defaultCurrency), array());?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="form-row label-select">
                            <label><?php echo __('Domyślny kraj');?></label>
                            <div class="content">
                                <?php echo select_tag('settings[country]', options_for_select($countries, $defaultCountry), array());?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="form-row label-select">
                            <label><?php echo __('Wersja językowa panelu sklepu');?></label>
                            <div class="content">
                                <?php echo select_tag('settings[language_panel]', options_for_select($languagePanel, $defaultLanguage), array());?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="form-row label-select">
                            <label><?php echo __('Wersja językowa sklepu');?></label>
                            <div class="content">
                                <?php echo select_tag('settings[language]', options_for_select($language, $defaultLanguage), array());?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </fieldset>
                <div class="stSetup-actions" id='stSetup-install_actions'>
                    <?php echo st_get_update_actions_head();?>
                        <?php echo st_get_update_action('next', __('Dalej'), null);?>
                    <?php echo st_get_update_actions_foot();?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>