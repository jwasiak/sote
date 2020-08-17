<?php use_helper('I18N', 'stAdminGenerator', 'Validation');?>
<?php echo st_get_admin_head('stPlatnosciPlPlugin', __('Konfiguracja', array()), __('',array()),array('stPayment'));?>
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels));?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('platnoscipl/index', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form'));?>
                <?php if (!$config->get('configuration_check')): ?>
                    <fieldset>
                        <h2><?php echo __('Zakładanie konta');?></h2>
                        <div class="content">
                            <div class="row">
                                <a href="https://secure.payu.com/cp/register?nsf=true&partnerId=s435fns5" target="_blank" style="margin-left: 5px; text-decoration: underline;"><?php echo __('Jeśli nie masz jeszcze konta w PayU, załóż je tutaj.');?></a>
                            </div>
                        </div>
                    </fieldset>
                <?php endif ?>

                <fieldset>
                    <div class="content">
                        <?php echo st_admin_get_form_field('config[autoredirect]', __('Automatyczne przekierowanie'), 1, 'checkbox_tag', array('checked' => $config->get('autoredirect'), 'help' => __('Przekierowuje automatycznie na stronę płatności po złożeniu zamówienia'))) ?>
                    </div>
                </fieldset>
                <?php foreach ($currencies as $currency): $shortcut = $currency->getShortcut(); $current = $config->get($shortcut); $enabled = $current ? $current['enabled'] : false; ?>                
                    <fieldset>
                        <h2><?php echo __('Waluta');?> <?php echo $shortcut ?></h2>
                        <div class="content">
                            <?php echo st_admin_get_form_field('config['.$shortcut.'][enabled]', __('Włącz'), 1, 'checkbox_tag', array('checked' => $enabled, 'class' => 'payu_enable')) ?>
                            <?php echo st_admin_get_form_field('config['.$shortcut.'][pos_id]', __('Numer PosId'), $current ? $current['pos_id'] : '', 'input_tag', array('required' => true, 'disabled' => !$enabled)) ?>
                            <?php echo st_admin_get_form_field('config['.$shortcut.'][md5_secound_key]', __('Drugi klucz (md5)'), $current ? $current['md5_secound_key'] : '', 'input_tag', array('required' => true, 'disabled' => !$enabled, 'size' => '40')) ?>
                        </div>
                    </fieldset>
                <?php endforeach ?>
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"');?>
                    <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, array('name' => 'save'));?>
                <?php echo st_get_admin_actions_foot();?>
            </form>
        </div>
    </div>
    <br class="st_clear_all" />
<?php echo st_get_admin_foot();?>
<script type="text/javascript">
    jQuery(function($) {
        $('.payu_enable').change(function() {
            var checkbox = $(this);

            checkbox.closest('.content').find('input[type=text]').attr('disabled', !checkbox.prop('checked'))
        });
    });
</script>
