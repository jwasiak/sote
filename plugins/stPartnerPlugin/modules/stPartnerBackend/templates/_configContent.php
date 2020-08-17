<?php use_stylesheet("backend/stInvoiceBackend.css"); ?>
<?php echo form_tag('stPartnerBackend/SaveConfigContent') ?>
   <?php if ($sf_flash->has('notice')): ?>
      <div class="save-ok">
         <h2><?php echo __($sf_flash->get('notice'), array(), 'stAdminGeneratorPlugin');?></h2>
      </div>
   <?php endif; ?>

   <fieldset id="sf_fieldset_none" class="">
      <div class="content" id="sf_fieldset_none_slide">
   
         <div class="form-row" style="padding-top: 5px;">
            <label><?php echo __('Włącz system partnerski') ?>:</label>
            <div class="content">
               <?php echo checkbox_tag('config[is_active]', 1, $config['is_active']) ?>
               <br class="st_clear_all">
            </div>
         </div>

         <div class="form-row" style="padding-bottom: 5px;">
            <label><?php echo __('Czas trwania cookie (dni)') ?>:</label>
            <div class="content">
               <?php echo select_tag("config[cookie_day_expire]", options_for_select(
                  array(
                  '1' => 1,
                  '2' => 2,
                  '3' => 3,
                  '4' => 4,
                  '5' => 5,
                  '6' => 6,
                  '7' => 7,
                  '8' => 8,
                  '9' => 9,
                  '10' => 10,
                  '11' => 11,
                  '12' => 12,
                  '13' => 13,
                  '14' => 14,
                  '15' => 15,
                  '16' => 16,
                  '17' => 17,
                  '18' => 18,
                  '19' => 19,
                  '20' => 20,
                  '21' => 21,
                  '22' => 22,
                  '23' => 23,
                  '24' => 24,
                  '25' => 25,
                  '26' => 26,
                  '27' => 27,
                  '28' => 28,
                  '29' => 29,
                  '30' => 30,
                  ),
                  array($config['cookie_day_expire'])
      			)) ?>
             <br class="st_clear_all">
            </div>
         </div>

      <br class="st_clear_all">
 
      </div>
   </fieldset>

   <?php echo st_get_admin_actions_head() ?>
      <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin')) ?>
   <?php echo st_get_admin_actions_foot() ?>  

</form>