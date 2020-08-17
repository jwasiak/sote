<?php
use_helper('I18N', 'stAdminGenerator');
use_stylesheet('backend/appAdditionalDescPlugin.css');

$checked_right = "";
$checked_before = "";
$checked_after = "";

if ($config->get('desc2_position', 'right') == "right")
    $checked_right = true;
if ($config->get('desc2_position', 'right') == "before")
    $checked_before = true;
if ($config->get('desc2_position', 'right') == "after")
    $checked_after = true;   

echo st_get_admin_head(array('@appAdditionalDescPlugin', __('Dodatkowy opis produktu'), '/images/backend/main/icons/red/appAdditionalDescPlugin.png'), __('Konfiguracja'), array());
?> 



<?php if ($sf_flash->has('notice')): ?>
    <div class="save-ok" style="margin: 10px;">
        <h2><?php echo $sf_flash->get('notice') ?></h2>
    </div>
<?php endif; ?>

<?php echo form_tag('appAdditionalDescBackend/index', array(
  'id'        => 'sf_admin_edit_form',
  'name'      => 'sf_admin_edit_form',
  'multipart' => true,
  'class'     => 'admin_form',
  'style'     => 'margin: 10px'
)) ?>

<fieldset>
<div id="sf_fieldset_none_slide" class="st_fieldset-content">
    <div class="form-row">
        <label style="width: 200px;"><?php echo __('Pokaż dodatkowy opis') ?>:</label>
        <div class="content">
<?php echo checkbox_tag('additional_desc[desc2_on]', true, $config->get('desc2_on')) ?>
            <br class="st_clear_all">
        </div>
    </div>
    <div class="form-row">
        <label style="width: 200px;"><?php echo __('Wyświetlanie dodatkowego opisu') ?>:</label>
        <div class="content">
            <div id="desc2_views">
                <div class="view"><img src="/images/backend/appAdditionalDescPlugin/desc1.jpg"><br />
                    <?php echo radiobutton_tag('additional_desc[desc2_position]', 'right', $checked_right); ?>
                </div>
                <div class="view"><img src="/images/backend/appAdditionalDescPlugin/desc2.jpg"><br />
<?php echo radiobutton_tag('additional_desc[desc2_position]', 'after', $checked_after); ?> 
                </div>
                <div class="view"><img src="/images/backend/appAdditionalDescPlugin/desc3.jpg"><br />
<?php echo radiobutton_tag('additional_desc[desc2_position]', 'before', $checked_before); ?>
                </div>
            </div>
            <br class="st_clear_all">
        </div>
    </div>

</div>
</fieldset>

<?php echo st_get_admin_actions_head() ?>
<?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
<?php echo st_get_admin_actions_foot() ?>

</form>

<br class="st_clear_all">
<?php echo st_get_admin_foot() ?>