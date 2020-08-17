<?php use_helper('stProgressBar', 'stAdminGenerator'); ?>

<?php echo st_get_admin_head('stGroupPricePlugin', null, __('Ceny grupowe')) ?>
<?php st_include_component('stGroupPriceBackend', 'listMenu') ?>
<div id="sf_admin_content">
<h2 id="st_admin_title"><?php echo __('Zmiana cen dla grupy "').$groupPriceName; ?>"</h2>


<?php echo progress_bar('stChangePrice', 'stChangePriceProgressBar', 'send', $count); ?>

</div>
<br class="st_clear_all" />



<?php echo st_get_admin_foot() ?>