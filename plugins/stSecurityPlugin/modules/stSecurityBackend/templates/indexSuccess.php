<?php use_helper('stAdminGenerator') ?>
<?php echo st_get_admin_head('stSecurityPlugin', __('Konfiguracja', null, 'stBackend'), __('Bezpieczeństwo'), array()) ?>
<div id="sf_admin_content">
   <?php st_include_partial('stAdminGenerator/message') ?>
   <?php echo form_tag('stSecurityBackend/index', array('id' => 'sf_admin_config_form')) ?>
      <fieldset id="sf_fieldset-none">
         <div class="st_fieldset-content" style="padding-bottom: 10px; padding-top: 10px;">
            <div class="row" style="padding: 4px 10px;">
               <label for="security_captcha_on" style="float: left; padding-right: 10px; text-align: right; width: 220px;"><?php echo __('Włącz kody CAPTCHA') . "<a href='#'' class='help' title='" . __('Włącza zabezpieczenia antyspamowe w sklepie') . "'></a>:" ?></label>
               <div class="field"><?php echo checkbox_tag('security[captcha_on]',true,$config->get('captcha_on')) ?></div>
               <div class="clr"></div>
            </div>
            <div class="row" style="padding: 4px 10px;">
               <label for="security_ssl" style="float: left; padding-right: 10px; text-align: right; width: 220px;"><?php echo __('Włącz SSL') . "<a href='#'' class='help' title='" . __('Włącza obsługe protokołu bezpieczeństwa SSL') . "'></a>:" ?></label>
               <div class="field<?php if ($sf_request->hasError('security{ssl}')): ?> form-error<?php endif; ?>" style="margin-left: 230px;">
                  <?php if ($sf_request->hasError('security{ssl}')): ?>
                     <?php echo form_error('security{ssl}', array('class' => 'form-error-msg')) ?>
                  <?php endif; ?>
                  <?php echo select_tag('security[ssl]', options_for_select(array("" => __("Wyłączony"), "shop" => __("Dla całego sklepu"), "order" => __("Dla procesu zamówienia i konta klienta")), $config->get('ssl') === '1' ? 'order' : $config->get('ssl'))) ?>
               <div class="clr"></div>
            </div>
         </div>
      </fieldset>
      <?php echo st_get_admin_actions_head() ?>
      <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array ('name' => 'save')) ?>
      <?php echo st_get_admin_actions_foot() ?>
   </form>
</div>
<br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>