<?php if ($count): ?>
<?php echo object_select_tag($selected, 'getId', array('multiple' => true, 'related_class' => 'Countries', 'peer_method' => 'doSelectActiveBackend', 'control_name' => 'countries_area[edit_countries]')) ?>
<?php else: ?>
<?php echo st_external_link_to(__('Brak aktywnych krajów, przejdź do konfiguracji krajów'), '@stCountriesPluginDefault') ?>
<?php endif; ?>