<?php echo form_tag('stDeliveryBackend/saveConfig', array('name'=>'config')) ?>

<fieldset>

<?php  $error_time_h_limit = form_error('dateTime{time_h_limit}'); ?>
<?php  $error_time_m_limit = form_error('dateTime{time_m_limit}'); ?>
<?php  $error_time_h_from = form_error('dateTime{time_h_from}'); ?>
<?php  $error_time_m_from = form_error('dateTime{time_m_from}'); ?>
<?php  $error_time_h_to = form_error('dateTime{time_h_to}'); ?>
<?php  $error_time_m_to = form_error('dateTime{time_m_to}'); ?>
<?php  $error_time_h_def = form_error('dateTime{time_h_def}'); ?>
<?php  $error_time_m_def = form_error('dateTime{time_m_def}'); ?>

<?php  $error_array1_from = form_error('dateTime{array1_from}'); ?>
<?php  $error_array1_to = form_error('dateTime{array1_to}'); ?>
<?php  $error_array2_from = form_error('dateTime{array2_from}'); ?>
<?php  $error_array2_to = form_error('dateTime{array2_to}'); ?>
<?php  $error_array3_from = form_error('dateTime{array3_from}'); ?>
<?php  $error_array3_to = form_error('dateTime{array3_to}'); ?>
<?php  $error_array4_from = form_error('dateTime{array4_from}'); ?>
<?php  $error_array4_to = form_error('dateTime{array4_to}'); ?>
<?php  $error_array5_from = form_error('dateTime{array5_from}'); ?>
<?php  $error_array5_to = form_error('dateTime{array5_to}'); ?>
<?php  $error_array6_from = form_error('dateTime{array6_from}'); ?>
<?php  $error_array6_to = form_error('dateTime{array6_to}'); ?>

<?php  $error_min = form_error('dateTime{min}'); ?>
<?php  $error_max = form_error('dateTime{max}'); ?>

<div class="st_header"><div><h2><?php echo __('Konfiguracja daty dostawy') ?> </h2></div></div>
<div class="st_fieldset-content">

<div class="form-row">
    <label><?php echo __('Włącz określenie daty dostawy') ?>:</label>
  <div class="content">
   <?php echo checkbox_tag('dateTime[date_on]',true,$config->get('date_on')) ?>
  <br class="st_clear_all">
  </div>
</div>

<div class="form-row">
   <label><?php echo __('Dostawa najwcześniej po [ilość dni]') ?>:</label>
      <div class="content time">
        <span style="color:red;">
        <?php echo $error_min;?>
        </span>
        <?php echo input_tag('dateTime[min]', $config->get('min'), $config->get('min'), _parse_attributes(array('maxlength'=>'255' ,'class'=>form_has_error('dateTime{min}') ? 'st_form-error' : ''))) ?>
        <br class="st_clear_all">
   </div>
</div>

<div class="form-row">
   <label><?php echo __('Zamówienia przyjmowane do godziny') ?>:</label>
      <div class="content time">
        <span style="color:red;">
        <?php echo $error_time_h_limit;?>
        <?php echo $error_time_m_limit; ?>
        </span>
        <?php echo input_tag('dateTime[time_h_limit]', $config->get('time_h_limit'), $config->get('time_h_limit'), array('maxlength'=>'255')) ?>:
        <?php echo input_tag('dateTime[time_m_limit]', $config->get('time_m_limit'), $config->get('time_m_limit'), array('maxlength'=>'255')) ?>
        <br class="st_clear_all">
   </div>
</div>

<div class="form-row">
   <label><?php echo __('Dostawa najpóźniej do [ilość dni]') ?>:</label>
      <div class="content time">
         <span style="color:red;">
         <?php echo $error_max;?>
            </span>
        <?php echo input_tag('dateTime[max]', $config->get('max'), $config->get('max'), array('maxlength'=>'255')) ?>
        <br class="st_clear_all">
   </div>
</div>
</div>

</fieldset>

<fieldset>
<div class="st_header"><div><h2><?php echo __('Wyłączone daty z dostawy') ?> </h2></div></div>
<div class="st_fieldset-content">

<div class="form-row">
    <label><?php echo __('Wyłącz weekendy') ?>:</label>
     <div class="content">
      <?php echo checkbox_tag('dateTime[weekends_on]',true,$config->get('weekends_on')) ?>
     <br class="st_clear_all">
     </div>
</div>
<script type="text/javascript">

function clearInput(id)
{
 document.getElementById(id).value='';
}
</script>

