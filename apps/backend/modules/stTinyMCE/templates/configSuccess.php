<?php
use_helper('stAdminGenerator');
?>

<div id="sf_admin_content">
<?php st_include_partial('stTinyMCE/header', array('title' => __('Konfiguracja'))); ?>
   <?php st_include_partial('stAdminGenerator/message') ?>
   <?php echo form_tag('@stTinyMCE', array('id' => 'sf_admin_config_form', 'class' => "admin_form")) ?>
      <fieldset>
         <div class="content">
            <?php echo st_admin_get_form_field('config[advanced]', $labels['config{advanced}'], 1, 'checkbox_tag', array('checked' => $config->get('advanced'))); ?>
         </div>
      </fieldset>
      <?php echo st_get_admin_actions_head() ?>
      <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array ('name' => 'save')) ?>
      <?php echo st_get_admin_actions_foot() ?>
   </form>

<?php st_include_partial('stTinyMCE/footer'); ?>
</div>