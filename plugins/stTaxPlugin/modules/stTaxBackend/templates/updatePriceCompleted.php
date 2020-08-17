<?php use_helper('stProgressBar', 'stAdminGenerator', 'stUrl'); ?>

<?php echo st_get_admin_head('stTaxPlugin', null, __('Zarządzaj stawkami VAT'), array('stMailPlugin')) ?>

<div id="sf_admin_content">
<h2 id="st_admin_title"><?php echo __('Przeliczanie cen dla stawki VAT %tax%%', array('%tax%' => $tax->getVat())) ?></h2>
<p><?php echo __('Aktualizacja cen została zakończona pomyślnie.<br/>%return_link%', array('%return_link%' => st_link_to(__('Powróć do edycji'),'stTaxBackend/edit?id='.$this->tax['id']))); ?></p>
</div>
<br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>