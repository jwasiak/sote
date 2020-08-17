<?php use_helper('Object') ?>
<?php echo select_tag('filters[from_date]', options_for_select(array(
   'day' => __('24h', null, 'stBackend'),
   'week' => __('7 dni', null, 'stBackend'),
   'month' => __('31 dni', null, 'stBackend'),
   'last_login' => __('ostatnie logowanie', null, 'stBackend')
), $filters['from_date'])) ?>