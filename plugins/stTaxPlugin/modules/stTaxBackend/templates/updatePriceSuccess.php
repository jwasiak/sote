<?php use_helper('stProgressBar', 'stAdminGenerator'); ?>

<?php st_include_partial('stTaxBackend/header', array('related_object' => $tax, 'title' => $title, 'route' => 'stTaxBackend/edit?id='.$tax->getId())) ?>

<style type="text/css">
#tax_progress_bar {
    padding: 10px;
    text-align: center;
    width: 280px;
    margin: 0 auto;
}

#tax_progress_bar .stPrograssBar-main-div {
    margin: 0 auto;
}
</style>

<div id="sf_admin_content">
    <div class="fieldset" id="tax_progress_bar">
<?php if (isset($params['type'])): ?>
        <?php echo progress_bar('stTax', 'stTaxProgressBar', 'updateProductPrice', $steps); ?>
<?php else: ?>
        <p><?php echo __('Aktualizacja cen została zakończona pomyślnie.<br/>%return_link%', array('%return_link%' => st_link_to(__('Powróć do edycji'),'stTaxBackend/edit?id='.$tax->getId()))); ?></p>
<?php endif; ?>
    </div>
</div>

<?php st_include_partial('stTaxBackend/footer', array('related_object' => $tax)) ?>