<div class="form-row">
    <label><?php echo __('Wyłącz przedział') ?>:</label>
     <div class="content">
   <span style="color:red;">
   <?php echo $error_array1_from; ?>
   <?php echo $error_array1_to; ?>
   </span>
   <?php echo __('od') .": ". input_date_tag('dateTime[array1_from]', $config->get('array1_from'), _parse_attributes(array (
  'rich' => true,
  'withtime' => false,
  'culture' => 'pl',
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
  'size' => 8,
           ))); ?><img style="vertical-align:middle;cursor:pointer;" onclick="clearInput('dateTime_array1_from');" src="/images/backend/icons/delete.gif" title="<?php echo __('wyczyść') ?>" alt="<?php echo __('wyczyść') ?>"> &nbsp;&nbsp; <?php echo __('do').": ". input_date_tag('dateTime[array1_to]', $config->get('array1_to'), _parse_attributes(array (
  'rich' => true,
  'withtime' => false,
  'culture' => 'pl',
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
  'size' => 8,
))) ?><img style="vertical-align:middle;cursor:pointer;" onclick="clearInput('dateTime_array1_to');" src="/images/backend/icons/delete.gif" title="<?php echo __('wyczyść') ?>" alt="<?php echo __('wyczyść') ?>">
        <br class="st_clear_all">
     </div>
</div>

<div class="form-row">
    <label><?php echo __('Wyłącz przedział') ?>:</label>
    <div class="content">
   <span style="color:red;">
   <?php echo $error_array2_from; ?>
   <?php echo $error_array2_to; ?>
   </span>
   <?php echo __('od') .": ". input_date_tag('dateTime[array2_from]', $config->get('array2_from'), _parse_attributes(array (
  'rich' => true,
  'withtime' => false,
  'culture' => 'pl',
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
  'size' => 8,
))); ?><img style="vertical-align:middle;cursor:pointer;" onclick="clearInput('dateTime_array2_from');" src="/images/backend/icons/delete.gif" title="<?php echo __('wyczyść') ?>" alt="<?php echo __('wyczyść') ?>"> &nbsp;&nbsp; <?php echo  __('do').": ". input_date_tag('dateTime[array2_to]', $config->get('array2_to'), _parse_attributes(array (
  'rich' => true,
  'withtime' => false,
  'culture' => 'pl',
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
  'size' => 8,
))) ?><img style="vertical-align:middle;cursor:pointer;" onclick="clearInput('dateTime_array2_to');" src="/images/backend/icons/delete.gif" title="<?php echo __('wyczyść') ?>" alt="<?php echo __('wyczyść') ?>">
        <br class="st_clear_all">
     </div>
</div>

<div class="form-row">
    <label><?php echo __('Wyłącz przedział') ?>:</label>
     <div class="content">
   <span style="color:red;">
   <?php echo $error_array3_from; ?>
   <?php echo $error_array3_to; ?>
   </span>
   <?php echo __('od') .": ". input_date_tag('dateTime[array3_from]', $config->get('array3_from'), _parse_attributes(array (
  'rich' => true,
  'withtime' => false,
  'culture' => 'pl',
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
  'size' => 8,
))); ?><img style="vertical-align:middle;cursor:pointer;" onclick="clearInput('dateTime_array3_from');" src="/images/backend/icons/delete.gif" title="<?php echo __('wyczyść') ?>" alt="<?php echo __('wyczyść') ?>"> &nbsp;&nbsp; <?php echo  __('do').": ". input_date_tag('dateTime[array3_to]', $config->get('array3_to'), _parse_attributes(array (
  'rich' => true,
  'withtime' => false,
  'culture' => 'pl',
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
  'size' => 8,
))) ?><img style="vertical-align:middle;cursor:pointer;" onclick="clearInput('dateTime_array3_to');" src="/images/backend/icons/delete.gif" title="<?php echo __('wyczyść') ?>" alt="<?php echo __('wyczyść') ?>">
        <br class="st_clear_all">
     </div>
</div>

<div class="form-row">
    <label><?php echo __('Wyłącz przedział') ?>:</label>
     <div class="content">
   <span style="color:red;">
   <?php echo $error_array4_from; ?>
   <?php echo $error_array4_to; ?>
   </span>
   <?php echo __('od') .": ". input_date_tag('dateTime[array4_from]', $config->get('array4_from'), _parse_attributes(array (
  'rich' => true,
  'withtime' => false,
  'culture' => 'pl',
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
  'size' => 8,
))); ?><img style="vertical-align:middle;cursor:pointer;" onclick="clearInput('dateTime_array4_from');" src="/images/backend/icons/delete.gif" title="<?php echo __('wyczyść') ?>" alt="<?php echo __('wyczyść') ?>"> &nbsp;&nbsp; <?php echo   __('do').": ". input_date_tag('dateTime[array4_to]', $config->get('array4_to'), _parse_attributes(array (
  'rich' => true,
  'withtime' => false,
  'culture' => 'pl',
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
  'size' => 8,
))) ?><img style="vertical-align:middle;cursor:pointer;" onclick="clearInput('dateTime_array4_to');" src="/images/backend/icons/delete.gif" title="<?php echo __('wyczyść') ?>" alt="<?php echo __('wyczyść') ?>">
        <br class="st_clear_all">
     </div>
</div>

