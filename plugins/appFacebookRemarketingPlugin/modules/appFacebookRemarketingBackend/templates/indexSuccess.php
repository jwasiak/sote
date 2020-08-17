<?php use_helper('I18N', 'stAdminGenerator', 'stJQueryTools') ?>

<?php echo st_get_admin_head('appFacebookRemarketingPlugin', __('Konfiguracja'), array('culture' => $config->getCulture()), array('stConfigurationPlugin')) ?>

<div class="header" style="margin-top: -10px !important;">
    <?php include_partial('menu', array()) ?>
</div>

<style type=”text/css”>
#sf_admin_content_config .jquery_tooltip {
    width: 500px !important;
}
</style>

<div id="sf_admin_content">
    <?php if ($sf_flash->has('notice')): ?>
        <div class="save-ok" style="margin-top: 10px !important;">
            <h2><?php echo $sf_flash->get('notice') ?></h2>
        </div>
    <?php endif; ?>
    <div id="sf_admin_content_config">
        <?php echo form_tag('appFacebookRemarketingBackend/index?culture='.$config->getCulture(), array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form'));?>

            <?php if (!$configuration_check): ?>
                <fieldset>
                    <h2><?php echo __('Tworzenie piksela');?></h2>
                    <div class="content">
                        <div class="row" style="margin-left: 20px; font-family: Helvetica, Arial, sans-serif; color: #555; line-height: 18px; font-size: 12px;">
                            <a href="https://pl-pl.facebook.com/ads/manager/pixel/custom_audience_pixel/" target="_blank" style="text-decoration: underline; color: #555;"><?php echo __('Utwórz piksel');?></a><?php echo __(' w menedżerze reklam Facebook.'); ?>
                        </div>
                    </div>
                </fieldset>
            <?php endif ?>
            
            <fieldset style="margin-top: 10px !important;">
                <div class="st_fieldset-content">
                    <div class="form-row">
                        <?php echo label_for('fbremarketing[enable_fbremarketing]', __('Włącz'), '') ?>
                        <?php echo checkbox_tag('fbremarketing[enable_fbremarketing]',true,$config->get('enable_fbremarketing'), array('style'=>'margin-top: 3px')) ?>
                        <br class="st_clear_all">
                    </div>
                    <div class="form-row">
                        <?php $hint = '&lt;script&gt;<br />' ?>
                        <?php $hint .= '!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments): n.queue.push(arguments)};if(!f._fbq)f._fbq=n;<br />' ?>
                        <?php $hint .= "n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;<br />" ?>
                        <?php $hint .= "t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');<br />" ?>
                        <?php $hint .= "fbq('init', '<strong>".__("NUMER_PIKSELA_FACEBOOKA")."</strong>');<br />" ?>
                        <?php $hint .= "fbq('track', 'PageView');<br />" ?>
                        <?php $hint .= '&lt;/script&gt;' ?>
                        <?php echo label_for('fbremarketing[code_fbremarketing]', __('Podaj numer piksela Facebooka'), array('style' => 'padding-right: 0px; width: 220px;')) ?><a href="#" class="help" title="<?php echo htmlspecialchars($hint) ?>" style="margin-right: 10px;"></a>
                        <?php echo input_tag('fbremarketing[code_fbremarketing]', $config->get('code_fbremarketing', null, true), array('maxlength'=>'255', 'style'=>'width: 200px', 'class'=>'error_input')) ?>
                        <br class="st_clear_all">
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <h2><?php echo __('Rejestrowanie zdarzeń');?></h2>
                <div class="content">
                    <div class="form-row">
                        <?php echo label_for('fbremarketing[product_card]', __('Wyświetlanie produktu').'<a href="#" class="help" title="'.__('Akcja: View content').'"></a>', '') ?>
                        <?php echo checkbox_tag('fbremarketing[product_card]',true,$config->get('product_card'), array('style'=>'margin-top: 3px')) ?>
                        <br class="st_clear_all">
                    </div>
                    <div class="form-row">
                        <?php echo label_for('fbremarketing[cart]', __('Dodanie do koszyka').'<a href="#" class="help" title="'.__('Akcja: Add to cart').'"></a>', '') ?>
                        <?php echo checkbox_tag('fbremarketing[cart]',true,$config->get('cart'), array('style'=>'margin-top: 3px')) ?>
                        <br class="st_clear_all">
                    </div>
                    <div class="form-row">
                        <?php echo label_for('fbremarketing[order]', __('Dokonanie zakupów').'<a href="#" class="help" title="'.__('Akcja: Make purchase').'"></a>', '') ?>
                        <?php echo checkbox_tag('fbremarketing[order]',true,$config->get('order'), array('style'=>'margin-top: 3px')) ?>
                        <br class="st_clear_all">
                    </div>
                </div>
            </fieldset>
            <?php echo st_get_admin_actions_head() ?>
                <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
            <?php echo st_get_admin_actions_foot() ?>
        </form>
    </div>
</div>
<br class="st_clear_all">
<?php echo st_get_admin_foot() ?>