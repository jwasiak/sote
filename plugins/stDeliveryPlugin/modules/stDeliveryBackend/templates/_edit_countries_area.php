<?php echo form_error('delivery{countries_area_id}', array('style' => 'color: #FF3333')) ?>
<?php $c = new Criteria() ?>
<?php $c->add(CountriesAreaPeer::IS_ACTIVE, true) ?>
<?php if (CountriesAreaPeer::doCount($c)):  ?>
<?php echo object_select_tag($delivery, 'getCountriesAreaId', array (
  'related_class' => 'CountriesArea',
  'peer_method' => 'doSelectActive',
  'control_name' => 'delivery[countries_area_id]',
  'include_custom' => __('Wybierz strefę'),
)); ?>
<span style="margin-left: 10px"><?php echo st_link_to(__('Konfiguracja stref'), 'stCountriesBackend/countriesAreaList') ?></span>
<?php else: ?>
<?php echo st_link_to(__('Brak aktywnej strefy, przejdź do konfiguracji stref'), 'stCountriesBackend/countriesAreaList') ?>
<?php endif ?>