<div class="form-row">
    <label><?php echo __('Wyłącz przedział') ?>:</label>
     <div class="content">
   <span style="color:red;">
   <?php echo $error_array5_from; ?>
   <?php echo $error_array5_to; ?>
   </span>
   <?php echo __('od') .": ". input_date_tag('dateTime[array5_from]', $config->get('array5_from'), _parse_attributes(array (
  'rich' => true,
  'withtime' => false,
  'culture' => 'pl',
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
  'size' => 8,
))); ?><img style="vertical-align:middle;cursor:pointer;" onclick="clearInput('dateTime_array5_from');" src="/images/backend/icons/delete.gif" title="<?php echo __('wyczyść') ?>" alt="<?php echo __('wyczyść') ?>"> &nbsp;&nbsp; <?php echo   __('do').": ". input_date_tag('dateTime[array5_to]', $config->get('array5_to'), _parse_attributes(array (
  'rich' => true,
  'withtime' => false,
  'culture' => 'pl',
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
  'size' => 8,
))) ?><img style="vertical-align:middle;cursor:pointer;" onclick="clearInput('dateTime_array5_to');" src="/images/backend/icons/delete.gif" title="<?php echo __('wyczyść') ?>" alt="<?php echo __('wyczyść') ?>">
        <br class="st_clear_all">
     </div>
</div>

<div class="form-row">
    <label><?php echo __('Wyłącz przedział') ?>:</label>
     <div class="content">
   <span style="color:red;">
   <?php echo $error_array6_from; ?>
   <?php echo $error_array6_to; ?>
   </span>
   <?php echo __('od') .": ". input_date_tag('dateTime[array6_from]', $config->get('array6_from'), _parse_attributes(array (
  'rich' => true,
  'withtime' => false,
  'culture' => 'pl',
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
  'size' => 8,
))); ?><img style="vertical-align:middle;cursor:pointer;" onclick="clearInput('dateTime_array6_from');" src="/images/backend/icons/delete.gif" title="<?php echo __('wyczyść') ?>" alt="<?php echo __('wyczyść') ?>"> &nbsp;&nbsp; <?php echo   __('do').": ". input_date_tag('dateTime[array6_to]', $config->get('array6_to'), _parse_attributes(array (
  'rich' => true,
  'withtime' => false,
  'culture' => 'pl',
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
  'readonly' => 'readonly',
  'size' => 8,
))) ?><img style="vertical-align:middle;cursor:pointer;" onclick="clearInput('dateTime_array6_to');" src="/images/backend/icons/delete.gif" title="<?php echo __('wyczyść') ?>" alt="<?php echo __('wyczyść') ?>">
        <br class="st_clear_all">
     </div>
</div>


</div>

</fieldset>


<fieldset>
<div class="st_header"><div><h2><?php echo __('Konfiguracja czasu dostawy') ?> </h2></div></div>
<div class="st_fieldset-content">

<div class="form-row">
    <label><?php echo __('Włącz określanie czasu dostawy') ?>:</label>
  <div class="content">
   <?php echo checkbox_tag('dateTime[time_on]',true,$config->get('time_on')) ?>
  <br class="st_clear_all">
  </div>
</div>

<div class="form-row">
   <label><?php echo __('Minimalna godzina dostawy') ?>:</label>
      <div class="content time">
        <span style="color:red;">
        <?php echo $error_time_h_from;?>
        <?php echo $error_time_m_from;?>
        </span>
        <?php echo input_tag('dateTime[time_h_from]', $config->get('time_h_from'), $config->get('time_h_from'), array('maxlength'=>'255')) ?>:
        <?php echo input_tag('dateTime[time_m_from]', $config->get('time_m_from'), $config->get('time_m_from'), array('maxlength'=>'255')) ?>
        <br class="st_clear_all">
   </div>
</div>

<div class="form-row">
   <label><?php echo __('Maksymalna godzina dostawy') ?>:</label>
      <div class="content time">
      <span style="color:red;">
      <?php echo $error_time_h_to;?>
      <?php echo $error_time_m_to;?>
      </span>
        <?php echo input_tag('dateTime[time_h_to]', $config->get('time_h_to'), $config->get('time_h_to'), array('maxlength'=>'255')) ?>:
        <?php echo input_tag('dateTime[time_m_to]', $config->get('time_m_to'), $config->get('time_m_to'), array('maxlength'=>'255')) ?>
        <br class="st_clear_all">
   </div>
</div>

<div class="form-row">
   <label><?php echo __('Domyślna godzina dostawy') ?>:</label>
      <div class="content time">
      <span style="color:red;">
      <?php echo $error_time_h_def;?>
      <?php echo $error_time_m_def;?>
      </span>
        <?php echo input_tag('dateTime[time_h_def]', $config->get('time_h_def'), $config->get('time_h_def'), array('maxlength'=>'255')) ?>:
        <?php echo input_tag('dateTime[time_m_def]', $config->get('time_m_def'), $config->get('time_m_def'), array('maxlength'=>'255')) ?>
        <br class="st_clear_all">
   </div>
</div>

</div>

</fieldset>


<?php echo st_get_admin_actions_head() ?>
<?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin')) ?>
<?php echo st_get_admin_actions_foot() ?>

</form>