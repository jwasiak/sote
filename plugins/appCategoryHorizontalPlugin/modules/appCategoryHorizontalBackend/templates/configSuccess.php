
<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>

<?php echo st_get_admin_head('appCategoryHorizontalPlugin', __('Poziome kategorie'), __('Konfiguracja poziomego drzewa'), NULL) ?>

<?php if ($sf_flash->has('notice')): ?>
<div class="save-ok">
<h2><?php echo __($sf_flash->get('notice'), null, 'stAdminGeneratorPlugin') ?></h2>
</div>
<?php endif; ?>

<div id="sf_admin_content_config">   
<?php echo form_tag('appCategoryHorizontalBackend/config', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form'));?>
<fieldset>
<div class="st_header"><div><h2><?php echo __('Konfiguracja wyświetlania poziomych kategorii') ?> </h2></div></div>

<div id="sf_fieldset_none_slide" class="st_fieldset-content">

	<div class="form-row">
	  <label><?php echo __('Włącz poziome kategorie') ?>:</label>
	  <div class="content">
	   <?php echo checkbox_tag('categoryHorizontal[menu_on]',true,$config->get('menu_on')) ?>
	   <br class="st_clear_all">
	  </div>
	</div>
        
        <div class="form-row">
	  <label><?php echo __('Drzewo kategorii') ?>:</label>
	  <div class="content">
              <?php if($select!=0): ?>
                 <?php echo select_tag('categoryHorizontal[category_id]', options_for_select($select,
                       array($config->get('category_id'))
                   )) ?>
              <?php else: ?>
                  <?php echo __('Brak drzew kategorii'); ?>
              <?php endif; ?>
            <br class="st_clear_all">
	  </div>
	</div>

        <div class="form-row">
	  <label><?php echo __('Pokaż obrazek kategorii') ?>:</label>
	  <div class="content">
            <?php echo checkbox_tag('categoryHorizontal[image_on]',true,$config->get('image_on')) ?>
            <br class="st_clear_all">
	  </div>
	</div>

        <div class="form-row">
	  <label><?php echo __('Pokaż opis kategorii') ?>:</label>
	  <div class="content">
	   <?php echo checkbox_tag('categoryHorizontal[description_on]',true,$config->get('description_on')) ?>
	   <br class="st_clear_all">
	  </div>
	</div>

	
</div>
</fieldset>
<?php echo st_get_admin_actions_head() ?>
<?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin')) ?>
<?php echo st_get_admin_actions_foot() ?>

</form>
</div>
<br class="st_clear_all">
<?php echo st_get_admin_foot() ?>