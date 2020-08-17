<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator', 'stJQueryTools') ?>
<?php echo st_get_admin_head('stTrustPlugin', __('Gwarancja i zaufanie'), array('shortcuts' => array(), 'culture' => $config->getCulture(), 'route' => 'stTrustBackend/config')) ?>


<?php echo form_tag('stTrustBackend/config?culture=' . $config->getCulture(), array("enctype" => "multipart/form-data", 'class' => 'admin_form')) ?>
<div id="sf_admin_content">
     <?php if ($sf_flash->has('notice')) : ?>
          <div class="save-ok">
               <h2><?php echo __($sf_flash->get('notice'), null, 'stAdminGeneratorPlugin') ?></h2>
          </div>
     <?php endif; ?>

     <fieldset>
          <div class="st_header">
               <div>
                    <h2><?php echo __('Tekst pod przyciskiem koszyka') ?> </h2>
               </div>
          </div>
          <div id="sf_fieldset_none_slide" class="st_fieldset-content">

               <div class="row">

                    <div class="form-row">
                         <label><?php echo __('Włącz') ?>:</label>
                         <div class="content">
                              <?php echo checkbox_tag('trust[field_on]', true, $config->get('field_on')) ?>
                              <br class="st_clear_all">
                         </div>
                    </div>

                    <div class="form-row">
                         <label><?php echo __('Opis') ?>:</label>
                         <div class="content">
                              <?php echo textarea_tag("trust[field_description]", $config->get('field_description', null, true), array('size' => '60x6', 'rich' => true, 'tinymce_options' => "height:80,width:'60%'")) ?>
                              <br class="st_clear_all">
                         </div>
                    </div>

               </div>
     </fieldset>


     <fieldset>
          <h2><?php echo __('Dostawa') ?> </h2>
          <div class="content">
               <div class="form-row">
                    <label><?php echo __('Włącz') ?>:</label>
                    <div class="content">
                         <?php echo checkbox_tag('trust[field_1_on]', true, $config->get('field_1_on')) ?>
                         <br class="st_clear_all">
                    </div>
               </div>

               <?php echo st_admin_get_form_field('trust[field_label_1]',  __('Tytuł'), $config->get('field_label_1', null, true), 'input_tag', array('size' => '12', 'maxlength' => '10', 'help' => __('max 10 znaków'))) ?>

               <?php echo st_admin_get_form_field('trust[field_sub_label_1]',  __('Podtytuł'), $config->get('field_sub_label_1', null, true), 'input_tag', array('size' => '12', 'maxlength' => '12', 'help' => __('max 12 znaków'))) ?>

               <div class="form-row">
                    <label><?php echo __('Ikona') ?>:<a class="help" title="<?php echo __('Rozmiar ikonki 30x30px') ?>" href="#"></a></label>
                    <div class="content">
                         <?php echo input_file_tag("trust[icon_1]", ""); ?><br />
                         <?php if ($config->get('icon_1', null, true) != "") : ?>
                              <img src="/uploads<?php echo $config->get('icon_1', null, true); ?>" alt="" style="max-width: 100px; margin-top: 7px;"><br />
                              <?php echo link_to(__('Usuń ikone'), 'stTrustBackend/deleteImage?image=icon_1&culture=' . $config->getCulture()) ?>
                              <br class="st_clear_all">
                         <?php endif; ?>
                    </div>
               </div>

               <div class="form-row">
                    <label><?php echo __('Opis') ?>:</label>
                    <div class="content">
                         <?php echo textarea_tag("trust[field_description_1]", $config->get('field_description_1', null, true), array('size' => '60x6', 'rich' => true, 'tinymce_options' => "height:80,width:'60%'")) ?>
                         <br class="st_clear_all">
                    </div>
               </div>
          </div>
     </fieldset>

     <fieldset>
          <h2><?php echo __('Gwarancja') ?> </h2>
          <div class="content">
               <div class="form-row">
                    <label><?php echo __('Włącz') ?>:</label>
                    <div class="content">
                         <?php echo checkbox_tag('trust[field_2_on]', true, $config->get('field_2_on')) ?>
                         <br class="st_clear_all">
                    </div>
               </div>

               <?php echo st_admin_get_form_field('trust[field_label_2]',  __('Tytuł'), $config->get('field_label_2', null, true), 'input_tag', array('size' => '12', 'maxlength' => '10', 'help' => __('max 10 znaków'))) ?>

               <?php echo st_admin_get_form_field('trust[field_sub_label_2]',  __('Podtytuł'), $config->get('field_sub_label_2', null, true), 'input_tag', array('size' => '12', 'maxlength' => '12', 'help' => __('max 12 znaków'))) ?>

               <div class="form-row">
                    <label><?php echo __('Ikona') ?>:<a class="help" title="<?php echo __('Rozmiar ikonki 30x30px') ?>" href="#"></a></label>
                    <div class="content">
                         <?php echo input_file_tag("trust[icon_2]", ""); ?><br />
                         <?php if ($config->get('icon_1', null, true) != "") : ?>
                              <img src="/uploads<?php echo $config->get('icon_2', null, true); ?>" alt="" style="max-width: 100px; margin-top: 7px;"><br />
                              <?php echo link_to(__('Usuń ikone'), 'stTrustBackend/deleteImage?image=icon_2&culture=' . $config->getCulture()) ?>
                              <br class="st_clear_all">
                         <?php endif; ?>
                    </div>
               </div>

               <div class="form-row">
                    <label><?php echo __('Opis') ?>:</label>
                    <div class="content">
                         <?php echo textarea_tag("trust[field_description_2]", $config->get('field_description_2', null, true), array('size' => '60x6', 'rich' => true, 'tinymce_options' => "height:80,width:'60%'")) ?>
                         <br class="st_clear_all">
                    </div>
               </div>
          </div>
     </fieldset>

     <fieldset>
          <h2><?php echo __('Zwrot') ?></h2>
          <div class="content">
               <div class="form-row">
                    <label><?php echo __('Włącz') ?>:</label>
                    <div class="content">
                         <?php echo checkbox_tag('trust[field_3_on]', true, $config->get('field_3_on')) ?>
                         <br class="st_clear_all">
                    </div>
               </div>

               <?php echo st_admin_get_form_field('trust[field_label_3]',  __('Tytuł'), $config->get('field_label_3', null, true), 'input_tag', array('size' => '12', 'maxlength' => '10', 'help' => __('max 10 znaków'))) ?>

               <?php echo st_admin_get_form_field('trust[field_sub_label_3]',  __('Podtytuł'), $config->get('field_sub_label_3', null, true), 'input_tag', array('size' => '12', 'maxlength' => '12', 'help' => __('max 12 znaków'))) ?>

               <div class="form-row">
                    <label><?php echo __('Ikona') ?>:<a class="help" title="<?php echo __('Rozmiar ikonki 30x30px') ?>" href="#"></a></label>
                    <div class="content">
                         <?php echo input_file_tag("trust[icon_3]", ""); ?><br />
                         <?php if ($config->get('icon_3', null, true) != "") : ?>
                              <img src="/uploads<?php echo $config->get('icon_3', null, true); ?>" alt="" style="max-width: 100px; margin-top: 7px;"><br />
                              <?php echo link_to(__('Usuń ikone'), 'stTrustBackend/deleteImage?image=icon_3&culture=' . $config->getCulture()) ?>
                              <br class="st_clear_all">
                         <?php endif; ?>
                    </div>
               </div>

               <div class="form-row">
                    <label><?php echo __('Opis') ?>:</label>
                    <div class="content">
                         <?php echo textarea_tag("trust[field_description_3]", $config->get('field_description_3', null, true), array('size' => '60x6', 'rich' => true, 'tinymce_options' => "height:80,width:'60%'")) ?>
                         <br class="st_clear_all">
                    </div>
               </div>
          </div>
     </fieldset>

    <div id="edit_actions">
     <?php echo st_get_admin_actions_head() ?>
     <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array("name" => "save",)) ?>
     <?php echo st_get_admin_actions_foot() ?>
     </div>
     
     
</div>



</form>

<script type="text/javascript">
jQuery(function($) {
    $(document).ready(function() {
        $('#edit_actions').stickyBox();
    });

});
</script>



<br class="st_clear_all">
<?php echo st_get_admin_foot() ?>